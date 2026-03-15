<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the feed for a specific category.
     */
    public function show(Category $category)
    {
        // Fetch all categories so the top navigation bar still renders
        $categories = Category::orderBy('name')->get();

        // Fetch posts ONLY for this category, matching the PostController sorting
        $posts = $category->posts()
                    ->orderByDesc('hotness_score')
                    ->orderByDesc('created_at')
                    ->paginate(24);

        // Pass the $category variable so we can highlight the active category in the view
        return view('posts.index', compact('posts', 'categories', 'category'));
    }
}
