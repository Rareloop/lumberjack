<?php

return [
    /**
     * The current application environment
     */
    'environment' => getenv('WP_ENV'),

    /**
     * Is debug mode enabled?
     */
    'debug' => WP_DEBUG ?? false,

    /**
     * List of providers to initialise during app boot
     */
    'providers' => [
        Rareloop\Lumberjack\Providers\RouterServiceProvider::class,
        Rareloop\Lumberjack\Providers\WordPressControllersServiceProvider::class,
        Rareloop\Lumberjack\Providers\TimberServiceProvider::class,
        Rareloop\Lumberjack\Providers\ImageSizesServiceProvider::class,
        Rareloop\Lumberjack\Providers\CustomPostTypesServiceProvider::class,
        Rareloop\Lumberjack\Providers\MenusServiceProvider::class,
        Rareloop\Lumberjack\Providers\LogServiceProvider::class,
        Rareloop\Lumberjack\Providers\ThemeSupportServiceProvider::class,
        Rareloop\Lumberjack\Providers\LogServiceProvider::class,
    ],
    
    /**
    * Logs enabled, path and level
    */
    'logs' => [
        'enabled' => false,
//         'path' => get_template_directory().'/app.log',
//         'level' => Monolog\Logger::Error,
    ],
    
    'themeSupport' => [
        'post-thumbnails',
    ],
];
