<?php

namespace Tests\Feature;

use App\Models\Dealer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PinLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('access code');
    }

    public function test_valid_pin_redirects_to_startseite(): void
    {
        Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Test',
            'email' => 'max@test.de',
            'pin' => '123456',
        ]);

        $response = $this->post('/login', ['pin' => '123456']);
        $response->assertRedirect('/startseite');
    }

    public function test_pin_login_is_case_insensitive(): void
    {
        Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Test',
            'email' => 'max@test.de',
            'pin' => 'ABC123',
        ]);

        $response = $this->post('/login', ['pin' => 'abc123']);
        $response->assertRedirect('/startseite');
    }

    public function test_invalid_pin_returns_error(): void
    {
        $response = $this->post('/login', ['pin' => '999999']);
        $response->assertSessionHasErrors('pin');
    }

    public function test_protected_routes_redirect_without_session(): void
    {
        $routes = ['/startseite', '/agenda', '/galerie', '/downloads', '/formular', '/feedback', '/kontakt'];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/');
        }
    }

    public function test_protected_routes_accessible_with_session(): void
    {
        $dealer = Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Test',
            'email' => 'max@test.de',
            'pin' => '123456',
        ]);

        $response = $this->withSession([
            'dealer_id' => $dealer->id,
            'dealer_logged_in_at' => now()->timestamp,
        ])->get('/startseite');

        $response->assertStatus(200);
    }

    public function test_session_expires_after_72_hours(): void
    {
        $dealer = Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Test',
            'email' => 'max@test.de',
            'pin' => '123456',
        ]);

        $response = $this->withSession([
            'dealer_id' => $dealer->id,
            'dealer_logged_in_at' => now()->subHours(73)->timestamp,
        ])->get('/startseite');

        $response->assertRedirect('/');
    }

    public function test_last_login_at_is_updated(): void
    {
        $dealer = Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Test',
            'email' => 'max@test.de',
            'pin' => '123456',
        ]);

        $this->assertNull($dealer->last_login_at);

        $this->post('/login', ['pin' => '123456']);

        $dealer->refresh();
        $this->assertNotNull($dealer->last_login_at);
    }

    public function test_logout_clears_session(): void
    {
        $response = $this->withSession([
            'dealer_id' => 1,
            'dealer_logged_in_at' => now()->timestamp,
        ])->post('/logout');

        $response->assertRedirect('/');
        $this->assertNull(session('dealer_id'));
    }

    public function test_duplicate_pin_is_rejected(): void
    {
        Dealer::create([
            'first_name' => 'Max',
            'last_name' => 'Test',
            'email' => 'max@test.de',
            'pin' => '123456',
        ]);

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);

        Dealer::create([
            'first_name' => 'Erika',
            'last_name' => 'Test',
            'email' => 'erika@test.de',
            'pin' => '123456',
        ]);
    }

    public function test_logged_in_user_is_redirected_from_login_page(): void
    {
        $response = $this->withSession([
            'dealer_id' => 1,
            'dealer_logged_in_at' => now()->timestamp,
        ])->get('/');

        $response->assertRedirect('/startseite');
    }
}
