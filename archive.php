<?php

/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

namespace App;

use App\Http\Controllers\Controller;
use Rareloop\Lumberjack\Http\Responses\TimberResponse;
use Rareloop\Lumberjack\Post;
use Timber\Timber;

class ArchiveController extends Controller
{
    public function handle()
    {
        $data = Timber::get_context();
        $data['title'] = 'Archive';

        if (is_day()) {
            $data['title'] = 'Archive: ' . get_the_date('D M Y');
        } elseif (is_month()) {
            $data['title'] = 'Archive: ' . get_the_date('M Y');
        } elseif (is_year()) {
            $data['title'] = 'Archive: ' . get_the_date('Y');
        } elseif (is_tag()) {
            $data['title'] = single_tag_title('', false);
        } elseif (is_category()) {
            $data['title'] = single_cat_title('', false);
        } elseif (is_post_type_archive()) {
            $data['title'] = post_type_archive_title('', false);
        }

        // TODO: Currently only works for posts, fix for custom post types
        $data['posts'] = Post::query();

        return new TimberResponse('templates/posts.twig', $data);
    }
}
