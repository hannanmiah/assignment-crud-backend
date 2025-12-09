<?php

use App\Models\Product;
use App\Models\User;

test('can list products', function () {
    $user = User::factory()->create();
    Product::factory()->count(15)->create();

    $response = $this->actingAs($user)->getJson('/api/products');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'stock',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
            ],
            'pagination' => [
                'current_page',
                'last_page',
                'per_page',
                'total',
            ],
        ]);
});

test('can filter products by active status', function () {
    $user = User::factory()->create();
    Product::factory()->count(3)->create(['is_active' => true]);
    Product::factory()->count(2)->create(['is_active' => false]);

    $response = $this->actingAs($user)->getJson('/api/products?is_active=1');

    $response->assertOk();
    expect($response->json('data'))->toHaveCount(3);
});

test('cannot list products without authentication', function () {
    $response = $this->getJson('/api/products');

    $response->assertUnauthorized();
});

test('can create a product', function () {
    $user = User::factory()->create();

    $productData = [
        'name' => 'Test Product',
        'description' => 'This is a test product description',
        'price' => 29.99,
        'stock' => 50,
        'is_active' => true,
    ];

    $response = $this->actingAs($user)->postJson('/api/products', $productData);

    $response->assertCreated()
        ->assertJson([
            'message' => 'Product created successfully',
            'data' => [
                'name' => 'Test Product',
                'description' => 'This is a test product description',
                'price' => 29.99,
                'stock' => 50,
                'is_active' => true,
            ],
        ]);

    $this->assertDatabaseHas('products', $productData);
});

test('cannot create product without authentication', function () {
    $productData = [
        'name' => 'Test Product',
        'description' => 'This is a test product description',
        'price' => 29.99,
        'stock' => 50,
    ];

    $response = $this->postJson('/api/products', $productData);

    $response->assertUnauthorized();
});

test('product creation validation fails with invalid data', function () {
    $user = User::factory()->create();

    $invalidData = [
        'name' => '',
        'description' => 'Valid description',
        'price' => -10,
        'stock' => -5,
    ];

    $response = $this->actingAs($user)->postJson('/api/products', $invalidData);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'price', 'stock']);
});

test('can show a product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->getJson("/api/products/{$product->id}");

    $response->assertOk()
        ->assertJson([
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (float) $product->price,
                'stock' => $product->stock,
                'is_active' => $product->is_active,
            ],
        ]);
});

test('cannot show product without authentication', function () {
    $product = Product::factory()->create();

    $response = $this->getJson("/api/products/{$product->id}");

    $response->assertUnauthorized();
});

test('cannot show non-existent product', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson('/api/products/999');

    $response->assertNotFound();
});

test('can update a product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $updateData = [
        'name' => 'Updated Product Name',
        'price' => 99.99,
        'stock' => 25,
    ];

    $response = $this->actingAs($user)->putJson("/api/products/{$product->id}", $updateData);

    $response->assertOk()
        ->assertJson([
            'message' => 'Product updated successfully',
            'data' => [
                'id' => $product->id,
                'name' => 'Updated Product Name',
                'price' => 99.99,
                'stock' => 25,
            ],
        ]);

    $this->assertDatabaseHas('products', $updateData);
});

test('cannot update product without authentication', function () {
    $product = Product::factory()->create();

    $updateData = [
        'name' => 'Updated Product Name',
    ];

    $response = $this->putJson("/api/products/{$product->id}", $updateData);

    $response->assertUnauthorized();
});

test('product update validation fails with invalid data', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $invalidData = [
        'name' => '',
        'price' => -50,
        'stock' => -10,
    ];

    $response = $this->actingAs($user)->putJson("/api/products/{$product->id}", $invalidData);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'price', 'stock']);
});

test('can delete a product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $response = $this->actingAs($user)->deleteJson("/api/products/{$product->id}");

    $response->assertOk()
        ->assertJson([
            'message' => 'Product deleted successfully',
        ]);

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

test('cannot delete product without authentication', function () {
    $product = Product::factory()->create();

    $response = $this->deleteJson("/api/products/{$product->id}");

    $response->assertUnauthorized();
});

test('cannot delete non-existent product', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->deleteJson('/api/products/999');

    $response->assertNotFound();
});
