<?php

namespace Rare\Library;

class ThemeSupport
{
    public static function register()
    {
        add_theme_support('post-formats');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');

        if (function_exists('acf_add_options_page')) {
            acf_add_options_page();
        }
    }
}
