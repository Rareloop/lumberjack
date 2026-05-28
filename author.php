<?php

/**
 * The template for displaying Author Archive pages
 */

namespace App;

use App\Http\Controllers\Controller;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Http\PostQuery;
use Rareloop\Lumberjack\Http\TimberContext;
use Rareloop\Lumberjack\User;

class AuthorController extends Controller
{
    public function handle(User $user, PostQuery $posts, TimberContext $context)
    {
        return new TimberResponse('templates/posts.twig', $context->merge([
            'author' => $user,
            'title' => 'Author Archives: ' . $user->name(),
            'posts' => $posts,
        ]));
    }
}
