<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function overview(): JsonResponse
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'inactive_products' => Product::where('is_active', false)->count(),
            'total_users' => User::count(),
            'total_stock_value' => Product::selectRaw('SUM(price * stock) as total')->first()->total ?? 0,
            'out_of_stock_products' => Product::where('stock', 0)->count(),
            'low_stock_products' => Product::where('stock', '>', 0)->where('stock', '<=', 10)->count(),
        ];

        return response()->json([
            'data' => $stats,
        ]);
    }

    public function products(): JsonResponse
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'inactive_products' => Product::where('is_active', false)->count(),
            'average_price' => Product::avg('price'),
            'highest_price' => Product::max('price'),
            'lowest_price' => Product::min('price'),
            'total_stock' => Product::sum('stock'),
            'out_of_stock_products' => Product::where('stock', 0)->count(),
            'low_stock_products' => Product::where('stock', '>', 0)->where('stock', '<=', 10)->count(),
            'total_stock_value' => Product::selectRaw('SUM(price * stock) as total')->first()->total ?? 0,
        ];

        return response()->json([
            'data' => $stats,
        ]);
    }

    public function stock(): JsonResponse
    {
        $criticalProducts = Product::where('stock', '<=', 10)
            ->select('id', 'name', 'stock', 'price')
            ->orderBy('stock', 'asc')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'current_stock' => $product->stock,
                    'price' => $product->price,
                    'stock_value' => $product->price * $product->stock,
                    'status' => $product->stock === 0 ? 'out_of_stock' : 'low_stock',
                ];
            });

        $stats = [
            'total_products' => Product::count(),
            'out_of_stock_products' => Product::where('stock', 0)->count(),
            'low_stock_products' => Product::where('stock', '>', 0)->where('stock', '<=', 10)->count(),
            'adequate_stock_products' => Product::where('stock', '>', 10)->count(),
            'total_stock' => Product::sum('stock'),
            'total_stock_value' => Product::selectRaw('SUM(price * stock) as total')->first()->total ?? 0,
            'critical_products' => $criticalProducts->take(5),
        ];

        return response()->json([
            'data' => $stats,
        ]);
    }

    public function pricing(): JsonResponse
    {
        $count = Product::count();

        if ($count === 0) {
            $stats = [
                'total_products' => 0,
                'average_price' => 0,
                'median_price' => 0,
                'highest_price' => null,
                'lowest_price' => null,
                'price_range' => null,
                'total_inventory_value' => 0,
                'price_distribution' => [
                    'under_50' => 0,
                    '50_to_100' => 0,
                    '100_to_250' => 0,
                    '250_to_500' => 0,
                    'over_500' => 0,
                ],
            ];
        } else {
            $stats = [
                'total_products' => $count,
                'average_price' => round(Product::avg('price'), 2),
                'median_price' => $this->calculateMedianPrice(),
                'highest_price' => Product::max('price'),
                'lowest_price' => Product::min('price'),
                'price_range' => Product::max('price') - Product::min('price'),
                'total_inventory_value' => Product::selectRaw('SUM(price * stock) as total')->first()->total ?? 0,
            ];

            $priceRanges = [
                'under_50' => Product::where('price', '<', 50)->count(),
                '50_to_100' => Product::where('price', '>=', 50)->where('price', '<', 100)->count(),
                '100_to_250' => Product::where('price', '>=', 100)->where('price', '<', 250)->count(),
                '250_to_500' => Product::where('price', '>=', 250)->where('price', '<', 500)->count(),
                'over_500' => Product::where('price', '>=', 500)->count(),
            ];

            $stats['price_distribution'] = $priceRanges;
        }

        return response()->json([
            'data' => $stats,
        ]);
    }

    private function calculateMedianPrice(): float
    {
        $prices = Product::orderBy('price')->pluck('price')->toArray();
        $count = count($prices);

        if ($count === 0) {
            return 0;
        }

        $middle = floor($count / 2);

        if ($count % 2 === 0) {
            return round(($prices[$middle - 1] + $prices[$middle]) / 2, 2);
        }

        return round($prices[$middle], 2);
    }
}
