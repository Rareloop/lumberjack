<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

use Timber\Timber;
use Lumberjack\PostTypes\Post;

$templates = ['search.twig', 'posts.twig', 'generic-page.twig'];
$context = Timber::get_context();

$searchQuery = get_search_query();

$context['title'] = 'Search results for '.$searchQuery;
$context['posts'] = Post::query([
    's' => $searchQuery
]);

Timber::render($templates, $context);
