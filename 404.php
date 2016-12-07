<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

use Timber\Timber;

$context = Timber::get_context();

$context['pageHeading'] = ['title' => 'Page Not Found'];
$context['content'] = '<p>We\'re sorry but the page you\'re looking for can\'t be found.</p>';

Timber::render(['404.twig', 'generic-page.twig'], $context);
