<?php
/**
 * Opus Primus Post Structures
 * Controls for the organization and layout of the post and its content.
 *
 * @package     Opus_Primus
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

class OpusPrimusPostStructures {
    /** Construct */
    function __construct() {

    }

    /**
     * Opus Post Title
     * Outputs the post title
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    the_title
     */
    function opus_post_title() {
        /** Add empty filter before the post title */
        apply_filters( 'opus_before_post_title', '' );

        /** The Post Title */ ?>
        <h2><?php the_title(); ?></h2>

        <?php
        /** Add empty filter after the post title */
        apply_filters( 'opus_after_post_title', '' );

    }

    /**
     * Opus Post Meta
     * Outputs post meta details
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     */
    function opus_post_meta() {
        /** Add empty filter before post meta */
        apply_filters( 'opus_before_post_meta', '' );

        /** Post Meta */

        /** Add empty filter after post meta */
        apply_filters( 'opus_after_meta_filter', '' );

    }

    /**
     * Opus Post Content
     * Outputs `the_content`
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    is_archive
     * @uses    the_content
     */
    function opus_post_content() {
        /** Add empty filter before the post content */
        apply_filters( 'opus_before_the_content', '' );

        /** The post excerpt */
        the_content();

        /** Add empty filter after the post content */
        apply_filters( 'opus_after_the_content', '' );

    }

    /**
     * Opus Post Excerpt
     * Outputs `the_excerpt`
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    is_archive
     * @uses    the_excerpt
     */
    function opus_post_excerpt() {
        /** Add empty filter before the post excerpt */
        apply_filters( 'opus_before_the_excerpt', '' );

        /** The post excerpt */
        the_excerpt();

        /** Add empty filter after the post excerpt */
        apply_filters( 'opus_after_the_excerpt', '' );

    }

    /**
     * Opus Post Author
     * Outputs the author details: web address, email, and biography from the
     * use profile information
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    the_author
     */
    function opus_post_author() {
        /** Add empty filter before post author details */
        apply_filters( 'opus_before_post_author', '' );

        /** Author details */
        the_author();

        /** Add empty filter after post author details */
        apply_filters( 'opus_after_post_author', '' );

    }

    /**
     * Opus Search
     * Outputs message if no posts are found by 'the_Loop' query
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    esc_html
     * @uses    get_search_form
     * @uses    get_search_query
     */
    function opus_search(){
        /** Add empty filter before no posts results from the_loop query */
        apply_filters( 'opus_before_search', '' );

        /** No results from the_loop query */
        printf( __( 'Search Results for: %s', 'opus' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
        get_search_form();

        /** Add empty filter after no posts results from the_loop query */
        apply_filters( 'opus_after_search', '' );

    }
}
$opus_structure = new OpusPrimusPostStructures;