<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Homepage
    public function index(Request $request)
    {
        $latestProducts = Product::with('category')
            ->latest()
            ->take(4)
            ->get();

        $topRatedProducts = Product::with('category')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(4)
            ->get();

        $bestSellerProducts = Product::with('category')
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(4)
            ->get();


        $categoriesWithImage = collect([]);

        if (Schema::hasColumn('categories', 'image')) {
            $categoriesWithImage = Category::whereNotNull('image')
                ->where('image', '!=', '')
                ->take(3)
                ->get();
        }

        $slotsNeeded = 3 - $categoriesWithImage->count();

        if ($slotsNeeded > 0) {
            $excludedIds = $categoriesWithImage->pluck('id');

            $topCategories = Category::whereNotIn('id', $excludedIds)
                ->withCount(['orderItems as total_sold' => function($query) {
                    $query->select(DB::raw('coalesce(sum(quantity), 0)'));
                }])
                ->orderByDesc('total_sold')
                ->take($slotsNeeded)
                ->get();

            $categories = $categoriesWithImage->merge($topCategories);
        } else {
            $categories = $categoriesWithImage;
        }

        return view('home', compact('categories', 'latestProducts', 'topRatedProducts', 'bestSellerProducts'));
    }

    public function shop(Request $request)
    {
        $totalProducts = Product::count();

        $query = Product::with(['category', 'store']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $slug = $request->category;
            $query->whereHas('category', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->withAvg('reviews', 'rating')->paginate(12)->withQueryString();

        $categories = Category::all();

        return view('shop', compact('products', 'categories', 'totalProducts'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'store', 'reviews.user']);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('show', compact('product', 'relatedProducts'));
    }
}