<?php

namespace Rare;

use Rare\Core\Site;
use Rare\Config\ThemeSupport;
use Rare\Config\CustomPostTypes;
use Rare\Config\CustomTaxonomies;
use Rare\Config\Menus;
use Rare\Functions\Assets;

require_once('autoload.php');

/**
 * ------------------
 * Core
 * ------------------
 */

// Set up the default Timber context & extend Twig for the site
new Site;

/**
 * ------------------
 * Config
 * ------------------
 */

// Register support of certain theme features
ThemeSupport::register();

// Register any custom post types
CustomPostTypes::register();

// Register any custom taxonomies
CustomTaxonomies::register();

// Register WordPress menus
Menus::register();

/**
 * ------------------
 * Functions
 * ------------------
 */

// Enqueue assets
Assets::load();
