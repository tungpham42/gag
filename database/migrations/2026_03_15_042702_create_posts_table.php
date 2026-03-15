<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('media_path'); // Path to image/video
            $table->enum('media_type', ['image', 'video', 'gif']);

            // Denormalized counts for fast querying
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->float('hotness_score')->default(0.0)->index();

            $table->timestamps();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
