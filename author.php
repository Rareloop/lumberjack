<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */
global $wp_query;

use Timber\Timber;
use Timber\User as TimberUser;
use Lumberjack\PostTypes\Post;

$data = Timber::get_context();

if (isset($wp_query->query_vars['author'])) {
    $author = new TimberUser($wp_query->query_vars['author']);

    $data['author'] = $author;
    $data['title'] = 'Author Archives: '.$author->name();

    $data['posts'] = Post::query([
        'author' => $author->ID
    ]);
}


Timber::render(['author.twig', 'posts.twig', 'generic-page.twig'], $data);
