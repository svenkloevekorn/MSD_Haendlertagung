<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\GalleryImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryTest extends TestCase
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

    public function test_gallery_page_requires_login(): void
    {
        $this->get('/galerie')->assertRedirect('/');
    }

    public function test_gallery_shows_live_images(): void
    {
        GalleryImage::create([
            'title' => 'Live Bild',
            'image_path' => 'gallery/live.jpg',
            'original_filename' => 'live.jpg',
            'status' => 'live',
        ]);

        GalleryImage::create([
            'title' => 'Draft Bild',
            'image_path' => 'gallery/draft.jpg',
            'original_filename' => 'draft.jpg',
            'status' => 'draft',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get('/galerie');

        $response->assertStatus(200);
        $response->assertSee('Live Bild');
        $response->assertDontSee('Draft Bild');
    }

    public function test_gallery_image_requires_login(): void
    {
        $image = GalleryImage::create([
            'image_path' => 'gallery/test.jpg',
            'original_filename' => 'test.jpg',
            'status' => 'live',
        ]);

        $this->get("/galerie/{$image->id}/image")->assertRedirect('/');
    }

    public function test_gallery_image_serves_live_file(): void
    {
        Storage::disk('local')->put('gallery/test.jpg', 'fake image content');

        $image = GalleryImage::create([
            'image_path' => 'gallery/test.jpg',
            'original_filename' => 'test.jpg',
            'status' => 'live',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get("/galerie/{$image->id}/image");

        $response->assertStatus(200);

        Storage::disk('local')->delete('gallery/test.jpg');
    }

    public function test_gallery_image_blocked_for_draft(): void
    {
        $image = GalleryImage::create([
            'image_path' => 'gallery/draft.jpg',
            'original_filename' => 'draft.jpg',
            'status' => 'draft',
        ]);

        $response = $this->withSession($this->authenticatedSession())
            ->get("/galerie/{$image->id}/image");

        $response->assertStatus(404);
    }

    public function test_empty_gallery_shows_placeholder(): void
    {
        $response = $this->withSession($this->authenticatedSession())
            ->get('/galerie');

        $response->assertStatus(200);
        $response->assertSee('Bilder werden nach der Veranstaltung');
    }
}
