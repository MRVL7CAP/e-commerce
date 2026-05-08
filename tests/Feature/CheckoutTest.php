<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Address;

class CheckoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_checkout_requires_authentication(): void
    {
        $response = $this->post('/checkout');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_checkout(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $address = Address::factory()->create(['user_id' => $user->id]);

        // Assuming cart has items, but since cart implementation is unknown, this is basic
        $response = $this->actingAs($user)->post('/checkout');// Add other required fields]);

        $response->assertRedirect(route('checkout.success'));
    }

    public function test_checkout_success_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/checkout/success');

        $response->assertStatus(200);
    }

    public function test_checkout_cancel_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/checkout/cancel');

        $response->assertStatus(302);
    }
}
