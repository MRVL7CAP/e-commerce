<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\UploadedFile;

class AdminTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_dashboard_requires_auth_and_admin_role(): void
    {
        $user = User::factory()->create(); // Regular user

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403); // Forbidden
    }

    public function test_admin_can_create_category(): void
    {
        $admin = User::factory()->create(['role' => 'ADMIN']);

        $response = $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'New Category',
            'description' => 'Category description',
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    public function test_admin_can_create_product(): void
    {
        $admin = User::factory()->create(['role' => 'ADMIN']);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/products', [
            'title' => 'New Product',
            'content' => 'Product description',
            'slug' => 'new-product',
            'price' => 99.99,
            'category_id' => $category->id,
            'image' => UploadedFile::fake()->image('product.jpg'),
            'old_price' => 149.99,
            'rating' => 4.5,
            'stock' => 10,
            'rating_count' => 100,
            'is_published' => true,

        ]);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', ['title' => 'New Product']);
    }
}
