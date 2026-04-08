<?php

namespace App\Filament\Resources\FormSubmissions\Pages;

use App\Filament\Resources\FormSubmissions\FormSubmissionResource;
use App\Models\FormSubmission;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListFormSubmissions extends ListRecords
{
    protected static string $resource = FormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportRegistration')
                ->label('Export Registration')
                ->color('success')
                ->action(fn (): StreamedResponse => self::exportForm(
                    FormSubmission::FORM_REGISTRATION,
                    'registration',
                    ['First Name', 'Last Name', 'Email', 'Mobile', 'Company', 'No Companion', 'Companion Mobile', 'Activity 1st', 'Activity 2nd', 'Activity 3rd', 'No Allergies', 'Allergies', 'Factory Tour', 'Comments'],
                    ['first_name', 'last_name', 'email', 'mobile', 'company', 'no_companion', 'companion_mobile', 'activity_1', 'activity_2', 'activity_3', 'no_allergies', 'allergies', 'factory_tour', 'comments'],
                )),
            Action::make('exportMarketInfo')
                ->label('Export Market Info')
                ->color('warning')
                ->action(fn (): StreamedResponse => self::exportForm(
                    FormSubmission::FORM_MARKET_INFO,
                    'market-info',
                    ['First Name', 'Last Name', 'Delegated to', 'MS Market Share', 'Challenges', 'Chances / Potential', 'Competitors', 'Expectations'],
                    ['first_name', 'last_name', 'delegated_to', 'market_share', 'challenges', 'chances_potential', 'competitors', 'expectations'],
                )),
            Action::make('exportFeedback')
                ->label('Export Feedback')
                ->color('info')
                ->action(fn (): StreamedResponse => self::exportForm(
                    FormSubmission::FORM_FEEDBACK,
                    'feedback',
                    ['Rating', 'Accommodation', 'Comment Accommodation', 'Catering', 'Comment Catering', 'Program', 'Comment Program', 'Presentations', 'Comment Presentations', 'Organisation', 'Comment Organisation', 'Comment Further', 'Liked', 'Improve', 'Topics', 'Additional Comments'],
                    ['rating', 'rating_accommodation', 'comment_accommodation', 'rating_catering', 'comment_catering', 'rating_program', 'comment_program', 'rating_presentations', 'comment_presentations', 'rating_organisation', 'comment_organisation', 'comment_further', 'liked', 'improve', 'topics', 'additional_comments'],
                )),
        ];
    }

    private static function exportForm(string $formSlug, string $filename, array $headers, array $keys): StreamedResponse
    {
        return response()->streamDownload(function () use ($formSlug, $headers, $keys) {
            $submissions = FormSubmission::with('dealer')
                ->where('form_slug', $formSlug)
                ->orderBy('created_at', 'desc')
                ->get();

            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            $header = array_merge(['Dealer', 'PIN'], $headers, ['Submitted', 'Last Updated']);
            fputcsv($handle, $header, ';');

            foreach ($submissions as $sub) {
                $row = [
                    $sub->dealer ? $sub->dealer->first_name . ' ' . $sub->dealer->last_name : '-',
                    $sub->dealer?->pin ?? '-',
                ];

                foreach ($keys as $key) {
                    $value = $sub->data[$key] ?? '';
                    if (is_bool($value)) {
                        $value = $value ? 'Yes' : 'No';
                    }
                    $row[] = $value;
                }

                $row[] = $sub->created_at->format('d.m.Y H:i');
                $row[] = $sub->updated_at->format('d.m.Y H:i');
                fputcsv($handle, $row, ';');
            }

            fclose($handle);
        }, $filename . '-' . now()->format('Y-m-d') . '.csv');
    }
}
