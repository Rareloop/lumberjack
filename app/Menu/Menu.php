<?php

namespace App\Menu;

use Timber\Menu as TimberMenu;

class Menu extends TimberMenu
{
    public $MenuItemClass = 'App\Menu\Item';
    public $PostClass = 'Rareloop\Lumberjack\Post';
}
