<?php

namespace Lumberjack\Config;

use Lumberjack\PostTypes\Project;

class CustomPostTypes
{
    public static function register()
    {
        add_action('init', [get_called_class(), 'types']);
    }

    public static function types()
    {
        // Project
        register_post_type(
            Project::postType(),
            [
                'labels' => [
                    'name' => __('Projects'),
                    'singular_name' => __('Project')
                ],
                'public' => true,
                'has_archive' => false,
                'supports' => [
                    'title',
                    'author',
                    'editor',
                    'thumbnail'
                ],
                'rewrite' => [
                    'slug' => 'project',
                ],
                'show_in_nav_menus' => true,
            ]
        );
    }
}
