<?php
/**
 * Opus Primus Navigation
 * Controls for the navigation between multi-page posts, site pages, and menu
 * navigation structures.
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

class OpusPrimusNavigation {
    /** Construct */
    function __construct() {}

    /**
     * Opus Link Pages
     * Outputs the navigation structure to move between multiple pages from the
     * same post. All parameters used by `wp_link_pages` can be passed through
     * the function.
     *
     * @link    http://codex.wordpress.org/Function_Reference/wp_link_pages
     * @example opus_link_pages( array( 'before' => '<p class="navigation link-pages cf">', 'after' => '</p>' ) );
     * @internal The above example will output the `wp_link_pages` output in a
     * wrapper consisting of a `p` tag with `classes`
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string|array $link_pages_args
     *
     * @uses    do_action
     * @uses    wp_link_pages
     */
    function opus_link_pages( $link_pages_args = '' ) {
        /** @var $defaults - initial values */
        $defaults = array(
            'before'    => '<p class="navigation link-pages cf">',
            'after'     => '</p>',
        );
        $link_pages_args = wp_parse_args( (array) $defaults, $link_pages_args );

        /** Add empty hook before linking pages navigation of a multi-page post */
        do_action( 'opus_before_links_pages' );

        /** Linking pages navigation */
        wp_link_pages( $link_pages_args );

        /** Add empty hook after linking pages navigation of a multi-page post */
        do_action( 'opus_after_link_pages' );

    }

    /**
     * Opus Posts Link
     * Outputs the navigation structure to move between archive pages
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    next_posts_link
     * @uses    previous_posts_link
     */
    function opus_posts_link() {
        /** Add empty hook before posts link */
        do_action( 'opus_before_posts_link' );

        /** Posts link navigation */ ?>
        <p class="navigation posts-link cf">
            <span class="right"><?php next_posts_link(); ?></span>
            <span class="left"><?php previous_posts_link(); ?></span>
        </p>

        <?php
        /** Add empty hook after posts link */
        do_action( 'opus_after_posts_link' );

    }

    /**
     * Opus Post Link
     * Outputs the navigation structure to move between posts
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    next_posts_link
     * @uses    previous_posts_link
     */
    function opus_post_link() {
        /** Add empty hook before post link */
        do_action( 'opus_before_post_link' );

        /** Post link navigation */ ?>
        <p class="navigation post-link cf">
            <span class="right"><?php next_post_link(); ?></span>
            <span class="left"><?php previous_post_link(); ?></span>
        </p>

        <?php
        /** Add empty hook after post link */
        do_action( 'opus_after_post_link' );

    }

    /**
     * Opus Primus Primary Menu
     * Define the primary menu parameters, these are passed through to the
     * fallback function `opus_primus_page_menu`
     *
     * @link    http://codex.wordpress.org/Function_Reference/wp_nav_menu
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string|array $primary_menu_args
     *
     * @uses    opus_primus_page_menu
     * @uses    wp_nav_menu
     * @uses    wp_parse_args
     */
    function opus_primus_primary_menu( $primary_menu_args ) {
        $defaults = array(
            'theme_location'    => 'primary',
            'menu_class'        => 'nav primary',
            'fallback_cb'       => 'OpusPrimusNavigation::opus_primus_page_menu',
        );
        $primary_menu_args = wp_parse_args( (array) $defaults, $primary_menu_args );
        wp_nav_menu( $primary_menu_args );
    }

    /**
     * Opus Primus Page Menu
     * Callback function for the wp_nav_menu call; accepts wp_nav_menu arguments
     * passed through the callback function.
     *
     * @link    http://codex.wordpress.org/Function_Reference/wp_page_menu
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string|array $page_menu_args
     *
     * @uses    wp_page_menu
     * #uses    wp_parse_args
     */
    function opus_primus_page_menu( $page_menu_args = '' ) {
        $defaults = array();
        $page_menu_args = wp_parse_args( (array) $defaults, $page_menu_args );
        wp_page_menu( $page_menu_args );
    }

    /**
     * Opus Primary Menu
     * Primary navigation menu
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string|array $primary_menu_args
     *
     * @uses    do_action
     * @uses    opus_primus_primary_menu
     * @uses    wp_nav_menu
     */
    function opus_primary_menu( $primary_menu_args = '' ) {
        /** Add empty hook before the primary menu */
        do_action( 'opus_before_primary_menu' );

        /** Primary Menu */
        $this->opus_primus_primary_menu( $primary_menu_args );

        /** Add empty hook after the primary menu */
        do_action( 'opus_after_primary_menu' );

    }

    /**
     * Opus Primus Secondary Menu
     * Define the secondary menu parameters, these are passed through to the
     * fallback function `opus_primus_page_menu`
     *
     * @link    http://codex.wordpress.org/Function_Reference/wp_nav_menu
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string|array $secondary_menu_args
     *
     * @uses    opus_primus_page_menu
     * @uses    wp_nav_menu
     * @uses    wp_parse_args
     */
    function opus_primus_secondary_menu( $secondary_menu_args ) {
        $defaults = array(
            'theme_location'    => 'secondary',
            'menu_class'        => 'nav secondary',
            'fallback_cb'       => 'OpusPrimusNavigation::opus_primus_page_menu',
        );
        $secondary_menu_args = wp_parse_args( (array) $defaults, $secondary_menu_args );
        wp_nav_menu( $secondary_menu_args );
    }

    /**
     * Opus Secondary Menu
     * Secondary navigation menu
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string|array $secondary_menu_args
     *
     * @uses    do_action
     * @uses    opus_primus_secondary_menu
     * @uses    wp_nav_menu
     */
    function opus_secondary_menu( $secondary_menu_args = '' ) {
        /** Add empty hook before the primary menu */
        do_action( 'opus_before_secondary_menu' );

        /** Primary Menu */
        $this->opus_primus_secondary_menu( $secondary_menu_args );

        /** Add empty hook after the primary menu */
        do_action( 'opus_after_secondary_menu' );

    }

    /**
     * Opus Primus Search Page Menu
     * Callback function for the menu
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string|array $list_args
     *
     * @uses    wp_page_menu
     * #uses    wp_parse_args
     */
    function opus_primus_search_page_menu( $list_args = '' ) {
        $defaults = array(
            'depth'     => 1,
            'show_home' => true,
        );
        $list_args = wp_parse_args( (array) $defaults, $list_args ); ?>
        <ul class="nav search">
            <?php wp_page_menu( $list_args ); ?>
        </ul>
    <?php
    }

    /**
     * Opus Primus Search Menu
     * Define the search results menu parameters
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string|array $search_menu_args
     *
     * @uses    opus_primus_search_page_menu
     * @uses    wp_nav_menu
     * @uses    wp_parse_args
     */
    function opus_primus_search_menu( $search_menu_args = '' ) {
        $defaults = array(
            'theme_location'    => 'search',
            'container'         => 'li',
            'menu_class'        => 'nav search',
            'fallback_cb'       => 'OpusPrimusNavigation::opus_primus_search_page_menu',
        );
        $search_menu_args = wp_parse_args( (array) $defaults, $search_menu_args );
        printf( '<ul class="featured search pages"><li><span class="title">%1$s</span>', __( 'Featured Pages:', 'opusprimus' ) );
            wp_nav_menu( $search_menu_args );
        echo '</li></ul>';
    }

    /**
     * Opus Search Menu
     * Search results navigation menu
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    opus_primus_search_menu
     * @uses    wp_nav_menu
     */
    function opus_search_menu() {
        /** Add empty hook before the primary menu */
        do_action( 'opus_before_search_menu' );

        /** Primary Menu */
        $this->opus_primus_search_menu();

        /** Add empty hook after the primary menu */
        do_action( 'opus_after_search_menu' );

    }

    /**
     * Opus Primus Comments Navigation
     * Displays a link between pages of comments
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    next_comments_link
     * @uses    previous_comments_link
     */
    function opus_comments_navigation() {
        /** Add empty hook before comments link */
        do_action( 'opus_before_comments_link' ); ?>

        <p class="navigation comment-link cf">
            <span class="left"><?php previous_comments_link() ?></span>
            <span class="right"><?php next_comments_link() ?></span>
        </p>

        <?php
        /** Add empty hook after comments link */
        do_action( 'opus_after_comments_link' );
    }

}
$opus_nav = new OpusPrimusNavigation();