<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testItReturnsAPaginatedListOfProducts()
    {
        Product::factory()->count(30)->create();

        $response = $this->getJson('/api/products?per_page=10');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'links',
            'meta' => ['current_page', 'last_page', 'per_page', 'total'],
        ]);
    }

    #[Test]
    public function it_returns_404_if_product_not_found()
    {
        $response = $this->getJson('/api/products/999');
        $response->assertStatus(404);
        $response->assertJson(['error' => 'Product not found']);
    }
}
