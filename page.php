<?php
/**
 * Page Template
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
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

/** Call the class variables */
global $opus_structures, $opus_posts, $opus_authors, $opus_navigation;
get_header( 'page' ); ?>

<div class="content-wrapper cf">

    <?php echo $opus_structures->layout_open(); ?>

    <div class="the-loop">

        <?php
        /** Add before loop sidebar */
        if ( is_active_sidebar( 'before-loop' ) ) { dynamic_sidebar( 'before-loop' ); }
        /** the_Loop begins */
        if ( have_posts() ):
            while ( have_posts() ):
                the_post(); ?>
                <div <?php post_class(); ?>>
                    <?php
                    $opus_posts->post_title();
                    $opus_posts->post_content();
                    $opus_posts->post_byline( array( 'show_mod_author' => true ) );
                    $opus_authors->post_author( array(
                        'show_mod_author'   => true,
                        'show_author_url'   => true,
                        'show_author_email' => true,
                        'show_author_desc'  => true,
                    ) ); ?>
                </div><!-- .post -->
            <?php
            endwhile;
        else:
            $opus_structures->no_search_results();
        endif;
        /** the_Loop ends */
        /** Add after loop sidebar */
        if ( is_active_sidebar( 'after-loop' ) ) { dynamic_sidebar( 'after-loop' ); } ?>

        comments_template(); ?>

    </div><!-- #the-loop -->

    <?php
    get_sidebar( 'page' );

    echo $opus_structures->layout_close(); ?>

</div><!-- #content-wrapper -->

<?php
get_footer( 'page' );