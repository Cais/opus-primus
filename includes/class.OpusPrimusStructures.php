<?php
/**
 * Opus Primus Post Structures
 * Controls for the organization and layout of the site and its content.
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
 * @version 1.0.1
 * @date    February 18, 2013
 * Re-order methods: action and filter calls by request order, then alphabetical
 */

class OpusPrimusStructures {
    /** Construct */
    function __construct() {
        /** Restructure the browser title */
        add_filter( 'wp_title', array( $this, 'browser_title' ), 10, 3 );
        /** Add classes to the body tag */
        add_filter( 'body_class', array( $this, 'body_classes' ) );

        /** Hooks into the 404 page image placeholder action hook */
        add_action( 'opus_404_image', array( $this, 'show_bust_image' ) );
        /** Add Support Comment to footer area */
        add_action( 'wp_footer', array( $this, 'support_comment' ) );

    } /** End function - construct */


    /** ---- Action and Filter Methods ---- */


    /**
     * Browser Title
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
     * @return      string - original title|new title
     */
    function browser_title( $old_title, $sep, $sep_location ) {
        /** Call the page globals for setting page number */
        global $page, $paged;

        /** Check if this is in a feed; if so, return the title as is */
        if ( is_feed() ) {
            return $old_title;
        } /** End if - is feed */

        /** Set initial title text */
        $opus_title_text = $old_title . get_bloginfo( 'name' );
        /** Add wrapping spaces to separator character */
        $sep = ' ' . $sep . ' ';

        /** Add the blog description (tagline) for the home/front page */
        $site_tagline = get_bloginfo( 'description', 'display' );
        if ( $site_tagline && ( is_home() || is_front_page() ) ) {
            $opus_title_text .= "$sep$site_tagline";
        } /** End if - site tagline */

        /** Add a page number if necessary */
        if ( $paged >= 2 || $page >= 2 ) {
            $opus_title_text .= $sep . sprintf( __( 'Page %s', 'opusprimus' ), max( $paged, $page ) );
        } /** End if - paged */

        return apply_filters( 'opus_browser_title', $opus_title_text );

    } /** End function - browser title */


    /**
     * Body Classes
     * A collection of classes added to the HTML body tag for various purposes
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   $classes - existing body classes
     *
     * @uses    $content_width (global)
     * @uses    apply_filters
     * @uses    is_active_sidebar
     *
     * @return  string - specific class based on active columns
     */
    function body_classes( $classes ) {
        /** Theme Layout */
        /** Test if all widget areas are inactive for one-column layout */
        if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $classes[] = 'one-column';
        } /** End if - not is active sidebar */

        /** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $classes[] = 'two-column';
        } elseif( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $classes[] = 'two-column';
        } /** End if - is active sidebar */

        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $classes[] = 'three-column';
        } /** End if - is active sidebar */

        /** Current Date Classes */
        /** Year */
        $current_year = date( 'Y' );
        $classes[] = 'year-' . $current_year;
        $leap_year = date( 'L' );
        if ( '1' == $leap_year ) {
            $classes[] = 'leap-year';
        } /** End if - leap year */

        /** Month */
        $current_month_numeric = date( 'm' );
        $classes[] = 'month-' . $current_month_numeric;
        $current_month_short = date( 'M' );
        $classes[] = 'month-' . strtolower( $current_month_short );
        $current_month_long = date( 'F' );
        $classes[] = 'month-' . strtolower( $current_month_long );

        /** Day */
        $current_day_of_month = date( 'd' );
        $classes[] = 'day-' . $current_day_of_month;
        $current_day_of_week_short = date( 'D' );
        $classes[] = 'day-' . strtolower( $current_day_of_week_short );
        $current_day_of_week_long = date( 'l' );
        $classes[] = 'day-' . strtolower( $current_day_of_week_long );

        /** Time: Hour */
        $current_24_hour = date( 'H' );
        $classes[] = 'hour-' . $current_24_hour;
        $current_12_hour = date( 'ha' );
        $classes[] = 'hour-' . $current_12_hour;

        /** Return the classes for use with the `body_class` filter */
        return apply_filters( 'opus_body_classes', $classes );

    } /** End function - body classes */


    /**
     * Show Bust Image
     * Writes the bust image url to the screen
     *
     * @package OpusPrimus
     * @since   0.1
     */
    function show_bust_image() {
        echo $this->bust_image();
    } /** End function - show bust image */


    /**
     * Support Comment
     * Writes an HTML comment with the theme version meant to be used as a
     * reference for support and assistance.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    wp_get_theme
     */
    function support_comment() {

        $comment = "\n";
        $comment .= '<!-- The following comment is meant to serve as a reference only -->' . "\n";
        $comment .= '<!-- Opus Primus version ' . wp_get_theme()->get( 'Version' ) . ' -->' . "\n";

        echo $comment;

    } /** End function - support comment */


    /** ---- Additional Methods ---- */


    /**
     * Bust Image
     * Returns the url for the image used on the 404 page
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    get_template_directory_uri
     *
     * @return string - URL of image
     */
    function bust_image() {
        $bust_image_location = OPUS_IMAGES . 'broken_beethoven.png';
        return '<img src="' . $bust_image_location  . '" />';
    } /** End function - bust image */


    /**
     * Copyright
     * Returns copyright year(s) as defined by the dates found in published
     * posts. Recognized the site (via its title) as the copyright holder and
     * notes the terms of the copyright. By default the author of the page or
     * the post is specifically noted as the copyright holder in the single
     * view of the page or post.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @internal $output can be filtered via the `opus_copyright` hook
     *
     * @uses    apply_filters
     * @uses    get_bloginfo
     * @uses    get_posts
     * @uses    home_url
     * @uses    post_date_gmt
     *
     * @param   bool $show
     * @param   bool $by_author
     *
     * @return  mixed|null|void
     */
    function copyright( $show = true, $by_author = true ){
        if ( false == $show ) {
            return null;
        } /** End if - show */

        /** @var $output - initialize output variable to empty */
        $output = '';

        /** @var $all_posts - retrieve all published posts in ascending order */
        $all_posts = get_posts( 'post_status=publish&order=ASC' );
        /** @var $first_post - get the first post */
        $first_post = $all_posts[0];
        /** @var $first_post_date - get the date in a standardized format */
        $first_post_date = $first_post->post_date_gmt;

        /** First post year versus current year */
        $first_post_year = substr( $first_post_date, 0, 4 );
        if ( $first_post_year == '' ) {
            $first_post_year = date( 'Y' );
        } /** End if - first post year */

        /** Add to output string */
        if ( $first_post_year == date( 'Y' ) ) {
            /** Only use current year if no published posts in previous years */
            $output .= sprintf( __( 'Copyright &copy; %1$s', 'opusprimus' ), date( 'Y' ) );
        } else {
            $output .= sprintf( __( 'Copyright &copy; %1$s-%2$s', 'opusprimus' ), $first_post_year, date( 'Y' ) );
        } /** End if - first post year */

        /**
         * Append content owner.
         * Default settings will show post author as the copyright holder in
         * single and page views.
         */
        if ( ( is_single() || is_page() ) && $by_author ) {
            global $post;
            $author = get_the_author_meta( 'display_name', $post->post_author );
            $author_url = get_the_author_meta( 'user_url', $post->post_author );
            $output .= ' <a href="' . $author_url . '" title="' . esc_attr( sprintf( __( 'To the web site of %1$s', 'opusprimus' ), $author ) ) . '" rel="author">' . $author .'</a>';
        } else {
            $output .= ' <a href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' . get_bloginfo( 'name', 'display' ) .'</a>';
        } /** End if - is single */

        /** Append usage terms */
        $output .= ' ' . __( 'All Rights Reserved.', 'opusprimus' );

        return apply_filters( 'opus_copyright', $output );

    } /** End function - copyright */


    /**
     * Credits
     * Displays the current theme name and its parent if one exists. Provides
     * links to the Parent-Theme (Opus Primus), to the Child-Theme (if it
     * exists) and to WordPress.org.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    esc_attr__
     * @uses    esc_attr
     * @uses    esc_url
     * @uses    is_child_theme
     * @uses    parent
     * @uses    wp_get_theme
     *
     * @param   bool $show - true|false - default show credits|return null
     *
     * @return  mixed|void - theme credits with links|filtered credits
     */
    function credits( $show = true ) {
        if ( false == $show ) {
            return null;
        } /** End if - show */

        /** @var $active_theme_data - save the theme date for later use */
        $active_theme_data = wp_get_theme();

        if ( is_child_theme() ) {
            $parent_theme_data = $active_theme_data->parent();
            $credits = sprintf(
                '<div class="generator"><span class="credit-phrase">'
                    . __( 'Played on %1$s; tuned to %2$s; and, conducted by %3$s.', 'opusprimus' )
                    . '</span></div>',
                '<span id="parent-theme"><a href="' . esc_url( $parent_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $parent_theme_data->get( 'Description' ) ) . '">' . $parent_theme_data->get( 'Name' ) . '</a></span>',
                '<span id="child-theme"><a href="' . esc_url( $active_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $active_theme_data->get( 'Description' ) ) . '">' . $active_theme_data->get( 'Name' ) . '</a></span>',
                '<span id="wordpress-link"><a href="http://wordpress.org/" title="' . esc_attr__( 'Semantic Personal Publishing Platform', 'opusprimus' ) . '" rel="generator">WordPress</a></span>'
            );
        } else {
            $credits = sprintf(
                '<div class="generator"><span class="credit-phrase">'
                    . __( 'Played on %1$s; and, conducted by %2$s.', 'opusprimus' )
                    . '</span></div>',
                '<span id="parent-theme"><a href="' . esc_url( $active_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $active_theme_data->get( 'Description' ) ) . '">' . $active_theme_data->get( 'Name' ) . '</a></span>',
                '<span id="wordpress-link"><a href="http://wordpress.org/" title="' . esc_attr__( 'Semantic Personal Publishing Platform', 'opusprimus' ) . '" rel="generator">WordPress</a></span>'
            );
        } /** End if - is child theme */

        return apply_filters( 'opus_credits', $credits );

    } /** End function - credits */


    /**
     * Custom Header Image
     * Returns the string to display the custom header image.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    get_header_image
     *
     * @return string
     */
    function custom_header_image() {
        $header_image = '<img class="opus-custom-header" src="' . get_header_image() . '" alt="" />';
        return $header_image;
    } /** End function - custom header image */


    /**
     * Layout - Close
     * Closes appropriate CSS containers depending on the layout structure.
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @uses        $content_width (global)
     * @uses        is_active_sidebar
     * @internal    works in conjunction with layout_open
     *
     * @return      string
     */
    function layout_close() {
        /** @var $layout - initialize variable as empty */
        $layout = '';

        /** Test if all widget areas are inactive for one-column layout */
        if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '</div><!-- .column-mask .full-page -->';
        } /** End if - not is active sidebar */

        /** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '</div><!-- .column-mask .right-sidebar --></div><!--.column-left -->';
        } elseif( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '</div><!-- .column-mask .right-sidebar --></div><!--.column-left -->';
        } /** End if - is active sidebar */

        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '</div><!-- .column-mask .blog-style --></div><!-- .column-middle --></div><!-- .column-left -->';
        } /** End if - is active sidebar */

        return $layout;

    } /** End function - layout close */


    /**
     * Layout - Open
     * Adds appropriate CSS containers depending on the layout structure.
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @uses        $content_width (global)
     * @uses        is_active_sidebar
     *
     * @internal    works in conjunction with layout_close
     * @internal    $content_width is set based on the amount of columns being
     * displayed and a display using the common 1024px x 768px resolution
     *
     * @return      string
     *
     * @todo Review $content_width settings
     */
    function layout_open() {
        global $content_width;

        /** @var $layout - initialize variable as empty */
        $layout = '';

        /** Test if all widget areas are inactive for one-column layout */
        if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '<div class="column-mask full-page">';
            $content_width = 990;
        } /** End if - not is active sidebar */

        /** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '<div class="column-mask right-sidebar"><div class="column-left">';
            $content_width = 700;
        } elseif( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '<div class="column-mask right-sidebar"><div class="column-left">';
            $content_width = 700;
        } /** End if - is active sidebar */

        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '<div class="column-mask blog-style"><div class="column-middle"><div class="column-left">';
            $content_width = 450;
        } /** End if - is active sidebar */

        return $layout;

    } /** End function - layout open */


    /**
     * No Search Results
     * Outputs message if no posts are found by 'the_Loop' query
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_archives (global)
     * @uses    $opus_navigation (global)
     * @uses    apply_filters
     * @uses    archive_cloud
     * @uses    categories_archives
     * @uses    do_action
     * @uses    esc_html
     * @uses    get_search_form
     * @uses    get_search_query
     * @uses    search_menu
     * @uses    top_10_categories_archive
     *
     * @todo Add custom searchform.php
     */
    function no_search_results(){
        /** Add empty hook before no posts results from the_loop query */
        do_action( 'opus_before_search_results' );

        /** No results from the_loop query */ ?>
        <h2 class="post-title">
            <?php
            printf( __( 'Search Results for: %s', 'opus' ),
                apply_filters(
                    'opus_search_results_for_text',
                    '<span class="search-results">' . esc_html( get_search_query() ) . '</span>'
                ) ); ?>
        </h2><!-- .post-title -->

        <?php
        printf( '<p class="no-results">%1$s</p>',
            apply_filters(
                'opus_no_results_text',
                __( 'No results were found, would you like to try another search ...', 'opusprimus' )
            ) );
        get_search_form();

        printf( '<p class="no-results">%1$s</p>',
            apply_filters(
                'opus_no_results_links_text',
                __( '... or try one of the links below.', 'opusprimus' )
            ) );

        /** Get the class variables */
        global $opus_archives, $opus_navigation;

        /** Display a list of categories to choose from */
        $opus_archives->categories_archive( array(
            'orderby'       => 'count',
            'order'         => 'desc',
            'show_count'    => 1,
            'hierarchical'  => 0,
            'title_li'      => sprintf( '<span class="title">%1$s</span>', apply_filters( 'opus_category_archives_title', __( 'Top 10 Categories by Post Count:', 'opusprimus' ) ) ),
            'number'        => 10,
        ) );

        /** Display a list of tags to choose from */
        $opus_archives->archive_cloud( array(
            'taxonomy'  => 'post_tag',
            'orderby'   => 'count',
            'order'     => 'DESC',
            'number'    => 10,
        ) );

        /** Display a list of pages to choose from */
        $opus_navigation->search_menu();

        /** Add empty hook after no posts results from the_loop query */
        do_action( 'opus_after_search_results' );

    } /** End function - no search results */


    /**
     * Replace Spaces
     * Takes a string and replaces the spaces with a single hyphen by default
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $text
     * @param   string $replacement
     *
     * @return  string - class
     */
    function replace_spaces( $text, $replacement='-' ) {
        /** @var $new_text - initial text set to lower case */
        $new_text = esc_attr( strtolower( $text ) );
        /** replace whitespace with a single space */
        $new_text = preg_replace( '/\s\s+/', ' ', $new_text );
        /** replace space with a hyphen to create nice CSS classes */
        $new_text = preg_replace( '/\\040/', $replacement, $new_text );

        /** Return the string with spaces replaced by the replacement variable */
        return $new_text;

    } /** End function - replace spaces */


    /**
     * Show Custom Header Image
     * Writes to the screen the URL return by custom_header_image
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    get_header_image
     */
    function show_custom_header_image() {
        if ( get_header_image() ) {
            echo $this->custom_header_image();
        } /** End if - get header image */
    } /** End function - show custom header image */


    /**
     * the_Loop
     * The most basic structure for the posts loop
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_navigation (global)
     * @uses    get_template_part
     * @uses    get_post_format
     * @uses    have_posts
     * @uses    no_search_results
     * @uses    posts_link
     * @uses    the_post
     */
    function the_loop() {
        /** the_Loop begins */
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();

                /** Add empty hook before get_template_part */
                do_action( 'opus_before_get_template_part' );

                get_template_part( 'opus-primus', get_post_format() );

                /** Add empty hook after get_template_part */
                do_action( 'opus_after_get_template_part' );

            } /** End while - have posts */
        } else {
            $this->no_search_results();
        } /** End if - have posts */

        global $opus_navigation;
        $opus_navigation->posts_link();
        /** the_Loop ends */

    } /** End function - the loop */


    /**
     * the_Loop Archives
     * The most basic structure for the posts loop
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_navigation (global)
     * @uses    get_template_part
     * @uses    get_post_format
     * @uses    have_posts
     * @uses    no_search_results
     * @uses    posts_link
     * @uses    the_post
     */
    function the_loop_archives() {
        /** the_Loop begins */
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();

                /** Add empty hook before get_template_part */
                do_action( 'opus_before_get_template_part' );

                get_template_part( 'opus-primus-archive', get_post_format() );

                /** Add empty hook after get_template_part */
                do_action( 'opus_after_get_template_part' );

            } /** End while - have posts */
        } else {
            $this->no_search_results();
        } /** End if - have posts */

        global $opus_navigation;
        $opus_navigation->posts_link();
        /** the_Loop ends */

    } /** End function - the loop archives */


} /** End Opus Primus Structures class */

/** @var $opus_structures - new instance of class */
$opus_structures = new OpusPrimusStructures();


/** ------------------------------------------------------------------------- */
/** Testing ... testing ... testing ... */
function opus_test() {
    return 'BACON Test!!! PS: This works, too!<br />';
}
function show_opus_test() {
    echo opus_test();
}

/**
 * @todo Review as needed - no harm / no foul to leave in code as references
 *
 * Un-comment the following for testing purposes
 */
// add_action( 'opus_before_modified_post', 'show_opus_test' );
// add_action( 'opus_before_get_template_part', 'show_opus_test' );

// add_filter( 'opus_modified_author_by_text', 'opus_test' );
// add_filter( 'opus_author_coda', 'opus_test' );
// add_filter( 'opus_category_archives_title', 'opus_test' );