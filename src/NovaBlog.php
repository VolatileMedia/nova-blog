<?php

namespace Jordanbaindev\NovaBlog;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaBlog extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-blog', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-blog', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        // return MenuSection::make('Blog', [
        //     MenuItem::resource(\Jordanbaindev\NovaBlog\Nova\Category::class),
        //     MenuItem::resource(\Jordanbaindev\NovaBlog\Nova\Post::class),
        // ])->icon('user')->collapsable();
    }

    public static function getPageUrl(\Jordanbaindev\NovaBlog\Models\Post $post)
    {
        $getPostUrl = config('nova-blog.page_url');
        return isset($getPostUrl) ? call_user_func($getPostUrl, $post) : null;
    }

    public static function getLocales(): array
    {
        $localesConfig = config('nova-blog.locales', ['en' => 'English']);
        if (is_callable($localesConfig)) return call_user_func($localesConfig);
        if (is_array($localesConfig)) return $localesConfig;
        return ['en' => 'English'];
    }
}
