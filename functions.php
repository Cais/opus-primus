<?php
/**
 * Functions
 * Where the magic happens ...
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2013, Opus Primus
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
 * @version 1.1.1
 * @date    March 23, 2013
 * Set $content_width to 1000 (matches 'Full Size Video' maximum width)
 */

/**
 * Call the initialization file to get things fired-up!
 * - Define CONSTANTS
 * - Add Widgets
 * - Add Classes
 * - Add Extensions
 */
require_once( get_template_directory() . '/includes/opus-ignite.php' );

if ( ! function_exists( 'opus_primus_enqueue_scripts' ) ) {
    /**
     * Opus Primus Enqueue Scripts
     * Use to enqueue the theme javascript and custom stylesheet, if it exists
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (constant) OPUS_CSS
     * @uses    (constant) OPUS_JS
     * @uses    is_readable
     * @uses    wp_enqueue_script
     * @uses    wp_enqueue_style
     *
     * @internal    jQuery is enqueued as a dependency
     *
     * @version 1.1
     * @date    March 18, 2013
     * Enqueue jQuery UI Tabs script for Comments
     *
     * @version 1.2
     * @date    March 24, 2013
     * Enqueue ...
     */
    function opus_primus_enqueue_scripts() {
        /** Enqueue Theme Scripts */
        /** Enqueue Opus Primus JavaScripts which will enqueue jQuery as a dependency */
        wp_enqueue_script( 'opus-primus', OPUS_JS . 'opus-primus.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );
        /** Enqueue Opus Primus Full Size Video which will enqueue jQuery as a dependency */
        wp_enqueue_script( 'opus-primus-full-size-video', OPUS_JS . 'opus-primus-full-size-video.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );
        /** Enqueue Opus Primus Comment Tabs which will enqueue jQuery, jQuery UI Core, jQuery UI Widget, and jQuery UI Tabs as dependencies */
        wp_enqueue_script( 'opus-primus-comment-tabs', OPUS_JS . 'opus-primus-comment-tabs.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-tabs' ), wp_get_theme()->get( 'Version' ), 'true' );
        /** Enqueue Opus Primus Header Image Position (if there is a header image) which will enqueue jQuery as a dependency */
        if ( get_header_image() ) {
            wp_enqueue_script( 'opus-primus-header-image-position', OPUS_JS . 'opus-primus-header-image-position.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );
        } /** End if - get header image */

        /** Enqueue Opus Primus Page Featured Image Adjust which will enqueue jQuery as a dependency */
        // wp_enqueue_script( 'opus-primus-page-featured-image-adjust', OPUS_JS . 'opus-primus-page-featured-image-adjust.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );

        /** Enqueue Theme Stylesheets */
        /** Theme Layouts */
        wp_enqueue_style( 'Opus-Primus-Layout', OPUS_CSS . 'opus-primus-layout.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
        /** Main Theme Elements */
        wp_enqueue_style( 'Opus-Primus', OPUS_CSS . 'opus-primus.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
        /** Media Queries and Responsive Elements */
        wp_enqueue_style( 'Opus-Primus-Media-Queries', OPUS_CSS . 'opus-primus-media-queries.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );

        /** Enqueue custom stylesheet after to maintain expected specificity */
        if ( is_readable( OPUS_CSS . 'opus-primus-custom-style.css' ) ) {
            wp_enqueue_style( 'Opus-Primus-Custom-Style', OPUS_CSS . 'opus-primus-custom-style.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
        } /** End if - is readable */
    } /** End function - opus primus enqueue scripts */
} /** End if - function exists - opus primus enqueue scripts */
add_action( 'wp_enqueue_scripts', 'opus_primus_enqueue_scripts' );

/**
 * Opus Primus LESS
 * Add LESS stylesheet and JavaScript
 *
 * @package OpusPrimus
 * @since   0.1
 *
 * @uses    (constant) OPUS_CSS
 * @uses    (constant) OPUS_JS
 * @uses    wp_enqueue_script
 *
 * @todo Comment out LESS implementation?
 */
function opus_primus_LESS() {
    /** Add LESS link - cannot enqueue due to "rel" requirement */
    printf ( '<link rel="stylesheet/less" type="text/css" href="%1$s">', OPUS_CSS . 'style.less' );
    /** Print new line - head section will be easier to read */
    printf ( "\n" );
    /** Add JavaScript to compile LESS on the fly */
    wp_enqueue_script( 'less-1.3.3', OPUS_JS . 'less-1.3.3.min.js', '', '1.3.3' );
} /** End function - opus primus LESS */
add_action( 'wp_enqueue_scripts', 'opus_primus_LESS' );

if ( ! function_exists( 'opus_primus_theme_setup' ) ) {
    /**
     * Opus Primus Theme Setup
     * Add theme support for: post-thumbnails, automatic feed links, TinyMCE
     * editor style, custom background, post formats
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    add_editor_style
     * @uses    add_theme_support: automatic-feed-links
     * @uses    add_theme_support: custom-background
     * @uses    add_theme_support: post-formats
     * @uses    add_theme_support: post-thumbnails
     * @uses    load_theme_textdomain
     * @uses    get_locale
     * @uses    get_template_directory
     * @uses    get_template_directory_uri
     * @uses    register_nav_menus
     */
    function opus_primus_theme_setup() {
        /** This theme uses post thumbnails */
        add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
        /** Add default posts and comments RSS feed links to head */
        add_theme_support( 'automatic-feed-links' );
        /** Add theme support for editor-style */
        add_editor_style();
        /** This theme allows users to set a custom background */
        add_theme_support( 'custom-background', array(
                'default-color' => 'ffffff',
                /** 'default-image' => get_stylesheet_directory_uri() . '/images/background.png' */
            ) );
        /** Add support for ALL post-formats */
        add_theme_support( 'post-formats', array(
            'aside',
            'audio',
            'chat',
            'gallery',
            'image',
            'link',
            'quote',
            'status',
            'video'
        ) );

        /** @var $opus_custom_header_support - holds custom header parameters */
        $opus_custom_header_support = array(
            /**
             * There is no default image in use.
             * If you were to add one, use %s as a placeholder for the theme
             * template directory URI.
             */
            'default-image' => '',
            /** Support flexible heights. */
            'flex-height'   => true,
            /** Support flexible widths */
            'flex-width'    => true,
            /** Do not support text inside the header image. */
            'header-text'   => false,
        );
        /** Add support for Custom Header images */
        add_theme_support( 'custom-header', $opus_custom_header_support );

        /** Add custom menu support (Primary and Secondary) */
        register_nav_menus( array(
            'primary'   => 'Primary (Parent-Theme) Menu',
            'secondary' => 'Secondary Menu (not used in Parent-Theme)',
            'search'    => 'Search Results Menu',
        ) );

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         */
        load_theme_textdomain( 'opusprimus', get_template_directory() . '/languages' );
        $locale = get_locale();
        $locale_file = get_template_directory_uri() . "/languages/$locale.php";
        if ( is_readable( $locale_file ) ) {
            /** @noinspection PhpIncludeInspection */
            require_once( $locale_file );
        } /** End if - is readable */
    } /** End function - opus primus theme setup */
} /** End if - function exists - opus primus theme setup */
add_action( 'after_setup_theme', 'opus_primus_theme_setup' );

/** Set content width to 1000 - see Full Size Video script */
if ( ! isset( $content_width ) ) {
    $content_width = 1000;
} /** End if - not isset - content width */

/** Miscellaneous Functions */
/** Return a space when all other __return_* fail, use this?! */
function opus_primus_return_blank() { return ' '; }