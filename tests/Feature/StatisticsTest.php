<?php

use App\Models\Product;
use App\Models\User;

test('can get overview statistics', function () {
    $user = User::factory()->create();
    Product::factory()->count(5)->create(['is_active' => true, 'price' => 100, 'stock' => 20]);
    Product::factory()->count(3)->create(['is_active' => false, 'price' => 50, 'stock' => 5]);
    Product::factory()->count(2)->create(['is_active' => true, 'price' => 75, 'stock' => 0]);

    $response = $this->actingAs($user)->getJson('/api/statistics/overview');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'total_products',
                'active_products',
                'inactive_products',
                'total_users',
                'total_stock_value',
                'out_of_stock_products',
                'low_stock_products',
            ],
        ]);

    $data = $response->json('data');
    expect($data['total_products'])->toBe(10);
    expect($data['active_products'])->toBe(7);
    expect($data['inactive_products'])->toBe(3);
    expect($data['total_users'])->toBe(1);
    expect($data['out_of_stock_products'])->toBe(2);
    expect($data['low_stock_products'])->toBe(3);
});

test('cannot get overview statistics without authentication', function () {
    $response = $this->getJson('/api/statistics/overview');

    $response->assertUnauthorized();
});

test('can get products statistics', function () {
    $user = User::factory()->create();
    Product::factory()->count(5)->create(['price' => 100, 'stock' => 10]);
    Product::factory()->count(3)->create(['price' => 50, 'stock' => 0]);

    $response = $this->actingAs($user)->getJson('/api/statistics/products');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'total_products',
                'active_products',
                'inactive_products',
                'average_price',
                'highest_price',
                'lowest_price',
                'total_stock',
                'out_of_stock_products',
                'low_stock_products',
                'total_stock_value',
            ],
        ]);

    $data = $response->json('data');
    expect($data['total_products'])->toBe(8);
    expect($data['out_of_stock_products'])->toBe(3);
    expect($data['average_price'])->toBe(81.25);
    expect($data['highest_price'])->toBe(100);
    expect($data['lowest_price'])->toBe(50);
});

test('cannot get products statistics without authentication', function () {
    $response = $this->getJson('/api/statistics/products');

    $response->assertUnauthorized();
});

test('can get stock statistics', function () {
    $user = User::factory()->create();
    Product::factory()->count(3)->create(['stock' => 0, 'price' => 100]);
    Product::factory()->count(4)->create(['stock' => 5, 'price' => 50]);
    Product::factory()->count(2)->create(['stock' => 20, 'price' => 75]);

    $response = $this->actingAs($user)->getJson('/api/statistics/stock');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'total_products',
                'out_of_stock_products',
                'low_stock_products',
                'adequate_stock_products',
                'total_stock',
                'total_stock_value',
                'critical_products',
            ],
        ]);

    $data = $response->json('data');
    expect($data['total_products'])->toBe(9);
    expect($data['out_of_stock_products'])->toBe(3);
    expect($data['low_stock_products'])->toBe(4);
    expect($data['adequate_stock_products'])->toBe(2);
    expect($data['total_stock'])->toBe(60);
    expect($data['critical_products'])->toHaveCount(5);
});

test('cannot get stock statistics without authentication', function () {
    $response = $this->getJson('/api/statistics/stock');

    $response->assertUnauthorized();
});

test('can get pricing statistics', function () {
    $user = User::factory()->create();
    Product::factory()->count(3)->create(['price' => 25, 'stock' => 5]);
    Product::factory()->count(2)->create(['price' => 75, 'stock' => 5]);
    Product::factory()->count(2)->create(['price' => 150, 'stock' => 5]);
    Product::factory()->count(1)->create(['price' => 300, 'stock' => 5]);

    $response = $this->actingAs($user)->getJson('/api/statistics/pricing');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'total_products',
                'average_price',
                'median_price',
                'highest_price',
                'lowest_price',
                'price_range',
                'total_inventory_value',
                'price_distribution',
            ],
        ]);

    $data = $response->json('data');
    expect($data['total_products'])->toBe(8);
    expect($data['average_price'])->toBe(103.13);
    expect($data['median_price'])->toBe(75);
    expect($data['highest_price'])->toBe(300);
    expect($data['lowest_price'])->toBe(25);
    expect($data['price_range'])->toBe(275);

    expect($data['price_distribution']['under_50'])->toBe(3);
    expect($data['price_distribution']['50_to_100'])->toBe(2);
    expect($data['price_distribution']['100_to_250'])->toBe(2);
    expect($data['price_distribution']['250_to_500'])->toBe(1);
    expect($data['price_distribution']['over_500'])->toBe(0);
});

test('cannot get pricing statistics without authentication', function () {
    $response = $this->getJson('/api/statistics/pricing');

    $response->assertUnauthorized();
});

test('pricing statistics works with no products', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson('/api/statistics/pricing');

    $response->assertOk();

    $data = $response->json('data');
    expect($data['total_products'])->toBe(0);
    expect($data['average_price'])->toBe(0);
    expect($data['median_price'])->toBe(0);
    expect($data['highest_price'])->toBeNull();
    expect($data['lowest_price'])->toBeNull();
    expect($data['price_range'])->toBeNull();
});
