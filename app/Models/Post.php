<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'media_path',
        'media_type',
        'upvotes',
        'downvotes',
        'hotness_score',
        'category_id'
    ];

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->float('hotness_score')->default(0.0)->index();

            $table->timestamps();
            $table->foreignId('category_id'
        'name',
        'email',
        'google_id',
        'is_admin',
        'avatar',
        'password'
    ];

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
