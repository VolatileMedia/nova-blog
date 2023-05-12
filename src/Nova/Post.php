<?php

namespace Jordanbaindev\NovaBlog\Nova;

use Advoor\NovaEditorJs\NovaEditorJsField;
use App\Nova\Resource;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Slug;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string \Jordanbaindev\NovaBlog\Models\Post
     */
    public static $model = \Jordanbaindev\NovaBlog\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id'
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Blog';


    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')->rules('required'),
            Boolean::make('Is pinned', 'is_pinned')->dependsOn('', function (Boolean $field) {
                if ( config('nova-blog.hide_pinned_post_option') ) $field->hide();
            }),
            Boolean::make('Include in bloglist')->dependsOn('', function (Boolean $field) {
                if ( config('nova-blog.include_in_bloglist') ) $field->hide();
            }),
            Slug::make('Slug', 'slug')->from('Title')->onlyOnForms(),
            DateTime::make('Published at')->rules('required'),
            new Panel('Content', $this->content()),
            new Panel('SEO', $this->seoFields()),
        ];
    }

    protected function content()
    {
        return [
            Heading::make('Content'),
            Image::make('Featured image')
                ->path('blog/featured_images')
                ->preview(function ($value) {
                    return $value ? $value : null;
                })
                ->dependsOn('', function (Image $field) {
                    if ( ! config('nova-blog.include_featured_image') ) $field->hide();
                }),
            NovaEditorJsField::make('Post Introduction'),
            BelongsTo::make('Category', 'category', \Jordanbaindev\NovaBlog\Nova\PostCategory::class)
                ->dependsOn('', fn () => config('nova-blog.hide_category_selector'))
                ->nullable()->hideFromIndex(),
            NovaEditorJsField::make('Post content')->hideFromIndex()
        ];
    }

    protected function seoFields()
    {
        return [
            Heading::make('SEO'),
            Text::make('SEO Title')->hideFromIndex(),
            Text::make('SEO Description')->hideFromIndex(),
            Image::make('SEO Image')
                ->preview(function ($value) {
                    return $value ? $value : null;
                })
                ->path('blog/seo_images')->hideFromIndex(),
            Text::make('seo_image_alt'),
        ];
    }

    // public static function indexQuery(NovaRequest $request, $query)
    // {
    //     $column = config('nova-blog.blog_posts_table', 'nova_blog_posts') . '.locale';
    //     $query->doesntHave('childDraft');
    //     if (NovaBlog::hasNovaLang())
    //         $query->where(function ($subQuery) use ($column) {
    //             $subQuery->where($column, nova_lang_get_active_locale())
    //                 ->orWhereNotIn($column, array_keys(nova_lang_get_all_locales()));
    //         });
    //     return $query;
    // }
}
