<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'slug',
        'user_id',
        'title',
        'media_path',
        'media_type',
        'upvotes',
        'downvotes',
        'hotness_score',
        'category_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            // Generates 6 random alphanumeric characters
            $post->slug = Str::random(6);
        });
    }

    // Update the route key name to use slug instead of ID for URLs
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function updateHotnessScore(): void
    {
        $score = $this->upvotes - $this->downvotes;
        $order = log10(max(abs($score), 1));
        $sign = $score > 0 ? 1 : ($score < 0 ? -1 : 0);

        // Using a fixed epoch, e.g., Jan 1, 2024
        $seconds = $this->created_at->getTimestamp() - 1704067200;

        $this->update([
            'hotness_score' => round($order + ($sign * $seconds / 45000), 7)
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
