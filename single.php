<?php

/**
 * The Template for displaying all single posts
 */

namespace App;

use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Post;
use Timber\Timber;

class SingleController
{
    public function handle()
    {
        $context = Timber::get_context();
        $post = new Post();

        $context['post'] = $post;
        $context['title'] = $post->title;
        $context['content'] = $post->content;

        return new TimberResponse('templates/generic-page.twig', $context);
    }
}
