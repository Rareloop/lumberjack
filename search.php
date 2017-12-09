<?php
/**
 * Search results page
 */

namespace App;

use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Post;
use Timber\Timber;

class SearchController
{
    public function handle()
    {
        $context = Timber::get_context();
        $searchQuery = get_search_query();

        $context['title'] = 'Search results for \''.htmlspecialchars($searchQuery).'\'';
        $context['posts'] = Post::query([
            's' => $searchQuery,
        ]);

        return new TimberResponse('templates/posts.twig', $context);
    }
}
