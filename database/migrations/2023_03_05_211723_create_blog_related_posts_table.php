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
        $postsTable = config('nova-blog.blog_posts_table', 'blog_posts');

        Schema::create('blog_related_posts', function (Blueprint $table) use($postsTable) {
            $table->id();
            $table->foreignId('post_id')->constrained($postsTable)->onDelete('cascade');
            $table->foreignId('related_post_id')->constrained($postsTable)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_related_posts');
    }
};
