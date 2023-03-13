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
        $categoriesTable = config('nova-blog.blog_categories_table', 'blog_categories');

        Schema::create($categoriesTable, function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->default('');
            $table->integer('sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_category');
    }
};
