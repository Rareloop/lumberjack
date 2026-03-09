<?php

namespace App\Menu;

use Timber\Menu as TimberMenu;
use Timber\MenuItem as TimberMenuItem;
use WP_Post;

class Item extends TimberMenuItem
{
    public $listItemClass = 'page-list__item';

    public function __construct(?WP_Post $data = null, ?TimberMenu $menu = null)
    {
        parent::__construct($data, $menu);

        // Add a modifier class if the item is the current page
        if ($data->current) {
            $this->add_class($this->listItemClass . '--current');
        }
    }
}
