<?php

namespace Lumberjack\Functions;

class Assets
{
    /**
     * En-queue required assets
     *
     * @param  string  $filter   The name of the filter to hook into
     * @param  integer $priority The priority to attach the filter with
     */
    public static function load($filter = 'wp_enqueue_scripts', $priority = 10)
    {
        // Register the filter
        add_filter($filter, function ($paths) {
            wp_deregister_script('jquery');

            // Load CDN jQuery in the footer
            wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', false, '1.11.3', true);

            wp_enqueue_script('jquery');
        });
    }
}
