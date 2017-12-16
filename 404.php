<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

namespace App;

use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Timber\Timber;

/**
 * Class names can not start with a number so the 404 controller has a special cased name
 */
class Error404Controller
{
    public function handle()
    {
        return new TimberResponse('templates/errors/404.twig', [], 404);
    }
}
