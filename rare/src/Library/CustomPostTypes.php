<?php

namespace Rare\Library;

use Rare\PostTypes\Project;

class CustomPostTypes
{
    public static function register()
    {
        add_action('init', ['\Rare\Library\CustomPostTypes', 'types']);
    }

    public static function types()
    {
        Project::register();
    }
}
