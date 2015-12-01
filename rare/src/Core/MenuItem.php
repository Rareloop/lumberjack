<?php

namespace Rare\Core;

use TimberMenuItem;

class MenuItem extends TimberMenuItem
{
    public $PostClass = 'Rare\PostTypes\Post';

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
