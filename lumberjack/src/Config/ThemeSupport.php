<?php

namespace Lumberjack\Config;

class ThemeSupport
{
    public static function register()
    {
        add_theme_support('post-formats');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
    }
}
