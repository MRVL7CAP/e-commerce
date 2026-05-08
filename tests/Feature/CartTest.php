<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class CartTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_cart_page_display(): void
    {
        $response = $this->get('/cart');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_view_cart(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/cart');

        $response->assertStatus(200);
    }

    public function test_add_product_to_cart(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($user)->post('/cart/store', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertRedirectBack();
        // Assuming cart is stored in session or database, check accordingly
        // This might need adjustment based on actual cart implementation
    }
}
