<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display the feed, sorted by the hotness score.
     */
    public function index()
    {
        $posts = Post::orderByDesc('hotness_score')->paginate(15);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id', // Added validation
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4|max:20480',
        ]);

        $file = $request->file('file');
        $mime = $file->getMimeType();
        $type = str_contains($mime, 'video') ? 'video' : (str_contains($mime, 'gif') ? 'gif' : 'image');

        $path = $file->store('memes', 'public');

        Post::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id, // Added this
            'title' => $request->title,
            'media_path' => $path,
            'media_type' => $type,
        ]);

        return redirect()->route('posts.index')->with('success', 'Meme uploaded!');
    }

    /**
     * Handle an upvote action.
     */
    public function upvote(Post $post, Request $request)
    {
        $this->handleVote($post, $request->user(), 1);

        return back();
    }

    /**
     * Handle a downvote action.
     */
    public function downvote(Post $post, Request $request)
    {
        $this->handleVote($post, $request->user(), -1);

        return back();
    }

    /**
     * Reusable logic to process the vote, update denormalized columns,
     * and calculate the new hotness score seamlessly.
     */
    private function handleVote(Post $post, $user, int $value): void
    {
        DB::transaction(function () use ($post, $user, $value) {
            // Check if the user has already voted on this specific post
            $existingVote = DB::table('votes')
                ->where('user_id', $user->id)
                ->where('votable_id', $post->id)
                ->where('votable_type', Post::class)
                ->first();

            if ($existingVote) {
                if ($existingVote->value === $value) {
                    // 1. Toggle Off: User clicked the same vote button again
                    DB::table('votes')->where('id', $existingVote->id)->delete();

                    if ($value === 1) {
                        $post->decrement('upvotes');
                    } else {
                        $post->decrement('downvotes');
                    }
                } else {
                    // 2. Switch Vote: User changed from up to down, or down to up
                    DB::table('votes')->where('id', $existingVote->id)->update([
                        'value' => $value,
                        'updated_at' => now()
                    ]);

                    if ($value === 1) {
                        $post->increment('upvotes');
                        $post->decrement('downvotes');
                    } else {
                        $post->increment('downvotes');
                        $post->decrement('upvotes');
                    }
                }
            } else {
                // 3. New Vote: No existing vote found
                DB::table('votes')->insert([
                    'user_id' => $user->id,
                    'votable_id' => $post->id,
                    'votable_type' => Post::class,
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($value === 1) {
                    $post->increment('upvotes');
                } else {
                    $post->increment('downvotes');
                }
            }

            // Refresh the model to get the newly incremented/decremented values,
            // then trigger your custom hotness algorithm.
            $post->refresh();
            $post->updateHotnessScore();
        });
    }
}
