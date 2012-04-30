<?php
/**
 * Opus Primus Post Structures
 * Controls for the organization and layout of the post and its content.
 *
 * @package Opus_Primus
 * @since   0.1
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