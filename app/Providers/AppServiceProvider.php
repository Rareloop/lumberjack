<?php

namespace App\Providers;

use App\Menu\Item;
use App\Menu\Menu;
use Illuminate\Support\Arr;
use Rareloop\Lumberjack\Page;
use Rareloop\Lumberjack\Post;
use Rareloop\Lumberjack\Providers\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any app specific items into the container
     */
    public function register() {}

    /**
     * Perform any additional boot required for this application
     */
    public function boot()
    {
        add_filter('timber/post/classmap', fn($classmap) => [
            ...Arr::wrap($classmap),
            Post::getPostType() => Post::class,
            Page::getPostType() => Page::class,
        ]);

        add_filter('timber/menu/class', fn() => Menu::class);
        add_filter('timber/menuitem/class', fn() => Item::class);
    }
}
