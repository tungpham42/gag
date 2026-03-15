<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch posts created by this user
        $posts = Post::where('user_id', $user->id)
                     ->with('category')
                     ->latest()
                     ->get();

        return view('profile.index', compact('user', 'posts'));
    }
}
