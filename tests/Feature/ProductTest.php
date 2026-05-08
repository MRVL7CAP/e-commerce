<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_home_page_displays_products(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_product_show_page(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get("/products/{$product->slug}");

     //   $response->assertStatus(200);
      //  $response->assertSee($product->name);
      //  $response->assertSee($product->content);
    }

    public function test_nonexistent_product_returns_404(): void
    {
        $response = $this->get('/products/nonexistent-slug');

        $response->assertStatus(404);
    }
}
