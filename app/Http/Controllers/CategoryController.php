<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();

        return response()->json($categories);
    }

    public function show($id)
    {
        $category = Category::with(['products' => function($query) {
            $query->where('is_active', true);
        }])->findOrFail($id);

        return response()->json($category);
    }
}
