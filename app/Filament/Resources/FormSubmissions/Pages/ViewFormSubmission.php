<?php

namespace App\Filament\Resources\FormSubmissions\Pages;

use App\Filament\Resources\FormSubmissions\FormSubmissionResource;
use App\Models\FormSubmission;
use Filament\Actions\DeleteAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewFormSubmission extends ViewRecord
{
    protected static string $resource = FormSubmissionResource::class;

    private static array $fieldLabels = [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email',
        'mobile' => 'Mobile Number',
        'company' => 'Company',
        'no_companion' => 'No Accompanying Person',
        'companion_mobile' => 'Mobile (Accompanying Person)',
        'activity_1' => 'Activity 1st Choice',
        'activity_2' => 'Activity 2nd Choice',
        'activity_3' => 'Activity 3rd Choice',
        'no_allergies' => 'No Allergies',
        'allergies' => 'Allergies / Intolerances',
        'factory_tour' => 'Factory Tour',
        'whatsapp' => 'WhatsApp Group',
        'comments' => 'Comments',
        'delegated_to' => 'Delegated to Colleague',
        'number_of_corrugators' => 'Number of Corrugators',
        'total_belt_market_size_m2' => 'Total Belt Market Size (m²)',
        'machine_width_lt_22' => 'Machine Width < 2.2 m (%)',
        'machine_width_22_24' => 'Machine Width 2.2 - 2.4 m (%)',
        'machine_width_25_27' => 'Machine Width 2.5 - 2.7 m (%)',
        'machine_width_28_30' => 'Machine Width 2.8 - 3.0 m (%)',
        'machine_width_gt_30' => 'Machine Width > 3.0 m (%)',
        'machine_speed_lt_60' => 'Machine Speed < 60 m/min',
        'machine_speed_60_100' => 'Machine Speed 60 - 100 m/min',
        'machine_speed_100_150' => 'Machine Speed 100 - 150 m/min',
        'machine_speed_150_200' => 'Machine Speed 150 - 200 m/min',
        'machine_speed_200_300' => 'Machine Speed 200 - 300 m/min',
        'machine_speed_gt_300' => 'Machine Speed > 300 m/min',
        'owner_groups_pct' => 'Owner: Groups (%)',
        'owner_independents_pct' => 'Owner: Independents (%)',
        'market_share' => 'MS Market Share',
        'challenges' => 'Challenges',
        'chances_potential' => 'Chances / Potential',
        'competitors' => 'Competitors and their Strengths',
        'expectations' => 'Expectations / Requests to MS',
        'ms_market_share_pct' => 'Mühlen Sohn Market Share (%)',
        'competitor_a_name' => 'Competitor A: Name',
        'competitor_a_pct' => 'Competitor A: Market Share (%)',
        'competitor_b_name' => 'Competitor B: Name',
        'competitor_b_pct' => 'Competitor B: Market Share (%)',
        'competitor_c_name' => 'Competitor C: Name',
        'competitor_c_pct' => 'Competitor C: Market Share (%)',
        'others_market_share_pct' => 'Others Market Share (%)',
        'order_situation' => 'Market Situation: Order Situation',
        'price_level' => 'Market Situation: Price Level',
        'capacity_utilization' => 'Market Situation: Capacity Utilization',
        'machine_investments' => 'Market Situation: Machine Investments',
        'role_of_large_groups' => 'Market Situation: Role of Large Groups',
        'swot_strengths' => 'SWOT: Strengths',
        'swot_weaknesses' => 'SWOT: Weaknesses',
        'swot_opportunities' => 'SWOT: Opportunities',
        'swot_threats' => 'SWOT: Threats',
        'name' => 'Name',
        'subject' => 'Subject',
        'message' => 'Message',
        'rating' => 'Overall Rating',
        'rating_accommodation' => 'Rating: Accommodation',
        'comment_accommodation' => 'Comment: Accommodation',
        'rating_catering' => 'Rating: Food & Catering',
        'comment_catering' => 'Comment: Food & Catering',
        'rating_program' => 'Rating: Program',
        'comment_program' => 'Comment: Program',
        'rating_presentations' => 'Rating: Presentations',
        'comment_presentations' => 'Comment: Presentations',
        'rating_organisation' => 'Rating: Organisation',
        'comment_organisation' => 'Comment: Organisation',
        'rating_further' => 'Rating: Further',
        'comment_further' => 'Comment: Further',
        'liked' => 'What they liked',
        'improve' => 'What to improve',
        'topics' => 'Suggested Topics',
        'additional_comments' => 'Additional Comments',
    ];

    public function infolist(Schema $schema): Schema
    {
        $record = $this->record;
        $data = $record->data ?? [];

        $entries = [
            TextEntry::make('form_slug')
                ->label('Form')
                ->formatStateUsing(fn (string $state): string => FormSubmission::$formLabels[$state] ?? $state),
            TextEntry::make('created_at')
                ->label('Submitted')
                ->dateTime('d.m.Y H:i'),
        ];

        $fieldEntries = [];
        foreach ($data as $key => $value) {
            $label = self::$fieldLabels[$key] ?? ucfirst(str_replace('_', ' ', $key));

            if (is_bool($value)) {
                $displayValue = $value ? 'Yes' : 'No';
            } else {
                $displayValue = $value ?: '-';
            }

            $fieldEntries[] = TextEntry::make("data.{$key}")
                ->label($label)
                ->getStateUsing(fn () => $displayValue);
        }

        return $schema
            ->components([
                Section::make('Submission')
                    ->columns(2)
                    ->schema($entries),
                Section::make('Form Data')
                    ->columns(2)
                    ->schema($fieldEntries),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
