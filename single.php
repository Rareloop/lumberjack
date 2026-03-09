<?php

/**
 * The Template for displaying all single posts
 */

namespace App;

use App\Http\Controllers\Controller;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Timber\Timber;

class SingleController extends Controller
{
    public function handle()
    {
        $context = Timber::context();
        $post = Timber::get_post();

        $context['post'] = $post;
        $context['title'] = $post->title;
        $context['content'] = $post->content;

        return new TimberResponse('templates/generic-page.twig', $context);
    }
}
