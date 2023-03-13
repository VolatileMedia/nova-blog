<?php

namespace Jordanbaindev\NovaBlog\Models;

use Illuminate\Database\Eloquent\Model;

class RelatedPost extends Model
{
    protected $fillable = [
        'post_id', 'related_post_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('nova-blog.blog_posts_table', 'blog_related_posts'));
    }
}
