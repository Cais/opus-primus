<?php
/**
 * 404 Template
 * Displays when a 404 error is produced, such as when a page does not exist.
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
 *
 * @version 1.0.1
 * @date    February 21, 2013
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 * Change classes from using underscores to using hyphens
 */

global $opus_archives, $opus_structures;
get_header( '404' );

/** Add empty hook before content */
do_action( 'opus_content_before' ); ?>

<div class="content-wrapper cf">

    <?php
    /** Add empty hook at top of the content */
    do_action( 'opus_content_top' );

    /** Open the necessary layout CSS classes */
    echo $opus_structures->layout_open();

    /** Add empty action before the_Loop */
    do_action( 'opus_the_loop_before' ); ?>

    <div class="the-loop">

        <?php
        printf( '<h1 class="opus-404-title-text">%1$s</h1>',
            apply_filters( 'opus_404_title_text', __( 'Something seems to have gone bust ...', 'opusprimus' ) )
        );

        /** Use action hook to add image - see Structures class for hook call */
        do_action( 'opus_404_image' );

        printf( '<p class="opus-404-message-text">%1$s</p>',
            apply_filters( 'opus_404_message_text' , __( 'This is the 404 error page; we seemed to have lost what you are looking for.', 'opusprimus' ) )
        );

        printf( '<p class="opus-404-posts-text">%1$s</p>',
            apply_filters( 'opus_404_posts_text', __( 'Were you looking for a recent post?', 'opusprimus' ) )
        );

        /** Use the_widget to display a list of recent posts */
        the_widget (
            'WP_Widget_Recent_Posts',
            $instance = array(
                'title'     => __( '', 'opusprimus' ),
                'number'    => '5',
                'show_date' => true
            )
        );

        /** Display links to archives */
        printf( '<p class="opus-404-category-text">%1$s</p>',
            apply_filters( 'opus_404_category_text', __( 'Maybe you were looking for one these categories ...', 'opusprimus' ) )
        );

        /** Display a list of categories to choose from */
        $opus_archives->categories_archive( array(
            'orderby'       => 'count',
            'order'         => 'desc',
            'show_count'    => 1,
            'hierarchical'  => 0,
            'title_li'      => '<span class="title">' . apply_filters( 'opus_404_top_10_title', __( 'Top 10 Categories by Post Count:', 'opusprimus' ) ) . '</span>',
            'number'        => 10,
        ) );

        printf( '<p class="opus-404-tag-text">%1$s</p>',
            apply_filters( 'opus_404_tag_text', __( '... or maybe you are interested in one of these tags?', 'opusprimus' ) )
        );

        /** Display a list of tags to choose from */
        $opus_archives->archive_cloud( array(
            'taxonomy'  => 'post_tag',
            'orderby'   => 'count',
            'order'     => 'DESC',
            'number'    => 10,
        ) ); ?>

    </div><!-- #the-loop -->

    <?php
    /** Add empty action after the_Loop */
    do_action( 'opus_the_loop_after' );

    get_sidebar( '404' );

    /** Close the classes written by the layout_open call */
    echo $opus_structures->layout_close();

    /** Add empty hook at the bottom of the content */
    do_action( 'opus_content_bottom' ); ?>

</div><!-- #content-wrapper -->

<?php
/** Add empty hook after the content */
do_action( 'opus_content_after' );

get_footer( '404' );