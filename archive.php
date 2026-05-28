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
use Rareloop\Lumberjack\Http\PostQuery;
use Rareloop\Lumberjack\Http\TimberContext;

class ArchiveController extends Controller
{
    public function handle(PostQuery $posts, TimberContext $context)
    {
        return new TimberResponse('templates/posts.twig', $context->merge([
            'title' => $this->getPageTitle(),
            'posts' => $posts,
        ]));
    }

    private function getPageTitle()
    {
        if (is_day()) {
            return 'Archive: ' . get_the_date('D M Y');
        }

        if (is_month()) {
            return 'Archive: ' . get_the_date('M Y');
        }

        if (is_year()) {
            return 'Archive: ' . get_the_date('Y');
        }

        if (is_tag()) {
            return single_tag_title('', false);
        }

        if (is_category()) {
            return single_cat_title('', false);
        }

        if (is_post_type_archive()) {
            return post_type_archive_title('', false);
        }

        return 'Archive';
    }
}
