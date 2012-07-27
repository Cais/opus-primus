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
        wp_enqueue_script( 'opus-primus', OPUS_JS . 'opus-primus.js', array( 'jquery' ), '0.1', 'true' );
        /** Enqueue Theme Stylesheets */
        wp_enqueue_style( 'Opus-Primus-Layout', OPUS_CSS . 'opus-primus-layout.css', array(), '0.1', 'screen' );
        wp_enqueue_style( 'Opus-Primus', OPUS_CSS . 'opus-primus.css', array(), '0.1', 'screen' );
        /** Enqueue custom stylesheet after to maintain expected specificity */
        if ( is_readable( OPUS_CSS . 'opus-primus-custom-style.css' ) ) {
            wp_enqueue_style( 'Opus-Primus-Custom-Style', OPUS_CSS . 'opus-primus-custom-style.css', array(), '0.1', 'screen' );
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

        /**
         * Opus Primus Primary Menu
         * Primary navigation menu
         *
         * @package OpusPrimus
         * @since   0.1
         *
         * @param   string|array $primary_menu_args
         *
         * @uses    do_action
         * @uses    primary_menu
         * @uses    wp_nav_menu
         */
        function opus_primus_primary_menu( $primary_menu_args = '' ) {
            /** Add empty hook before the primary menu */
            do_action( 'opus_before_primary_menu' );

            /** Primary Menu */
            $defaults = array(
                'theme_location'    => 'primary',
                'menu_class'        => 'nav-menu primary',
                'fallback_cb'       => 'opus_primus_list_pages',
            );
            $primary_menu_args = wp_parse_args( (array) $defaults, $primary_menu_args );
            wp_nav_menu( $primary_menu_args );

            /** Add empty hook after the primary menu */
            do_action( 'opus_after_primary_menu' );
        }

        /**
         * Opus Primus Secondary Menu
         * Secondary navigation menu
         *
         * @package OpusPrimus
         * @since   0.1
         *
         * @param   string|array $secondary_menu_args
         *
         * @uses    do_action
         * @uses    primary_menu
         * @uses    wp_nav_menu
         */
        function opus_primus_secondary_menu( $secondary_menu_args = '' ) {
            /** Add empty hook before the secondary menu */
            do_action( 'opus_before_secondary_menu' );

            /** Primary Menu */
            $defaults = array(
                'theme_location'    => 'primary',
                'menu_class'        => 'nav-menu primary',
                'fallback_cb'       => 'opus_primus_list_pages',
            );
            $secondary_menu_args = wp_parse_args( (array) $defaults, $secondary_menu_args );
            wp_nav_menu( $secondary_menu_args );

            /** Add empty hook after the secondary menu */
            do_action( 'opus_after_secondary_menu' );
        }

        /**
         * Opus Primus List Pages
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
         * @uses    wp_parse_args
         */
        function opus_primus_list_pages( $page_menu_args ) {
            $defaults = array(
                'title_li'  => '',
            );
            $page_menu_args = wp_parse_args( (array) $defaults, $page_menu_args );
            echo '<ul class="nav-menu">';
            wp_list_pages( $page_menu_args );
            echo '</ul>';
        }

        /**
         * Opus Primus Search Menu
         * Search results navigation menu
         *
         * @package OpusPrimus
         * @since   0.1
         *
         * @param   string|array $search_menu_args
         *
         * @uses    do_action
         * @uses    search_menu
         * @uses    wp_nav_menu
         */
        function opus_primus_search_menu( $search_menu_args = '' ) {
            /** Add empty hook before the search menu */
            do_action( 'opus_before_search_menu' );

            /** Search Menu */
            $defaults = array(
                'theme_location'    => 'search',
                'container'         => 'li',
                'menu_class'        => 'nav search',
                'fallback_cb'       => 'opus_primus_search_page_menu',
            );
            $search_menu_args = wp_parse_args( (array) $defaults, $search_menu_args );
            printf( '<ul class="featured search pages"><li><span class="title">%1$s</span>', __( 'Featured Pages:', 'opusprimus' ) );
            wp_nav_menu( $search_menu_args );
            echo '</li></ul>';

            /** Add empty hook after the search menu */
            do_action( 'opus_after_search_menu' );
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
         * @uses    wp_parse_args
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

if ( ! function_exists( 'opus_primus_body_classes' ) ) {
    /**
     * Opus Primus Body Classes
     * A collection of classes added to the HTML body tag for various purposes
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   $classes - existing body classes
     *
     * @uses    (global) $content_width
     * @uses    is_active_sidebar
     * @internal conscripts conditional to set $content_width based on layout
     *
     * @return  array - classes to be added to the `body_class` output
     *
     * @todo Look for better way to set / reset $content_width
     */
    function opus_primus_body_classes( $classes ) {
        global $content_width;
        /** Sidebar Layouts */
        /** Test if all widget areas are inactive for one-column layout */
        if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $classes[] = 'one-column';
        }
        /** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $classes[] = 'two-column';
            $content_width = 960;
        } elseif( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $classes[] = 'two-column';
            $content_width = 960;
        }
        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $classes[] = 'three-column';
            $content_width = 720;
        }
        /** End: Sidebar Layouts */

        /** Return the classes for use with the `body_class` filter */
        return apply_filters( 'opus_primus_body_classes', $classes );
    }
}
add_filter( 'body_class', 'opus_primus_body_classes' );

if ( ! function_exists( 'opus_enqueue_comment_reply' ) ) {
    /**
     * Enqueue Comment Reply Script
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
    function opus_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
}
add_action( 'comment_form_before', 'opus_enqueue_comment_reply' );

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
 * Register Widget areas.
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