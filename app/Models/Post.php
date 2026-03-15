<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
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
