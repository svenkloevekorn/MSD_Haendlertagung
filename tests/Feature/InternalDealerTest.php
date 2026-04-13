<?php

namespace Tests\Feature;

use App\Models\Dealer;
use App\Models\FormSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InternalDealerTest extends TestCase
{
    use RefreshDatabase;

    private function loginAs(Dealer $dealer): static
    {
        return $this->withSession([
            'dealer_id' => $dealer->id,
            'dealer_logged_in_at' => now()->timestamp,
        ]);
    }

    public function test_internal_dealer_has_no_todo_items(): void
    {
        $dealer = Dealer::factory()->create(['is_internal' => true]);

        $response = $this->loginAs($dealer)->get('/startseite');

        $response->assertStatus(200);
        $response->assertDontSee('Open Items');
    }

    public function test_external_dealer_has_todo_items(): void
    {
        $dealer = Dealer::factory()->create(['is_internal' => false]);

        $response = $this->loginAs($dealer)->get('/startseite');

        $response->assertStatus(200);
        $response->assertSee('Factory Tour');
    }

    public function test_external_scope_excludes_internal_dealers(): void
    {
        Dealer::factory()->create(['is_internal' => false]);
        Dealer::factory()->create(['is_internal' => true]);

        $this->assertCount(1, Dealer::external()->get());
        $this->assertCount(2, Dealer::all());
    }

    public function test_is_internal_defaults_to_false(): void
    {
        $dealer = Dealer::factory()->create();

        $this->assertFalse($dealer->is_internal);
    }

    public function test_internal_dealer_can_still_access_all_pages(): void
    {
        $dealer = Dealer::factory()->create(['is_internal' => true]);

        $routes = ['/startseite', '/agenda', '/galerie', '/downloads', '/formular', '/feedback', '/kontakt'];

        foreach ($routes as $route) {
            $response = $this->loginAs($dealer)->get($route);
            $response->assertStatus(200, "Failed for route: {$route}");
        }
    }

    public function test_internal_dealer_sees_info_notice_on_registration(): void
    {
        $dealer = Dealer::factory()->create(['is_internal' => true]);

        $response = $this->loginAs($dealer)->get('/formular');

        $response->assertStatus(200);
        $response->assertSee('No action required');
        $response->assertDontSee('Save Registration');
    }

    public function test_internal_dealer_sees_info_notice_on_market_info(): void
    {
        $dealer = Dealer::factory()->create(['is_internal' => true]);

        $response = $this->loginAs($dealer)->get('/market-info');

        $response->assertStatus(200);
        $response->assertSee('No action required');
        $response->assertDontSee('Save Market Info');
    }

    public function test_internal_dealer_sees_info_notice_on_feedback(): void
    {
        $dealer = Dealer::factory()->create(['is_internal' => true]);

        $response = $this->loginAs($dealer)->get('/feedback');

        $response->assertStatus(200);
        $response->assertSee('No action required');
        $response->assertDontSee('Submit Feedback');
    }

    public function test_external_dealer_sees_forms_normally(): void
    {
        $dealer = Dealer::factory()->create(['is_internal' => false]);

        $response = $this->loginAs($dealer)->get('/formular');
        $response->assertSee('Save Registration');
        $response->assertDontSee('No action required');

        $response = $this->loginAs($dealer)->get('/market-info');
        $response->assertSee('Save Market Info');

        $response = $this->loginAs($dealer)->get('/feedback');
        $response->assertSee('Submit Feedback');
    }
}
