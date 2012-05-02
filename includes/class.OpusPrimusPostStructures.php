<?php
/**
 * Opus Primus Post Structures
 * Controls for the organization and layout of the post and its content.
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

class OpusPrimusPostStructures {
    /** Construct */
    function __construct() {

    }

    /**
     * Opus Post Title
     * Outputs the post title
     *
     * @package OpusPrimus
     * @since   0.1
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
     * Opus Primus Use Posted
     *
     * This returns a URL to the post using the anchor text 'Posted' in the meta
     * details with the post excerpt as the URL title; or, returns the word
     * 'Posted' if the post title exists
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @param       string $keyword - word or phrase to use as anchor text when no title is present
     * @return      string - URL|Posted
     */
    function opus_primus_no_title_link( $keyword ) {
        $opus_no_title = get_the_title();
        empty( $opus_no_title )
            ? $opus_no_title = '<span class="no-title"><a href="' . get_permalink() . '" title="' . get_the_excerpt() . '">' . $keyword . '</span></a>'
            : $opus_no_title = $keyword;
        return apply_filters( 'opus_primus_no_title_link', $opus_no_title );
    }

    /**
     * Opus Post By Line
     * Outputs post meta details consisting of a configurable keyword for post
     * link anchor text, the date and time posted, and the post author. The post
     * author is also linked to the author's archive page.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $keyword default = Posted
     *
     * @uses    apply_filters
     * @uses    esc_attr
     * @uses    get_author_posts_url
     * @uses    get_option - date_format, time_format
     * @uses    get_the_author
     * @uses    get_the_author_meta - ID
     * @uses    get_the_date
     * @uses    get_the_time
     * @uses    opus_primus_no_title_link
     */
    function opus_post_byline( $keyword = 'Posted' ) {
        /** Add empty filter before post meta */
        apply_filters( 'opus_before_post_meta', '' );

        /** Post Meta details - inspired by TwentyTen */
        printf( __( '%1$s on %2$s at %3$s by %4$s', 'opusprimus' ),
            $this->opus_primus_no_title_link( $keyword ),
            get_the_date( get_option( 'date_format' ) ),
            get_the_time( get_option( 'time_format' ) ),
            sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                get_author_posts_url( get_the_author_meta( 'ID' ) ),
                esc_attr( sprintf( __( 'View all posts by %s', 'opusprimus' ), get_the_author() ) ),
                get_the_author()
            )
        );

        /** Add empty filter after post meta */
        apply_filters( 'opus_after_meta_filter', '' );

    }

    /**
     * Opus Primus Meta Tags
     *
     * Prints HTML with meta information for the current post (category, tags
     * and permalink) - inspired by TwentyTen
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @internal    REQUIRES use within the_Loop
     *
     * @uses    get_permalink
     * @uses    get_post_type
     * @uses    get_the_category_list
     * @uses    get_the_tag_list
     * @uses    is_object_in_taxonomy
     * @uses    the_title_attribute
     *
     * @todo Review structure and text to make more unique
     */
    function opus_primus_meta_tags() {
        /** Retrieves tag list of current post, separated by commas. */
        $opus_tag_list = get_the_tag_list( '', ', ', '' );
        if ( $opus_tag_list ) {
            $posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'opusprimus' );
        } elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
            $posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'opusprimus' );
        } else {
            $posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'opusprimus' );
        }
        /** Prints the string, replacing the placeholders. */
        printf(
            $posted_in,
            get_the_category_list( ', ' ),
            $opus_tag_list,
            get_permalink(),
            the_title_attribute( 'echo=0' )
        );
    }

    /**
     * Opus Post Content
     * Outputs `the_content`
     *
     * @package OpusPrimus
     * @since   0.1
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
     * @since   0.1
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
     * @since   0.1
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
     * @since   0.1
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