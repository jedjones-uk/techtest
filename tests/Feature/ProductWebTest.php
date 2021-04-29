<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductWebTest extends TestCase {
    use RefreshDatabase;

    private $user;

    private $productCategory;

    private $testProduct;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->productCategory = ProductCategory::factory()->create();
    }

    public function test_product_index_screen_can_be_rendered() {
        $response = $this->actingAs($this->user)->get('/product');
        $response->assertStatus(200);
    }

    public function test_product_create_screen_can_be_rendered() {
        $response = $this->actingAs($this->user)->get('/product/create');

        $response->assertStatus(200);
    }

    public function test_product_can_be_created() {
        $product = Product::factory()->for($this->productCategory)->make();
        $response = $this->actingAs($this->user)->post('/product', $product->toArray());

        $this->assertDatabaseCount('products', 1);

        $response->assertRedirect('/product');
    }

    public function test_product_edit_screen_can_be_rendered() {
        $product = Product::factory()->for($this->productCategory)->create();
        $response = $this->actingAs($this->user)->get("/product/{$product->product_id}/edit");

        $response->assertStatus(200)->assertSee('Update Product');
    }

    public function test_product_can_be_updated() {
        $product = Product::factory()->for($this->productCategory)->create();
        $product->product_name = 'Updated';
        $response = $this->actingAs($this->user)->put("/product/{$product->product_id}", $product->toArray());

        $response->assertRedirect('/product');
    }

    public function test_product_can_be_deleted() {
        $product = Product::factory()->for($this->productCategory)->create();
        $response = $this->actingAs($this->user)->delete("/product/{$product->product_id}");

        $this->assertSoftDeleted($product);

        $response->assertRedirect('/product');
    }

    public function test_product_can_be_restored() {
        $product = Product::factory()->for($this->productCategory)->create();
        $product->delete();

        $response = $this->actingAs($this->user)->get("/product/{$product->product_id}/restore");

        $this->assertDatabaseHas('products', ['product_id' => $product->product_id, 'deleted_at' => null]);

        $response->assertRedirect('/product');
    }

    public function test_product_can_be_deleted_permanently() {
        $product = Product::factory()->for($this->productCategory)->create();
        $product->delete();

        $response = $this->actingAs($this->user)->get("/product/{$product->product_id}/delete");

        $this->assertDeleted($product);

        $response->assertRedirect('/product?archived=1');
    }

}
