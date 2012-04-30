<?php
/**
 * Functions
 * Where the magic happens ...
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @link        http://opusprimus.com
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
 */

/** Call the initialization file to get things started */
/** @noinspection PhpIncludeInspection - IDE commentary can be ignored */
require_once( get_template_directory() . '/includes/opus-ignite.php' );

if ( ! function_exists( 'opus_primus_theme_setup' ) ) {
    /**
     * Opus Primus Theme Setup
     * Add theme support for: post-thumbnails, automatic feed links, TinyMCE
     * editor style, custom background, post formats
     *
     * @package OpusPrimus
     * @since   0.1
     */
    function opus_primus_theme_setup() {
        /** This theme uses post thumbnails */
        add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
        /** Add default posts and comments RSS feed links to head */
        add_theme_support( 'automatic-feed-links' );
        /** Add theme support for editor-style */
        add_editor_style();
        /** This theme allows users to set a custom background */
        add_theme_support( 'custom-background' /*, array(
                'default-color' => '',
                'default-image' => get_stylesheet_directory_uri() . '/images/background.png'
            )*/ );
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
        ) );

    }
}
add_action( 'after_setup_theme', 'opus_primus_theme_setup' );

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
     * @return  void
     */
    function opus_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'opus_enqueue_comment_reply' );


if ( ! function_exists( 'opus_wp_title' ) ) {
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
     * @return      string - new title text
     */
    function opus_wp_title( $old_title, $sep, $sep_location ) {
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
add_filter( 'wp_title', 'opus_wp_title', 10, 3 );