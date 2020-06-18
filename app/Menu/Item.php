<?php

namespace App\Menu;

use Timber\MenuItem as TimberMenuItem;

class Item extends TimberMenuItem
{
    public $PostClass = 'Rareloop\Lumberjack\Post';
    public $listItemClass = 'page-list__item';

    public function __construct($data)
    {
        parent::__construct($data);

        // Add a modifier class if the item is the current page
        if ($data->current) {
            $this->add_class($this->listItemClass . '--current');
        }
    }
}
