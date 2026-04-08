<?php

namespace App\Filament\Widgets;

use App\Models\Dealer;
use App\Models\FormSubmission;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class OverdueDealersWidget extends TableWidget
{
    protected static ?string $heading = 'Overdue Submissions';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    private static array $deadlines = [
        'factory_tour' => '2026-05-01',
        'activities' => '2026-05-01',
        'market_info' => '2026-05-15',
        'allergies' => '2026-06-01',
        'mobile_numbers' => '2026-06-10',
    ];

    private static ?Collection $overdueIds = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(Dealer::whereIn('id', self::getOverdueDealerIds()))
            ->emptyStateHeading('No overdue submissions')
            ->emptyStateDescription('All dealers are currently on track with their deadlines.')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Dealer')
                    ->getStateUsing(fn (Dealer $r) => $r->first_name . ' ' . $r->last_name)
                    ->searchable(query: fn (Builder $query, string $search) => $query
                        ->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")),
                TextColumn::make('country')
                    ->label('Country'),
                TextColumn::make('overdue')
                    ->label('Overdue Items')
                    ->getStateUsing(fn (Dealer $r) => self::getOverdueItems($r))
                    ->formatStateUsing(fn ($state) => new HtmlString($state))
                    ->wrap(),
            ])
            ->defaultSort('last_name')
            ->paginated([10, 25, 50]);
    }

    private static function getOverdueDealerIds(): Collection
    {
        if (self::$overdueIds !== null) {
            return self::$overdueIds;
        }

        $ids = collect();
        $today = Carbon::today();

        // Only check if at least one deadline has passed
        $anyPassed = collect(self::$deadlines)->contains(fn ($date) => $today->greaterThan($date));
        if (! $anyPassed) {
            return self::$overdueIds = $ids;
        }

        foreach (Dealer::all() as $dealer) {
            if (self::getOverdueItems($dealer) !== '') {
                $ids->push($dealer->id);
            }
        }

        return self::$overdueIds = $ids;
    }

    private static function getOverdueItems(Dealer $dealer): string
    {
        $today = Carbon::today();
        $regData = FormSubmission::where('form_slug', FormSubmission::FORM_REGISTRATION)
            ->where('dealer_id', $dealer->id)->first()?->data ?? [];
        $marketData = FormSubmission::where('form_slug', FormSubmission::FORM_MARKET_INFO)
            ->where('dealer_id', $dealer->id)->first()?->data ?? [];

        $overdue = [];

        // Factory Tour - May 1
        if ($today->greaterThan(self::$deadlines['factory_tour']) && empty($regData['factory_tour'] ?? null)) {
            $overdue[] = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">Factory Tour</span>';
        }

        // Activities - May 1
        if ($today->greaterThan(self::$deadlines['activities'])
            && (empty($regData['activity_1'] ?? null) || empty($regData['activity_2'] ?? null) || empty($regData['activity_3'] ?? null))) {
            $overdue[] = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">Activities</span>';
        }

        // Market Info - May 15
        $hasMarketInfo = ! empty($marketData['market_share'] ?? null)
            && ! empty($marketData['challenges'] ?? null)
            && ! empty($marketData['chances_potential'] ?? null)
            && ! empty($marketData['competitors'] ?? null)
            && ! empty($marketData['expectations'] ?? null);
        if ($today->greaterThan(self::$deadlines['market_info']) && ! $hasMarketInfo) {
            $overdue[] = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">Market Info</span>';
        }

        // Allergies - June 1
        if ($today->greaterThan(self::$deadlines['allergies'])
            && empty($regData['allergies'] ?? null)
            && ($regData['no_allergies'] ?? '') !== 'true') {
            $overdue[] = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">Allergies</span>';
        }

        // Mobile Numbers - June 10
        $hasCompanion = ($regData['no_companion'] ?? '') === 'true' || ! empty($regData['companion_mobile'] ?? null);
        if ($today->greaterThan(self::$deadlines['mobile_numbers'])
            && (empty($regData['mobile'] ?? null) || ! $hasCompanion)) {
            $overdue[] = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">Mobile Numbers</span>';
        }

        return implode(' ', $overdue);
    }
}
