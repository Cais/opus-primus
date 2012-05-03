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
    function __construct() {}

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
        /** Add empty hook before the post title */
        do_action( 'opus_before_post_title' );

        /** The Post Title */ ?>
        <h2><?php the_title(); ?></h2>

        <?php
        /** Add empty hook after the post title */
        do_action( 'opus_after_post_title' );

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
     * @param       string $anchor_word - word or phrase to use as anchor text when no title is present
     *
     * @uses        apply_filters
     * @uses        get_permalink
     * @uses        get_the_excerpt
     * @uses        get_the_title
     *
     * @return      string - URL|text
     */
    function opus_primus_no_title_link( $anchor_word ) {
        /** Create URL or string text */
        $opus_no_title = get_the_title();
        empty( $opus_no_title )
            ? $opus_no_title = '<span class="no-title"><a href="' . get_permalink() . '" title="' . get_the_excerpt() . '">' . $anchor_word . '</span></a>'
            : $opus_no_title = $anchor_word;
        return apply_filters( 'opus_primus_no_title_link', $opus_no_title );
    }

    /**
     * Opus Post By Line
     * Outputs post meta details consisting of a configurable anchor_word for post
     * link anchor text, the date and time posted, and the post author. The post
     * author is also linked to the author's archive page.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $anchor_word ( default = Posted )
     * @param   string $show_mod_author ( default = false )
     *
     * @uses    do_action
     * @uses    esc_attr
     * @uses    get_author_posts_url
     * @uses    get_option ( date_format, time_format )
     * @uses    get_the_author
     * @uses    get_the_author_meta ( ID )
     * @uses    get_the_date
     * @uses    get_the_time
     * @uses    opus_primus_no_title_link
     */
    function opus_post_byline( $anchor_word = 'Posted', $show_mod_author = 'false' ) {
        /** Add empty hook before post by line */
        do_action( 'opus_before_post_byline' );

        /** Post Meta details - inspired by TwentyTen */
        printf( __( '%1$s on %2$s at %3$s by %4$s', 'opusprimus' ),
            $this->opus_primus_no_title_link( $anchor_word ),
            get_the_date( get_option( 'date_format' ) ),
            get_the_time( get_option( 'time_format' ) ),
            sprintf( '<span class="author-url"><a class="archive-url" href="%1$s" title="%2$s">%3$s</a></span>',
                get_author_posts_url( get_the_author_meta( 'ID' ) ),
                esc_attr( sprintf( __( 'View all posts by %1$s', 'opusprimus' ), get_the_author() ) ),
                get_the_author()
            )
        );

        /** Modified Post Author */
        if ( $show_mod_author ) {
            $this->opus_primus_modified_post();
        }

        /** Add empty hook after post by line */
        do_action( 'opus_after_post_byline' );

    }

    /**
     * Opus Primus Modified Post
     *
     * If the post time and the last modified time are different display
     * modified date and time and the modifying author
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @internal    Original author Edward Caissie <edward.caissie@gmail.com>
     *
     * @uses    (global) $post
     * @uses    do_action
     * @uses    get_post_meta
     * @uses    get_the_modified_date
     * @uses    get_the_modified_time
     * @uses    get_the_time
     * @uses    get_userdata
     * @uses    home_url
     */
    function opus_primus_modified_post(){
        /** Add empty hook before modified post author */
        do_action( 'opus_before_modified_post' );

        /** Grab the $post object */
        global $post;
        /** @var $last_user - establish the last user */
        $last_user = '';
        if ( $last_id = get_post_meta( $post->ID, '_edit_last', true ) ) {
            $last_user = get_userdata( $last_id );
        }
        /** Check if there is a time difference from the original post date */
        if ( get_the_time() <> get_the_modified_time() ) {
            printf( __( 'Last modified by %1$s on %2$s @ %3$s.', 'opusprimus' ),
                '<a href="' . home_url( '?author=' . $last_user->ID ) . '">' . $last_user->display_name . '</a>',
                get_the_modified_date( get_option( 'date_format' ) ),
                get_the_modified_time( get_option( 'time_format' ) ) );
        }

        /** Add empty hook after modified post author */
        do_action( 'opus_after_modified_post' );

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
     * @param       string $anchor_word ( default = Posted )
     *
     * @uses    do_action
     * @uses    get_permalink
     * @uses    get_post_type
     * @uses    get_the_category_list
     * @uses    get_the_tag_list
     * @uses    is_object_in_taxonomy
     * @uses    opus_primus_no_title_link
     * @uses    the_title_attribute
     */
    function opus_primus_meta_tags( $anchor_word = 'Posted' ) {
        /** Add empty hook before meta tags */
        do_action( 'opus_before_meta_tags' );

        /** Retrieves tag list of current post, separated by commas. */
        $opus_tag_list = get_the_tag_list( '', ', ', '' );
        if ( $opus_tag_list ) {
            $posted_in = __( '%1$s in %2$s and tagged %3$s. Bookmark the <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a>.', 'opusprimus' );
        } elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
            $posted_in = __( '%1$s in %2$s. Bookmark the <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a>.', 'opusprimus' );
        } else {
            $posted_in = __( 'Bookmark the <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a>.', 'opusprimus' );
        }
        /** Prints the string, replacing the placeholders. */
        printf( '<div class="meta-tags">' . $posted_in . '</div>',
            $this->opus_primus_no_title_link( $anchor_word ),
            get_the_category_list( ', ' ),
            $opus_tag_list,
            get_permalink(),
            the_title_attribute( 'echo=0' )
        );

        /** Add empty hook after meta tags */
        do_action( 'opus_after_meta_tags' );

    }

    /**
     * Opus Post Content
     * Outputs `the_content`
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    the_content
     */
    function opus_post_content() {
        /** Add empty hook before the content */
        do_action( 'opus_before_the_content' );

        /** The post excerpt */
        the_content();

        /** Add empty hook after the content */
        do_action( 'opus_after_the_content' );

    }

    /**
     * Opus Post Excerpt
     * Outputs `the_excerpt`
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    the_excerpt
     */
    function opus_post_excerpt() {
        /** Add empty hook before the excerpt */
        do_action( 'opus_before_the_excerpt' );

        /** The post excerpt */
        the_excerpt();

        /** Add empty hook after the excerpt */
        do_action( 'opus_after_the_excerpt' );

    }

    /**
     * Opus Post Author
     * Outputs the author details: web address, email, and biography from the
     * use profile information - not designed for use in the post meta section.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    the_author
     * @uses    get_query_var
     * @uses    get_user_by
     * @uses    get_userdata
     * @uses    user_can
     *
     * @todo Needs to be fixed
     */
    function opus_post_author() {
        $curauth = ( get_query_var( 'author_name ' ) ) ? get_user_by( 'id', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );

        /** Add empty hook before post author details */
        do_action( 'opus_before_post_author' );

        /** Author details */ ?>
        <div id="author" class="<?php
            /** Add class as related to the user role (see 'Role:' drop-down in User options) */
            if ( user_can( $curauth->ID, 'administrator' ) ) {
                echo 'administrator';
            } elseif ( user_can( $curauth->ID, 'editor' ) ) {
                echo 'editor';
            } elseif ( user_can( $curauth->ID, 'contributor' ) ) {
                echo 'contributor';
            } elseif ( user_can( $curauth->ID, 'subscriber' ) ) {
                echo 'subscriber';
            } else {
                echo 'guest';
            }
            if ( ( $curauth->ID ) == '1' ) echo ' administrator-prime'; ?>">
            <h2><?php _e( 'About ', 'shades' ); ?><?php echo $curauth->display_name; ?></h2>
            <ul>
                <?php if ( ! empty( $curauth->user_url ) ) { ?>
                <li><?php _e( 'Website', 'shades' ); ?>: <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a> <?php _e( 'or', 'shades' ); ?> <a href="mailto:<?php echo $curauth->user_email; ?>"><?php _e( 'email', 'shades' ); ?></a></li>
                <?php
                }
                if ( ! empty( $curauth->user_description ) ) { ?>
                    <li><?php _e( 'Biography', 'shades' ); ?>: <?php echo $curauth->user_description; ?></li>
                <?php } ?>
            </ul>
        </div><!-- #author -->

        <?php
        /** Add empty hook after post author details */
        do_action( 'opus_after_post_author' );

    }

    /**
     * Opus Search
     * Outputs message if no posts are found by 'the_Loop' query
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    esc_html
     * @uses    get_search_form
     * @uses    get_search_query
     */
    function opus_search(){
        /** Add empty hook before no posts results from the_loop query */
        do_action( 'opus_before_search' );

        /** No results from the_loop query */
        printf( __( 'Search Results for: %s', 'opus' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
        get_search_form();

        /** Add empty hook after no posts results from the_loop query */
        do_action( 'opus_after_search' );

    }
}
$opus_structure = new OpusPrimusPostStructures();