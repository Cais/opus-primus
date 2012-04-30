<?php
/**
 * Opus Primus Navigation
 * Controls for the navigation between multi-page posts, site pages, and menu
 * navigation structures.
 *
 * @package Opus_Primus
 * @since   0.1
 */
class OpusPrimusNavigation {
    /** Construct */
    function __construct() {

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
     * Opus Posts Link Navigation
     * Outputs the navigation structure to move between posts
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    next_posts_link
     * @uses    previous_posts_link
     */
    function opus_posts_link_navigation() {
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
     * Opus Primary Menu
     * Primary navigation menu
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    wp_nav_menu
     */
    function opus_primary_menu() {
        /** Add empty filter before the primary menu */
        apply_filters( 'opus_before_primary_menu', '' );

        /** Primary Menu */
        opus_primus_primary_menu();

        /** Add empty filter after the primary menu */
        apply_filters( 'opus_after_primary_menu', '' );

    }

    /**
     * Opus Secondary Menu
     * Secondary navigation menu
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    wp_nav_menu
     */
    function opus_secondary_menu() {
        /** Add empty filter before the primary menu */
        apply_filters( 'opus_before_secondary_menu', '' );

        /** Primary Menu */
        opus_primus_secondary_menu();

        /** Add empty filter after the primary menu */
        apply_filters( 'opus_after_secondary_menu', '' );

    }

}
$opus_nav = new OpusPrimusNavigation;