<?php
/**
 * Functions
 * Where the magic happens ...
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

/** Call the initialization file to get things started */
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
     */
    function opus_primus_enqueue_scripts() {
        /** Enqueue scripts */
        /** Enqueue FitVids with jQuery dependency */
        wp_enqueue_script( 'fitVids', OPUS_JS . 'jquery.fitvids.js', array( 'jquery' ), '1.0', 'true' );
        /** Enqueue FitText with jQuery dependency */
        wp_enqueue_script( 'fitText', OPUS_JS . 'jquery.fittext.js', array( 'jquery' ), '1.0', 'true' );
        /** Enqueue Opus Primus JavaScript which will enqueue jQuery as a dependency */
        wp_enqueue_script( 'opus-primus', OPUS_JS . 'opus-primus.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );
        /** Enqueue Theme Stylesheets */
        wp_enqueue_style( 'Opus-Primus-Layout', OPUS_CSS . 'opus-primus-layout.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
        wp_enqueue_style( 'Opus-Primus', OPUS_CSS . 'opus-primus.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
        wp_enqueue_style( 'Opus-Primus-Media-Queries', OPUS_CSS . 'media-queries.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
        // wp_enqueue_style( 'Opus-Primus-Responsive-Layout', OPUS_CSS . 'responsive-layout.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
        /** Enqueue custom stylesheet after to maintain expected specificity */
        if ( is_readable( OPUS_CSS . 'opus-primus-custom-style.css' ) ) {
            wp_enqueue_style( 'Opus-Primus-Custom-Style', OPUS_CSS . 'opus-primus-custom-style.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'opus_primus_enqueue_scripts' );

/**
 * Opus Primus LESS
 * Add LESS stylesheet and javascript
 *
 * @package OpusPrimus
 * @since   0.1
 *
 * @uses    (constant) OPUS_CSS
 * @uses    (constant) OPUS_JS
 * @uses    wp_enqueue_script
 */
function opus_primus_LESS() {
    /** Add LESS link - cannot enqueue due to rel requirement */
    printf ( '<link rel="stylesheet/less" type="text/css" href="%1$s">', OPUS_CSS . 'style.less' );
    /** Print new line - head section will be easier to read */
    printf ( "\n" );
    /** Add JavaScript to compile LESS on the fly */
    wp_enqueue_script( 'less-1.3', OPUS_JS . 'less-1.3.0.min.js', '', '1.3.0' );
}
/** @todo Comment out LESS implementation? */
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
     * @uses    add_theme_support - adds: automatic-feed-links; custom-background; post-formats; post-thumbnails
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
                /* 'default-image' => get_stylesheet_directory_uri() . '/images/background.png' */
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

        /** Add custom menu support (Primary and Secondary) */
        register_nav_menus( array(
            'primary'   => 'Primary Menu',
            'secondary' => 'Secondary Menu',
            'search'    => 'Search Results Menu',
        ) );

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         *
         * @package OpusPrimus
         * @since   0.1
         *
         * @uses    load_theme_textdomain
         * @uses    get_locale
         * @uses    get_template_directory
         * @uses    get_template_directory_uri
         */
        load_theme_textdomain( 'opusprimus', get_template_directory() . '/languages' );
        $locale = get_locale();
        $locale_file = get_template_directory_uri() . "/languages/$locale.php";
        if ( is_readable( $locale_file ) )
            /** @noinspection PhpIncludeInspection */
            require_once( $locale_file );
    }
}
add_action( 'after_setup_theme', 'opus_primus_theme_setup' );

if ( ! function_exists( 'opus_primus_enqueue_comment_reply' ) ) {
    /**
     * Enqueue Comment Reply
     * If the page being viewed is a single post/page; and, comments are open;
     * and, threaded comments are turned on then enqueue the built-in
     * comment-reply
     * script.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    is_singular
     * @uses    comments_open
     * @uses    get_option
     * @uses    wp_enqueue_script
     */
    function opus_primus_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
}
add_action( 'comment_form_before', 'opus_primus_enqueue_comment_reply' );

if ( ! function_exists( 'opus_primus_title' ) ) {
    /**
     * Opus WP Title
     *
     * Utilizes the `wp_title` filter to add text to the default output
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @internal    Originally author by Edward Caissie
     * @link        https://gist.github.com/1410493
     *
     * @param       string $old_title - default title text
     * @param       string $sep - separator character
     * @param       string $sep_location - left|right - separator placement in relationship to title
     *
     * @uses        get_bloginfo - name, description
     * @uses        is_home
     * @uses        is_front_page
     *
     * @return      string - new title text
     */
    function opus_primus_title( $old_title, $sep, $sep_location ) {
        global $page, $paged;
        /** Set initial title text */
        $opus_title_text = $old_title . get_bloginfo( 'name' );
        /** Add wrapping spaces to separator character */
        $sep = ' ' . $sep . ' ';

        /** Add the blog description (tagline) for the home/front page */
        $site_tagline = get_bloginfo( 'description', 'display' );
        if ( $site_tagline && ( is_home() || is_front_page() ) )
            $opus_title_text .= "$sep$site_tagline";

        /** Add a page number if necessary */
        if ( $paged >= 2 || $page >= 2 )
            $opus_title_text .= $sep . sprintf( __( 'Page %s', 'opusprimus' ), max( $paged, $page ) );

        return $opus_title_text;
    }
}
add_filter( 'wp_title', 'opus_primus_title', 10, 3 );

/**
 * Opus Primus Widgets
 * Register Widget areas ... four (4) in the "Sidebar" and three (3) in the
 * "Footer"
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @uses        register_sidebar
 *
 * @internal    Relies on the default widget structure
 * @example     'name' => sprintf( __('Sidebar %d'), $i ),
 * @example     'id' => "sidebar-$i",
 * @example     'description' => '',
 * @example     'class' => '',
 * @example     'before_widget' => '<li id="%1$s" class="widget %2$s">',
 * @example     'after_widget' => "</li>\n",
 * @example     'before_title' => '<h2 class="widgettitle">',
 * @example     'after_title' => "</h2>\n",
 */
function opus_primus_widgets() {
    /** To override Opus Primus Widgets in a Child-Theme:
     * - remove action hook;
     * - add your widget initialization function;
     * - use it in the new action hook.
     */

    register_sidebar( array(
        'name'          => __( 'First Widget Area', 'opusprimus' ),
        'id'            => 'first-widget',
        'description'   => __( 'This widget area is in “Sidebar Area One”. If no widget areas are active, the web site will be one column. If the Third and/or Fourth widget area is active in addition to this one, the web site will display three columns with this area in the left sidebar.', 'opusprimus' ),
    ) );

    register_sidebar( array(
        'name'          => __( 'Second Widget Area', 'opusprimus' ),
        'id'            => 'second-widget',
        'description'   => __( 'This widget area is in “Sidebar Area One”. If no widget areas are active, the web site will be one column. If the Third and/or Fourth widget area is active in addition to this one, the web site will display three columns with this area in the left sidebar.', 'opusprimus' ),
    ) );

    register_sidebar( array(
        'name'          => __( 'Third Widget Area', 'opusprimus' ),
        'id'            => 'third-widget',
        'description'   => __( 'This widget area is in “Sidebar Area Two”. If no widget areas are active, the web site will be one column. If the First and/or Second widget area is active in addition to this one, the web site will display three columns with this area in the right sidebar.', 'opusprimus' ),
    ) );

    register_sidebar( array(
        'name'          => __( 'Fourth Widget Area', 'opusprimus' ),
        'id'            => 'fourth-widget',
        'description'   => __( 'This widget area is in “Sidebar Area Two”. If no widget areas are active, the web site will be one column. If the First and/or Second widget area is active in addition to this one, the web site will display three columns with this area in the right sidebar.', 'opusprimus' ),
    ) );

    register_sidebar( array(
        'name'  => __( 'First Footer Widget Area', 'opusprimus' ),
        'id'    => 'footer-left',
        'description'   => __( 'This widget area appears in the footer on the left side of the theme.', 'opusprimus' ),
    ) );

    register_sidebar( array(
        'name'  => __( 'Second Footer Widget Area', 'opusprimus' ),
        'id'    => 'footer-middle',
        'description'   => __( 'This widget area appears in the footer in the middle of the theme.', 'opusprimus' ),
    ) );

    register_sidebar( array(
        'name'  => __( 'Third Footer Widget Area', 'opusprimus' ),
        'id'    => 'footer-right',
        'description'   => __( 'This widget area appears in the footer on the right side of the theme.', 'opusprimus' ),
    ) );

}
/** Register sidebars by running `opus_primus_widgets` on the `widgets_init` action hook. */
add_action( 'widgets_init', 'opus_primus_widgets' );

/**
 * Temporary value of 1024 set for $content_width for testing purposes
 * @todo Sort out proper width and/or calculation to set appropriate width
 */
if ( ! isset( $content_width ) ) $content_width = 1024;

/** Miscellaneous Functions */
/** Return a space when all other __return_* fail, use this?! */
function opus_primus_return_blank() { return ' '; }