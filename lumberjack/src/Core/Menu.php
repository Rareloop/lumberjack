<?php

namespace Lumberjack\Core;

use Timber\Menu as TimberMenu;

class Menu extends TimberMenu
{
    public $MenuItemClass = 'Lumberjack\Core\MenuItem';
    public $PostClass = 'Lumberjack\PostTypes\Post';
}
