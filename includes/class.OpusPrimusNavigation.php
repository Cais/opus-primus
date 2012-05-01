<?php
/**
 * Opus Primus Navigation
 * Controls for the navigation between multi-page posts, site pages, and menu
 * navigation structures.
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

        /** Linking pages navigation */ ?>
        <div class="navigation">
            <?php wp_link_pages(); ?>
        </div>

        <?php
        /** Add empty filter after linking pages navigation of a multi-page post */
        apply_filters( 'opus_after_link_pages', '' );

    }

    /**
     * Opus Posts Link
     * Outputs the navigation structure to move between posts
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    next_posts_link
     * @uses    previous_posts_link
     */
    function opus_posts_link() {
        /** Add empty filter before posts link */
        apply_filters( 'opus_before_posts_link', '' );

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
        /** Add empty filter after posts link */
        apply_filters( 'opus_after_posts_link', '' );

    }

    /**
     * Opus Primus Primary Menu
     * Define the primary menu parameters
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    wp_nav_menu
     */
    function opus_primus_primary_menu() {
        wp_nav_menu( array(
            'theme_location'    => 'primary',
            'menu_class'        => 'nav',
            'fallback_cb'       => 'OpusPrimusNavigation::opus_primus_list_pages',
        ) );
    }

    /**
     * Opus Primus List Pages
     * Callback function for the menu
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    wp_list_pages
     */
    function opus_primus_list_pages() { ?>
        <ul class="nav"><?php wp_list_pages( 'title_li=' ); ?></ul>
    <?php
    }

    /**
     * Opus Primary Menu
     * Primary navigation menu
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    opus_primus_primary_menu
     * @uses    wp_nav_menu
     */
    function opus_primary_menu() {
        /** Add empty filter before the primary menu */
        apply_filters( 'opus_before_primary_menu', '' );

        /** Primary Menu */
        $this->opus_primus_primary_menu();

        /** Add empty filter after the primary menu */
        apply_filters( 'opus_after_primary_menu', '' );

    }

    /**
     * Opus Primus Secondary Menu
     * Define the secondary menu parameters
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    wp_nav_menu
     */
    function opus_primus_secondary_menu() {
        wp_nav_menu( array(
            'theme_location'    => 'secondary',
            'menu_class'        => 'nav',
            'fallback_cb'       => 'OpusPrimusNavigation::opus_primus_list_pages',
        ) );
    }

    /**
     * Opus Secondary Menu
     * Secondary navigation menu
     *
     * @package OpusPrimus
     *
     * @uses    apply_filters
     * @uses    opus_primus_secondary_menu
     * @uses    wp_nav_menu
     */
    function opus_secondary_menu() {
        /** Add empty filter before the primary menu */
        apply_filters( 'opus_before_secondary_menu', '' );

        /** Primary Menu */
        $this->opus_primus_secondary_menu();

        /** Add empty filter after the primary menu */
        apply_filters( 'opus_after_secondary_menu', '' );

    }

}
$opus_nav = new OpusPrimusNavigation;