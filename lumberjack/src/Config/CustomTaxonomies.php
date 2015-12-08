<?php

namespace Lumberjack\Config;

class CustomTaxonomies
{
    public static function register()
    {
        add_action('init', [get_called_class(), 'taxonomies']);
    }

    public static function taxonomies()
    {
        // Register custom taxonomies...
    }
}
