<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $featuredProducts = Product::orderBy('created_at', 'desc')
                                   ->take(8)
                                   ->get();

        $newArrivals = Product::orderBy('created_at', 'desc')
                              ->take(8)
                              ->get();

        $products = Product::paginate(12); // tất cả sản phẩm, phân trang

        return view('home', compact('categories', 'featuredProducts', 'newArrivals', 'products'));
    }
}

