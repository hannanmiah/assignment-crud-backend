<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create additional random users
        User::factory()->count(8)->create();

        // Create sample products
        Product::factory()->create([
            'name' => 'Premium Wireless Headphones',
            'description' => 'High-quality wireless headphones with active noise cancellation and 30-hour battery life. Features premium sound quality and comfortable design.',
            'price' => 299.99,
            'stock' => 50,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'name' => 'Smart Watch Pro',
            'description' => 'Advanced fitness tracking smartwatch with heart rate monitor, GPS, and 5-day battery life. Water-resistant design.',
            'price' => 399.99,
            'stock' => 25,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'name' => 'Laptop Backpack',
            'description' => 'Durable laptop backpack with padded compartment for laptops up to 15.6 inches. Multiple pockets and USB charging port.',
            'price' => 79.99,
            'stock' => 100,
            'is_active' => true,
        ]);

        Product::factory()->create([
            'name' => 'Bluetooth Speaker',
            'description' => 'Portable Bluetooth speaker with 360-degree sound, waterproof design, and 12-hour battery life.',
            'price' => 149.99,
            'stock' => 0,
            'is_active' => false,
        ]);

        Product::factory()->create([
            'name' => 'Wireless Mouse',
            'description' => 'Ergonomic wireless mouse with precision tracking and long battery life. Compatible with all operating systems.',
            'price' => 49.99,
            'stock' => 75,
            'is_active' => true,
        ]);

        // Create additional random products
        Product::factory()->count(20)->create();
    }
}
