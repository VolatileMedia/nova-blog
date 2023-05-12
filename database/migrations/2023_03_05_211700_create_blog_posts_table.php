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
        $postTable = config('nova-blog.blog_posts_table', 'blog_posts');
        $categoriesTable = config('nova-blog.blog_categories_table', 'blog_categories');

        Schema::create($postTable, function (Blueprint $table) use($categoriesTable) {
            $table->bigIncrements('id');
            $table->foreignId('category_id')->constrained($categoriesTable)->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('featured_image')->nullable();
            $table->longText('post_introduction')->nullable();
            $table->json('post_content');
            $table->unsignedTinyInteger('read_time')->default(10);
            $table->json('data')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('include_in_bloglist')->default(true);

            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_image')->nullable();
            $table->string('seo_image_alt')->nullable();

            $table->boolean('published')->default(true);

            $table->timestamp('published_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table = config('nova-blog.table', 'nova_blog_posts');

        Schema::dropIfExists($table);
    }
};
