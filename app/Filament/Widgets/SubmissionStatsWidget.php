<?php

namespace App\Filament\Widgets;

use App\Models\Dealer;
use App\Models\FormSubmission;
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
        $allergiesDone = 0;
        $mobileDone = 0;
        $regComplete = 0;

        foreach ($regSubs as $sub) {
            $d = $sub->data;
            $hasFactory = ! empty($d['factory_tour'] ?? null);
            $hasAllergies = ! empty($d['allergies'] ?? null) || ($d['no_allergies'] ?? '') === 'true';
            $hasCompanion = ($d['no_companion'] ?? '') === 'true' || ! empty($d['companion_mobile'] ?? null);
            $hasMobile = ! empty($d['mobile'] ?? null) && $hasCompanion;

            if ($hasFactory) $factoryDone++;
            if ($hasAllergies) $allergiesDone++;
            if ($hasMobile) $mobileDone++;
            if ($hasFactory && $hasAllergies && $hasMobile) $regComplete++;
        }

        // Market Info: all 5 fields filled
        $marketComplete = 0;
        foreach ($submissions->where('form_slug', FormSubmission::FORM_MARKET_INFO) as $sub) {
            $d = $sub->data;
            if (! empty($d['market_share'] ?? null)
                && ! empty($d['challenges'] ?? null)
                && ! empty($d['chances_potential'] ?? null)
                && ! empty($d['competitors'] ?? null)
                && ! empty($d['expectations'] ?? null)) {
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

        return [
            Stat::make('Registration', $regComplete . ' / ' . $totalDealers)
                ->description("Factory Tour: {$factoryDone} · Allergies: {$allergiesDone} · Mobile: {$mobileDone}")
                ->color($regComplete >= $totalDealers ? 'success' : 'warning'),
            Stat::make('Market Info', $marketComplete . ' / ' . $totalDealers)
                ->description('Complete submissions')
                ->color($marketComplete >= $totalDealers ? 'success' : 'warning'),
            Stat::make('Feedback', $feedbackComplete . ' / ' . $totalDealers)
                ->description('Complete submissions')
                ->color($feedbackComplete >= $totalDealers ? 'success' : 'warning'),
        ];
    }
}
