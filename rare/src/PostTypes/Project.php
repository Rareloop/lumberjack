<?php

namespace Rare\PostTypes;

class Project extends Post
{
    protected static $postType = 'rare_project';

    public static function register()
    {
        register_post_type(
            static::$postType,
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
