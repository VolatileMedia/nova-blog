<?php

namespace Jordanbaindev\NovaBlog\Models;

use Spatie\EloquentSortable\{Sortable,SortableTrait};
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('nova-blog.blog_categories_table', 'blog_categories'));
    }

    /**
     * Get all of the posts for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
