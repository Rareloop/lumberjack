<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 */

namespace App;

use App\Http\Controllers\Controller;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Page;
use Rareloop\Lumberjack\Http\TimberContext;

class PageController extends Controller
{
    public function handle(Page $page, TimberContext $context)
    {
        return new TimberResponse('templates/generic-page.twig', $context->merge([
            'post' => $page,
            'title' => $page->title,
            'content' => $page->content,
        ]));
    }
}
