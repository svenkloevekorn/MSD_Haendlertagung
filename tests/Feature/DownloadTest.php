<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\Download;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DownloadTest extends TestCase
{
    use RefreshDatabase;

    private function authenticatedSession(): array
    {
        $dealer = Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Test',
            'email' => 'max@test.de',
            'pin' => '123456',
        ]);

        return [
            'dealer_id' => $dealer->id,
            'dealer_logged_in_at' => now()->timestamp,
        ];
    }

    public function test_downloads_page_requires_login(): void
    {
        $this->get('/downloads')->assertRedirect('/');
    }

    public function test_downloads_page_shows_live_downloads(): void
    {
        $live = Download::create([
            'name' => 'Test PDF',
            'file_path' => 'downloads/test.pdf',
            'original_filename' => 'test.pdf',
            'file_size' => 1024,
            'status' => 'live',
        ]);

        $draft = Download::create([
            'name' => 'Draft File',
            'file_path' => 'downloads/draft.pdf',
            'original_filename' => 'draft.pdf',
            'file_size' => 2048,
            'status' => 'draft',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get('/downloads');

        $response->assertStatus(200);
        $response->assertSee('Test PDF');
        $response->assertDontSee('Draft File');
    }

    public function test_download_file_requires_login(): void
    {
        $download = Download::create([
            'name' => 'Test',
            'file_path' => 'downloads/test.pdf',
            'original_filename' => 'test.pdf',
            'file_size' => 1024,
            'status' => 'live',
        ]);

        $this->get("/downloads/{$download->id}/file")->assertRedirect('/');
    }

    public function test_download_file_works_for_live_files(): void
    {
        Storage::disk('local')->put('downloads/test.pdf', 'fake content');

        $download = Download::create([
            'name' => 'Test',
            'file_path' => 'downloads/test.pdf',
            'original_filename' => 'mein-dokument.pdf',
            'file_size' => 12,
            'status' => 'live',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get("/downloads/{$download->id}/file");

        $response->assertStatus(200);
        $response->assertDownload('mein-dokument.pdf');

        Storage::disk('local')->delete('downloads/test.pdf');
    }

    public function test_download_file_blocked_for_draft(): void
    {
        $download = Download::create([
            'name' => 'Draft',
            'file_path' => 'downloads/draft.pdf',
            'original_filename' => 'draft.pdf',
            'file_size' => 1024,
            'status' => 'draft',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get("/downloads/{$download->id}/file");

        $response->assertStatus(404);
    }

    public function test_empty_downloads_shows_placeholder(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->get('/downloads');

        $response->assertStatus(200);
        $response->assertSee('Presentations and documents will be made available here');
    }
}
