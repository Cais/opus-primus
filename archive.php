<?php
/**
 * Archive Template
 * A generic template to show when no other more specific archive template is
 * available to use. See the link below.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
 *
 * @link        http://codex.wordpress.org/Template_Hierarchy - URI reference
 *
 * This file is part of Opus Primus.
 *
 * Opus Primus is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

/** Call the Post Structure and Navigation class variables */
global $opus_nav, $opus_structure;

get_header( get_post_format() );

$opus_nav->opus_post_link();
if ( have_posts() ):
    while ( have_posts() ):
        the_post();

        $opus_structure->opus_post_title();
        $opus_structure->opus_post_byline( array( 'tempus' => 'time' ) );
        $opus_structure->opus_primus_comments_link();
        $opus_structure->opus_post_excerpt();
        $opus_structure->opus_primus_meta_tags();
        $opus_nav->opus_link_pages();

        comments_template();
    endwhile;
else:
    $opus_structure->opus_search();
endif;

get_sidebar( get_post_format() );
get_footer( get_post_format() );