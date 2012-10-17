<?php
/**
 * Opus Primus Post Structures
 * Controls for the organization and layout of the site and its content.
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

class OpusPrimusStructures {
    /** Construct */
    function __construct() {
        /** Add classes to the body tag */
        add_filter( 'body_class', array( $this, 'body_classes' ) );
        /** Restructure the browser title */
        add_filter( 'wp_title', array( $this, 'browser_title' ), 10, 3 );
    }

    /**
     * Layout - Open
     * Adds appropriate CSS containers depending on the layout structure.
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @uses        is_active_sidebar
     * @internal    works in conjunction with layout_close
     * @internal    $content_width is set based on the amount of columns being displayed and a display using the common 1024px x 768px resolution
     *
     * @return      string
     *
     * @todo Review $content_width settings
     */
    function layout_open() {
        global $content_width;
        $layout = '';
        /** Test if all widget areas are inactive for one-column layout */
        if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '<div class="column-mask full-page">';
            $content_width = 990;
        }
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
        }
        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '<div class="column-mask blog-style"><div class="column-middle"><div class="column-left">';
            $content_width = 450;
        }

        return $layout;
    }

    /**
     * Layout - Close
     * Closes appropriate CSS containers depending on the layout structure.
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @uses        (global) $content_width
     * @uses        is_active_sidebar
     * @internal    works in conjunction with layout_open
     *
     * @return      string
     */
    function layout_close() {
        $layout = '';
        /** Test if all widget areas are inactive for one-column layout */
        if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '</div><!-- .column-mask .full-page -->';
        }
        /** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '</div><!-- .column-mask .right-sidebar --></div><!--.column-left -->';
        } elseif( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '</div><!-- .column-mask .right-sidebar --></div><!--.column-left -->';
        }
        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '</div><!-- .column-mask .blog-style --></div><!-- .column-middle --></div><!-- .column-left -->';
        }

        return $layout;
    }

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
    }

    /**
     * Body Classes
     * A collection of classes added to the HTML body tag for various purposes
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   $classes - existing body classes
     *
     * @uses    (global) $content_width
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
        }
        /** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $classes[] = 'two-column';
        } elseif( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $classes[] = 'two-column';
        }
        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $classes[] = 'three-column';
        }

        /** Current Date Classes */
        /** Year */
        $current_year = date( 'Y' );
        $classes[] = 'year-' . $current_year;
        $leap_year = date( 'L' );
        if ( '1' == $leap_year ) {
            $classes[] = 'leap-year';
        }
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
        return apply_filters( 'opus_primus_body_classes', $classes );
    }

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
        }

        /** Set initial title text */
        $opus_title_text = $old_title . get_bloginfo( 'name' );
        /** Add wrapping spaces to separator character */
        $sep = ' ' . $sep . ' ';

        /** Add the blog description (tagline) for the home/front page */
        $site_tagline = get_bloginfo( 'description', 'display' );
        if ( $site_tagline && ( is_home() || is_front_page() ) ) {
            $opus_title_text .= "$sep$site_tagline";
        }

        /** Add a page number if necessary */
        if ( $paged >= 2 || $page >= 2 ) {
            $opus_title_text .= $sep . sprintf( __( 'Page %s', 'opusprimus' ), max( $paged, $page ) );
        }

        return apply_filters( 'opus_browser_title', $opus_title_text );
    }

    /**
     * Search Results
     * Outputs message if no posts are found by 'the_Loop' query
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_archive ( global )
     * @uses    do_action
     * @uses    esc_html
     * @uses    get_search_form
     * @uses    get_search_query
     * @uses    top_10_categories_archive
     *
     * @todo Add custom searchform.php
     */
    function search_results(){
        /** Add empty hook before no posts results from the_loop query */
        do_action( 'opus_before_search_results' );

        /** No results from the_loop query */ ?>
        <h2 class="post-title">
            <?php printf( __( 'Search Results for: %s', 'opus' ), '<span class="search-results">' . esc_html( get_search_query() ) . '</span>' ); ?>
        </h2>

        <?php
        printf( '<p class="no-results">%1$s</p>', __( 'No results were found, would you like to try another search ...', 'opusprimus' ) );
        get_search_form();

        printf( '<p class="no-results">%1$s</p>', __( '... or try one of the links below.', 'opusprimus' ) );

        /** Get the class variables */
        global $opus_archive, $opus_nav;
        /** Display a list of categories to choose from */
        $opus_archive->categories_archive( array(
            'orderby'       => 'count',
            'order'         => 'desc',
            'show_count'    => 1,
            'hierarchical'  => 0,
            'title_li'      => '<span class="title">' . __( 'Top 10 Categories by Post Count:', 'opusprimus' ) . '</span>',
            'number'        => 10,
        ) );
        /** Display a list of tags to choose from */
        $opus_archive->archive_cloud( array(
            'taxonomy'  => 'post_tag',
            'orderby'   => 'count',
            'order'     => 'DESC',
            'number'    => 10,
        ) );
        /** Display a list of pages to choose from */
        $opus_nav->search_menu();

        /** Add empty hook after no posts results from the_loop query */
        do_action( 'opus_after_search_results' );

    }

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
        }
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
        }

        return apply_filters( 'opus_primus_credits', $credits );

    }

    /**
     * Copyright
     * Returns copyright year(s) as defined by the dates found in published
     * posts. Recognized the site (via its title) as the copyright holder and
     * notes the terms of the copyright.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @internal $output can be filtered via the `opus_primus_copyright` hook
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
        }

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
        }

        /** Add to output string */
        if ( $first_post_year == date( 'Y' ) ) {
            /** Only use current year if no published posts in previous years */
            $output .= sprintf( __( 'Copyright &copy; %1$s', 'opusprimus' ), date( 'Y' ) );
        } else {
            $output .= sprintf( __( 'Copyright &copy; %1$s-%2$s', 'opusprimus' ), $first_post_year, date( 'Y' ) );
        }

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
        }
        /** Append usage terms */
        $output .= ' ' . __( 'All Rights Reserved.', 'opusprimus' );

        return apply_filters( 'opus_primus_copyright', $output );

    }

}
$opus_structure = new OpusPrimusStructures();

/** Testing ... testing ... testing ... */
function opus_test() {
    return 'BACON Test!!! PS: This works, too!<br />';
}
// add_action( 'opus_before_modified_post', 'opus_test' );
// add_filter( 'opus_modified_author_by_text', 'opus_test' );
// add_filter( 'opus_author_coda', 'opus_test' );