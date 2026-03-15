<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // --- DASHBOARD ---
    public function index()
    {
        return view('admin.dashboard', [
            'users_count' => User::count(),
            'posts_count' => Post::count(),
            'categories_count' => Category::count(),
            'recent_posts' => Post::latest()->take(10)->get(),
        ]);
    }

    // --- POSTS ---
    public function posts()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function destroyPost(Post $post)
    {
        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }
        $post->delete();
        return back()->with('success', 'Post removed successfully.');
    }

    // --- CATEGORIES ---
    public function categories()
    {
        $categories = Category::withCount('posts')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories|max:50']);
        Category::create(['name' => $request->name, 'slug' => Str::slug($request->name)]);
        return back()->with('success', 'Category created!');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    // --- USERS ---
    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) return back()->with('error', 'You cannot demote yourself!');
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 'User permissions updated.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) return back()->with('error', 'Suicide is not a feature.');
        $user->delete();
        return back()->with('success', 'User banned forever.');
    }
}
