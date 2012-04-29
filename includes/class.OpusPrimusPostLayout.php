<?php
/**
 * Opus Primus Post Layout
 * Controls the organization and layout of the post and its content.
 *
 * @package Opus_Primus
 * @since   0.1
 */
class OpusPrimusPostLayout {
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

        /** The Post Title */
        the_title();

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
     * Outputs `the_content` or `the_excerpt` if the page being displayed is an
     * archive.
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    is_archive
     * @uses    the_content
     * @uses    the_excerpt
     */
    function opus_post_content() {
        /** Add empty filter before the post content */
        apply_filters( 'opus_before_the_content', '' );

        /** The post content */
        if ( ! is_archive() ) {
            the_content();
        } else {
            the_excerpt();
        }

        /** Add empty filter after the post content */
        apply_filters( 'opus_after_the_content', '' );

    }

    /**
     * Opus Link Pages
     * Outputs the navigation structure to move between multiple pages from the
     * same post.
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    wp_link_pages
     */
    function opus_link_pages() {
        /** Add empty filter before linking pages navigation of a multi-page post */
        apply_filters( 'opus_before_links_pages', '' );

        /** Linking pages navigation */
        wp_link_pages();

        /** Add empty filter after linking pages navigation of a multi-page post */
        apply_filters( 'opus_after_link_pages', '' );

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
     * Opus Post Link Navigation
     * Outputs the navigation structure to move between posts
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    next_posts_link
     * @uses    previous_posts_link
     */
    function opus_post_link_navigation() {
        /** Add empty filter before post link navigation */
        apply_filters( 'opus_before_post_link_navigation', '' );

        /** Post link navigation */ ?>
        <div class="navigation">
            <div class="right">
                <?php next_posts_link(); ?>
            </div>
            <div class="left">
                <?php previous_posts_link(); ?>
            </div>
        </div>

        <?php
        /** Add empty filter after post link navigation */
        apply_filters( 'opus_after_post_link_navigation', '' );

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
$opus_layout = new OpusPrimusPostLayout();
