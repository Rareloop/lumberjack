<?php
/**
 * The Template for displaying all single posts
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

use Timber\Timber;
use Lumberjack\PostTypes\Project;

$context = Timber::get_context();
$post = new Project();
$context['post'] = $post;

$context['title'] = $post->title;
$context['content'] = $post->content;

Timber::render(['project.twig', 'generic-page.twig'], $context);
