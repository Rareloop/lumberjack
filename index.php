<?php

/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 */

namespace App;

use App\Http\Controllers\Controller;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Http\PostQuery;
use Rareloop\Lumberjack\Http\TimberContext;

class IndexController extends Controller
{
    public function handle(PostQuery $posts, TimberContext $context)
    {
        return new TimberResponse('templates/posts.twig', $context->merge([
            'posts' => $posts,
        ]));
    }
}
