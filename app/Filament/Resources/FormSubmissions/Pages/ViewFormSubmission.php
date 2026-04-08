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
        'market_share' => 'MS Market Share',
        'challenges' => 'Challenges',
        'chances_potential' => 'Chances / Potential',
        'competitors' => 'Competitors and their Strengths',
        'expectations' => 'Expectations / Requests to MS',
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
