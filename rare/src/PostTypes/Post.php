<?php

namespace Rare\PostTypes;

use Timber;
use TimberPost;

class Post extends TimberPost
{
    protected static $postType = 'post';

    public static function all($perPage = -1)
    {
        $args = [
            'post_type'     => static::$postType,
            'post_status'   => 'publish',
            'posts_per_page' => $perPage,
            'orderby'       => 'menu_order',
            'order'         => 'ASC'
        ];

        return static::posts($args);
    }

    /**
     * Convienience function that takes a standard set of WP_Query arguments but mixes it with
     * arguments that mean we're selecting the right post type
     *
     * @param  array $args standard WP_Query array
     * @return array           An array of Post objects
     */
    public static function query($args = null)
    {
        $args = is_array($args) ? $args : [];

        // Set the correct post type
        $args = array_merge($args, ['post_type' => static::$postType]);

        if (!isset($args['post_status'])) {
            $args['post_status'] = 'publish';
        }

        return static::posts($args);
    }

    /**
     * Raw query function that uses the arguments provided to make a call to Timber::get_posts
     * and casts the returning data in instances of ourself.
     *
     * @param  array $args standard WP_Query array
     * @return array           An array of Post objects
     */
    public static function posts($args = null)
    {
        return Timber::get_posts($args, get_called_class());
    }

    /**
     * Get the current post type
     */
    public static function postType()
    {
        return static::$postType;
    }
}
