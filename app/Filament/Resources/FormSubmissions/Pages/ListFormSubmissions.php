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
            Action::make('export')
                ->label('Export CSV')
                ->action(function (): StreamedResponse {
                    return response()->streamDownload(function () {
                        $submissions = FormSubmission::orderBy('created_at', 'desc')->get();

                        $handle = fopen('php://output', 'w');
                        fputcsv($handle, ['ID', 'Form', 'Data', 'Submitted']);

                        foreach ($submissions as $sub) {
                            fputcsv($handle, [
                                $sub->id,
                                $sub->form_label,
                                json_encode($sub->data, JSON_UNESCAPED_UNICODE),
                                $sub->created_at->format('d.m.Y H:i'),
                            ]);
                        }

                        fclose($handle);
                    }, 'submissions-' . now()->format('Y-m-d') . '.csv');
                }),
        ];
    }
}
