<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_has_the_correct_fillable_properties()
    {
        $product = new Product();

        $this->assertEquals(
            ['sku', 'description', 'size', 'photo', 'updated_at'],
            $product->getFillable()
        );
    }

    // Add more tests for relationships or other model logic if needed
}
