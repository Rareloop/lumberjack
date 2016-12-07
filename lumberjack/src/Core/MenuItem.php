<?php

namespace Lumberjack\Core;

use Timber\MenuItem as TimberMenuItem;

class MenuItem extends TimberMenuItem
{
    public $PostClass = 'Lumberjack\PostTypes\Post';

    public $listItemClass = 'page-list__item';

    public function __construct($data)
    {
        parent::__construct($data);

        // Add a modifier class if the item is the current page
        if ($data->current) {
            $this->add_class($this->listItemClass.'--current');
        }
    }
}
