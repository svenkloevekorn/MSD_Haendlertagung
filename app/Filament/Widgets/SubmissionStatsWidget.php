<?php

namespace App\Filament\Widgets;

use App\Models\Dealer;
use App\Models\Download;
use App\Models\FormSubmission;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubmissionStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $totalDealers = Dealer::count();
        $submissions = FormSubmission::all();

        // Registration: count per item + all complete
        $regSubs = $submissions->where('form_slug', FormSubmission::FORM_REGISTRATION);
        $factoryDone = 0;
        $activitiesDone = 0;
        $allergiesDone = 0;
        $mobileDone = 0;
        $regComplete = 0;

        foreach ($regSubs as $sub) {
            $d = $sub->data;
            $hasFactory = ! empty($d['factory_tour'] ?? null);
            $hasActivities = ! empty($d['activity_1'] ?? null) && ! empty($d['activity_2'] ?? null) && ! empty($d['activity_3'] ?? null);
            $hasAllergies = ! empty($d['allergies'] ?? null) || ($d['no_allergies'] ?? '') === 'true';
            $hasCompanion = ($d['no_companion'] ?? '') === 'true' || ! empty($d['companion_mobile'] ?? null);
            $hasMobile = ! empty($d['mobile'] ?? null) && $hasCompanion;

            if ($hasFactory) $factoryDone++;
            if ($hasActivities) $activitiesDone++;
            if ($hasAllergies) $allergiesDone++;
            if ($hasMobile) $mobileDone++;
            if ($hasFactory && $hasActivities && $hasAllergies && $hasMobile) $regComplete++;
        }

        // Market Info: all 5 fields filled or delegated
        $marketComplete = 0;
        foreach ($submissions->where('form_slug', FormSubmission::FORM_MARKET_INFO) as $sub) {
            $d = $sub->data;
            if (! empty($d['delegated_to'] ?? null)
                || (! empty($d['market_share'] ?? null)
                && ! empty($d['challenges'] ?? null)
                && ! empty($d['chances_potential'] ?? null)
                && ! empty($d['competitors'] ?? null)
                && ! empty($d['expectations'] ?? null))) {
                $marketComplete++;
            }
        }

        // Feedback: rating + all category stars + all text fields
        $feedbackComplete = 0;
        $starCats = ['accommodation', 'catering', 'program', 'presentations', 'organisation'];
        foreach ($submissions->where('form_slug', FormSubmission::FORM_FEEDBACK) as $sub) {
            $d = $sub->data;
            $complete = ! empty($d['rating'] ?? null);
            foreach ($starCats as $cat) {
                if (empty($d["rating_{$cat}"] ?? null)) $complete = false;
            }
            foreach (['liked', 'improve', 'topics', 'additional_comments'] as $f) {
                if (empty($d[$f] ?? null)) $complete = false;
            }
            if ($complete) $feedbackComplete++;
        }

        $overdueCount = self::countOverdue($submissions, $totalDealers);

        return [
            Stat::make('Factory Tour', $factoryDone . ' / ' . $totalDealers)
                ->description('Deadline: May 1')
                ->color($factoryDone >= $totalDealers ? 'success' : 'warning'),
            Stat::make('Activities', $activitiesDone . ' / ' . $totalDealers)
                ->description('Deadline: May 1')
                ->color($activitiesDone >= $totalDealers ? 'success' : 'warning'),
            Stat::make('Allergies', $allergiesDone . ' / ' . $totalDealers)
                ->description('Deadline: June 1')
                ->color($allergiesDone >= $totalDealers ? 'success' : 'warning'),
            Stat::make('Mobile Numbers', $mobileDone . ' / ' . $totalDealers)
                ->description('Deadline: June 10')
                ->color($mobileDone >= $totalDealers ? 'success' : 'warning'),
            Stat::make('Market Info', $marketComplete . ' / ' . $totalDealers)
                ->description('Deadline: May 15')
                ->color($marketComplete >= $totalDealers ? 'success' : 'warning'),
            Stat::make('Feedback', $feedbackComplete . ' / ' . $totalDealers)
                ->description('Complete submissions')
                ->color($feedbackComplete >= $totalDealers ? 'success' : 'warning'),
            Stat::make('Overdue', $overdueCount)
                ->description('Dealers with missed deadlines')
                ->color($overdueCount === '0' ? 'success' : 'danger'),
            Stat::make('Downloads', (string) Download::sum('download_count'))
                ->description('Total file downloads')
                ->color('gray'),
        ];
    }

    private static function countOverdue($submissions, int $totalDealers): string
    {
        $today = Carbon::today();
        $deadlines = [
            'factory_tour' => '2026-05-01',
            'activities' => '2026-05-01',
            'market_info' => '2026-05-15',
            'allergies' => '2026-06-01',
            'mobile_numbers' => '2026-06-10',
        ];

        if (! collect($deadlines)->contains(fn ($date) => $today->greaterThan($date))) {
            return '0';
        }

        $regByDealer = $submissions->where('form_slug', FormSubmission::FORM_REGISTRATION)->keyBy('dealer_id');
        $marketByDealer = $submissions->where('form_slug', FormSubmission::FORM_MARKET_INFO)->keyBy('dealer_id');

        $overdueCount = 0;
        foreach (Dealer::pluck('id') as $dealerId) {
            $reg = $regByDealer->get($dealerId)?->data ?? [];
            $market = $marketByDealer->get($dealerId)?->data ?? [];
            $isOverdue = false;

            if ($today->greaterThan($deadlines['factory_tour']) && empty($reg['factory_tour'] ?? null)) {
                $isOverdue = true;
            }
            if ($today->greaterThan($deadlines['activities'])
                && (empty($reg['activity_1'] ?? null) || empty($reg['activity_2'] ?? null) || empty($reg['activity_3'] ?? null))) {
                $isOverdue = true;
            }
            if ($today->greaterThan($deadlines['market_info'])) {
                $hasMarket = !empty($market['delegated_to'] ?? null)
                    || (!empty($market['market_share'] ?? null) && !empty($market['challenges'] ?? null)
                    && !empty($market['chances_potential'] ?? null) && !empty($market['competitors'] ?? null)
                    && !empty($market['expectations'] ?? null));
                if (!$hasMarket) $isOverdue = true;
            }
            if ($today->greaterThan($deadlines['allergies']) && empty($reg['allergies'] ?? null) && ($reg['no_allergies'] ?? '') !== 'true') {
                $isOverdue = true;
            }
            if ($today->greaterThan($deadlines['mobile_numbers'])) {
                $hasCompanion = ($reg['no_companion'] ?? '') === 'true' || !empty($reg['companion_mobile'] ?? null);
                if (empty($reg['mobile'] ?? null) || !$hasCompanion) $isOverdue = true;
            }

            if ($isOverdue) $overdueCount++;
        }

        return (string) $overdueCount;
    }
}
