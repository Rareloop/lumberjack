<?php

namespace Rare;

use Rare\Library\Site;
use Rare\Library\ThemeSupport;
use Rare\Library\CustomPostTypes;
use Rare\Library\CustomTaxonomies;
use Rare\Functions\Assets;
use Rare\Functions\Menus;

require_once('autoload.php');

// Set up the default Timber context & extend Twig for the site
new Site;

// Register support of certain theme features
ThemeSupport::register();

// Register any custom post types
CustomPostTypes::register();

// Register any custom taxonomies
CustomTaxonomies::register();

// Enqueue assets
Assets::load();

// Register WordPress menus
Menus::register();
