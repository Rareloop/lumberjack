<?php

/**
 * The Template for displaying all single posts
 */

namespace App;

use App\Http\Controllers\Controller;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Post;
use Rareloop\Lumberjack\Http\TimberContext;

class SingleController extends Controller
{
    public function handle(Post $post, TimberContext $context)
    {
        return new TimberResponse('templates/generic-page.twig', $context->merge([
            'post' => $post,
            'title' => $post->title,
            'content' => $post->content,
        ]));
    }
}
