<?php

namespace App\Http;

use Rareloop\Lumberjack\Http\Lumberjack as LumberjackCore;
use App\Menu\Menu;

class Lumberjack extends LumberjackCore
{
    public function addToContext($context)
    {
        $context['is_home'] = is_home();
        $context['is_front_page'] = is_front_page();
        $context['is_logged_in'] = is_user_logged_in();

        // In Timber, you can use TimberMenu() to make a standard Wordpress menu available to the
        // Twig template as an object you can loop through. And once the menu becomes available to
        // the context, you can get items from it in a way that is a little smoother and more
        // versatile than Wordpress's wp_nav_menu. (You need never again rely on a
        // crazy "Walker Function!")
        $context['menu'] = new Menu('main-nav');

        return $context;
    }
}
