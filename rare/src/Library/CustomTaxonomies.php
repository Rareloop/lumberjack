<?php

namespace Rare\Library;

class CustomTaxonomies
{
    public static function register()
    {
        add_action('init', ['\Rare\Library\CustomTaxonomies', 'taxonomies']);
    }

    public static function taxonomies()
    {
        // Register custom taxonomies...
    }
}
