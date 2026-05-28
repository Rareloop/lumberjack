<?php

/**
 * Search results page
 */

namespace App;

use App\Http\Controllers\Controller;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Http\PostQuery;
use Rareloop\Lumberjack\Http\TimberContext;

class SearchController extends Controller
{
    public function handle(PostQuery $posts, TimberContext $context)
    {
        $searchQuery = get_search_query();

        return new TimberResponse('templates/posts.twig', $context->merge([
            'title' => 'Search results for \'' . htmlspecialchars($searchQuery) . '\'',
            'posts' => $posts,
        ]));
    }
}
