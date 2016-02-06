<?php

/**
 * Opus Primus Post Structures
 *
 * Controls for the organization and layout of the site and its content.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2016, Opus Primus
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
 * @version     1.2.3
 * @date        February 2, 2014
 * Added more tests
 *
 * @version     1.4
 * @date        March 31, 2015
 * Change `OpusPrimusStructures` to a singleton style class
 */
class OpusPrimusStructures {

	private static $instance = null;

	/**
	 * Create Instance
	 *
	 * Creates a single instance of the class
	 *
	 * @package OpusPrimus
	 * @since   1.4
	 * @date    March 31, 2015
	 *
	 * @return null|OpusPrimusStructures
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}


	/**
	 * Construct
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @uses       add_action
	 * @uses       add_filter
	 *
	 * @version    1.3
	 * @date       November 13, 2014
	 * Moved `support_comment` method to `functions.php` to eliminate duplicate output, commented out action hook
	 */
	function __construct() {

		/** Restructure the browser title */
		add_filter( 'wp_title', array( $this, 'browser_title' ), 10, 3 );

		/** Add classes to the body tag */
		add_filter( 'body_class', array( $this, 'body_classes' ) );

		/** Hooks into the 404 page image placeholder action hook */
		add_action( 'opus_404_image', array( $this, 'show_bust_image' ) );

		/** Add Support Comment to footer area */
		add_action( 'wp_footer', array( $this, 'support_comment' ) );

	}


	/**
	 * Browser Title
	 *
	 * Utilizes the `wp_title` filter to add text to the default output
	 *
	 * @package     OpusPrimus
	 * @since       0.1
	 *
	 * @internal    Originally author by Edward Caissie
	 * @link        https://gist.github.com/1410493
	 *
	 * @param   string $old_title - default title text
	 * @param   string $sep       - separator character
	 *
	 * @uses        (GLOBAL) $page
	 * @uses        (GLOBAL) $paged
	 * @uses        apply_filters
	 * @uses        get_bloginfo - name, description
	 * @uses        is_home
	 * @uses        is_feed
	 * @uses        is_front_page
	 *
	 * @return  string - original title|new title
	 *
	 * @version     1.2.3
	 * @date        November 26, 2013
	 * Removed $sep_location parameter as it was not used
	 */
	function browser_title( $old_title, $sep ) {

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
			$opus_title_text .= $sep . sprintf( __( 'Page %s', 'opus-primus' ), max( $paged, $page ) );
		}

		return apply_filters( 'opus_browser_title', $opus_title_text );

	}


	/**
	 * Body Classes
	 *
	 * A collection of classes added to the HTML body tag for various purposes
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   array $classes - existing body classes
	 *
	 * @uses    apply_filters
	 * @uses    is_active_sidebar
	 * @uses    is_child_theme
	 *
	 * @return  string - specific class based on active columns
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Added sanity conditional check to eliminate potential duplicate classes
	 *
	 * @version 1.3
	 * @date    September 20, 2014
	 * Added Child-Theme "slug" for easier customizations
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
		            && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) )
		) {
			$classes[] = 'two-column';
		} elseif ( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
		           && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
		                  && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) )
		) {
			$classes[] = 'two-column';
		}

		/** Test if at least one widget area in each sidebar area is active for a three-column layout */
		if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
			$classes[] = 'three-column';
		}

		/**
		 * Sanity check to reduce duplicate body classes - use BNS Body Classes
		 * if it exists as there are a lot more specific classes added by the
		 * plugin.
		 */
		if ( ! class_exists( 'BNS_Body_Classes' ) ) {

			/** Current Date Classes */
			/** Year */
			$current_year = date( 'Y' );
			$classes[]    = 'year-' . $current_year;
			$leap_year    = date( 'L' );
			if ( '1' == $leap_year ) {
				$classes[] = 'leap-year';
			}

			/** Month */
			$current_month_numeric = date( 'm' );
			$classes[]             = 'month-' . $current_month_numeric;
			$current_month_short   = date( 'M' );
			$classes[]             = 'month-' . strtolower( $current_month_short );
			$current_month_long    = date( 'F' );
			$classes[]             = 'month-' . strtolower( $current_month_long );

			/** Day */
			$current_day_of_month      = date( 'd' );
			$classes[]                 = 'day-' . $current_day_of_month;
			$current_day_of_week_short = date( 'D' );
			$classes[]                 = 'day-' . strtolower( $current_day_of_week_short );
			$current_day_of_week_long  = date( 'l' );
			$classes[]                 = 'day-' . strtolower( $current_day_of_week_long );

			/** Time: Hour */
			$current_24_hour = date( 'H' );
			$classes[]       = 'hour-' . $current_24_hour;
			$current_12_hour = date( 'ha' );
			$classes[]       = 'hour-' . $current_12_hour;

		}

		/** Add Child-Theme "slug" for easier customizations */
		if ( is_child_theme() ) {
			$classes[] = sanitize_html_class( get_option( 'stylesheet' ) );
		}

		/** Return the classes for use with the `body_class` filter */

		return apply_filters( 'opus_body_classes', $classes );

	}


	/**
	 * Support Comment
	 *
	 * Writes an HTML comment with the theme version meant to be used as a
	 * reference for support and assistance.
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    wp_get_theme
	 *
	 * @version 1.3
	 * @date    November 13, 2014
	 * Moved `support_comment` method to `functions.php` to eliminate duplicate output
	 */
	function support_comment() {

		$comment = "\n";
		$comment .= '<!-- The following comment is meant to serve as a reference only -->' . "\n";
		if ( is_child_theme() ) {
			$comment .= '<!-- Opus Primus version ' . wp_get_theme()->parent()->get( 'Version' ) . ' | ';
			$comment .= 'Child-Theme: ' . wp_get_theme() . ' version ' . wp_get_theme()->get( 'Version' ) . ' -->' . "\n";
		} else {
			$comment .= '<!-- ' . wp_get_theme() . ' version ' . wp_get_theme()->get( 'Version' ) . ' -->' . "\n";
		}

		echo $comment;

	}


	/**
	 * Bust Image
	 *
	 * Returns the url for the image used on the 404 page
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @uses       OpusPrimusRouter::path_uri
	 *
	 * @return string - URL of image
	 *
	 * @version    1.3
	 * Replace CONSTANT with OpusPrimusRouter method
	 */
	function bust_image() {

		/** Create OpusPrimusRouter class object */
		$opus_router = OpusPrimusRouter::create_instance();

		$bust_image_location = $opus_router->path_uri( 'images' ) . 'broken_beethoven.png';

		return '<img src="' . $bust_image_location . '" />';

	}


	/**
	 * Show Bust Image
	 *
	 * Writes the bust image url to the screen
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    OpusPrimusStructures::bust_image
	 */
	function show_bust_image() {
		echo $this->bust_image();
	}


	/**
	 * Copyright
	 *
	 * Returns copyright year(s) as defined by the dates found in published
	 * posts. Recognized the site (via its title) as the copyright holder and
	 * notes the terms of the copyright. By default the author of the page or
	 * the post is specifically noted as the copyright holder in the single
	 * view of the page or post.
	 *
	 * @package     OpusPrimus
	 * @since       0.1
	 *
	 * @uses        __
	 * @uses        apply_filters
	 * @uses        esc_attr
	 * @uses        get_bloginfo
	 * @uses        get_posts
	 * @uses        get_transient
	 * @uses        home_url
	 * @uses        post_date_gmt
	 * @uses        set_transient
	 *
	 * @param   bool $show
	 * @param   bool $by_author
	 * @param    int $transient_refresh
	 *
	 * @return  mixed|null|void
	 *
	 * @version     1.2.4
	 * @date        May 18, 2014
	 * Used transients to improve performance impact of the method
	 *
	 * @version     1.2.5
	 * @date        June 15, 2014
	 * Use single view published date for first year of copyright
	 */
	function copyright( $show = true, $by_author = true, $transient_refresh = 2592000 ) {

		/** If we are not going to show the copyright jump out now */
		if ( false == $show ) {
			return null;
		}

		/** @var $output - initialize output variable to empty */
		$output = '';

		/** Take some of the load off with a transient of the first post */
		if ( ! get_transient( 'opus_primus_copyright_first_post' ) ) {

			/** @var $all_posts - retrieve all published posts in ascending order */
			$all_posts = get_posts( 'post_status=publish&order=ASC' );
			/** @var $first_post - get the first post */
			$first_post = $all_posts[0];

			/** Set the transient (default: one month) */
			set_transient( 'opus_primus_copyright_first_post', $first_post, $transient_refresh );
		}

		/** @var $first_post_date - get the date in a standardized format */
		$first_post_date = get_transient( 'opus_primus_copyright_first_post' )->post_date_gmt;

		/** First post year versus current year */
		$first_post_year = substr( $first_post_date, 0, 4 );
		if ( $first_post_year == '' ) {
			$first_post_year = date( 'Y' );
		}

		/**
		 * If this is a single view then the copyright year should start at its
		 * published date rather than the site's first publish date
		 */
		if ( ( is_single() || is_page() ) && $by_author ) {
			global $post;
			$first_post_year = substr( $post->post_date, 0, 4 );
		}

		/** Add to output string */
		if ( $first_post_year == date( 'Y' ) ) {
			/** Only use current year if no published posts in previous years */
			$output .= sprintf( __( 'Copyright &copy; %1$s', 'opus-primus' ), date( 'Y' ) );
		} else {
			$output .= sprintf( __( 'Copyright &copy; %1$s-%2$s', 'opus-primus' ), $first_post_year, date( 'Y' ) );
		}

		/**
		 * Append content owner.
		 * Default settings will show post author as the copyright holder in
		 * single and page views.
		 */
		if ( ( is_single() || is_page() ) && $by_author ) {

			global $post;
			$author     = get_the_author_meta( 'display_name', $post->post_author );
			$author_url = get_the_author_meta( 'user_url', $post->post_author );
			$output .= ' <a href="' . $author_url . '" title="' . esc_attr( sprintf( __( 'To the web site of %1$s', 'opus-primus' ), $author ) ) . '" rel="author">' . $author . '</a>';

		} else {

			$output .= ' <a href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' . get_bloginfo( 'name', 'display' ) . '</a>';

		}

		/** Append usage terms */
		$output .= ' ' . __( 'All Rights Reserved.', 'opus-primus' );

		return apply_filters( 'opus_copyright', $output );

	}


	/**
	 * Credits
	 *
	 * Displays the current theme name and its parent if one exists. Provides
	 * links to the Parent-Theme (Opus Primus), to the Child-Theme (if it
	 * exists) and to WordPress.org.
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    __
	 * @uses    apply_filters
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

		/** @var $active_theme_data - save the theme date for later use */
		$active_theme_data = wp_get_theme();

		if ( is_child_theme() ) {

			$parent_theme_data = $active_theme_data->parent();
			$credits           = sprintf(
				'<div class="generator"><span class="credit-phrase">'
				. __( 'Played on %1$s; tuned to %2$s; and, conducted by %3$s.', 'opus-primus' )
				. '</span></div>',
				'<span id="parent-theme"><a href="' . esc_url( $parent_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $parent_theme_data->get( 'Description' ) ) . '">' . $parent_theme_data->get( 'Name' ) . '</a></span>',
				'<span id="child-theme"><a href="' . esc_url( $active_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $active_theme_data->get( 'Description' ) ) . '">' . $active_theme_data->get( 'Name' ) . '</a></span>',
				'<span id="wordpress-link"><a href="http://wordpress.org/" title="' . esc_attr__( 'Semantic Personal Publishing Platform', 'opus-primus' ) . '" rel="generator">WordPress</a></span>'
			);

		} else {

			$credits = sprintf(
				'<div class="generator"><span class="credit-phrase">'
				. __( 'Played on %1$s; and, conducted by %2$s.', 'opus-primus' )
				. '</span></div>',
				'<span id="parent-theme"><a href="' . esc_url( $active_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $active_theme_data->get( 'Description' ) ) . '">' . $active_theme_data->get( 'Name' ) . '</a></span>',
				'<span id="wordpress-link"><a href="http://wordpress.org/" title="' . esc_attr__( 'Semantic Personal Publishing Platform', 'opus-primus' ) . '" rel="generator">WordPress</a></span>'
			);

		}

		return apply_filters( 'opus_credits', $credits );

	}


	/**
	 * Layout - Close
	 *
	 * Closes appropriate CSS containers depending on the layout structure.
	 *
	 * @package              OpusPrimus
	 * @since                0.1
	 *
	 * @uses                 is_active_sidebar
	 *
	 * @return      string
	 */
	function layout_close() {

		/** @var $layout - initialize variable as empty */
		$layout = '';

		/** Test if all widget areas are inactive for one-column layout */
		if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
			$layout = '</div><!-- .column-mask .full-page -->';
		}

		/** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
		if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
		     && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
		            && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) )
		) {
			$layout = '</div><!-- .column-mask .right-sidebar --></div><!--.column-left -->';
		} elseif ( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
		           && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
		                  && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) )
		) {
			$layout = '</div><!-- .column-mask .right-sidebar --></div><!--.column-left -->';
		}

		/** Test if at least one widget area in each sidebar area is active for a three-column layout */
		if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
			$layout = '</div><!-- .column-mask .blog-style --></div><!-- .column-middle --></div><!-- .column-left -->';
		}

		return $layout;

	}


	/**
	 * Layout - Open
	 *
	 * Adds appropriate CSS containers depending on the layout structure.
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @uses     is_active_sidebar
	 *
	 * @return  string
	 *
	 * @version  1.1.1
	 * @date     March 23, 2013
	 * Remove $content_width set values - see 'functions.php' for $content_width
	 */
	function layout_open() {

		/** @var $layout - initialize variable as empty */
		$layout = '';

		/** Test if all widget areas are inactive for one-column layout */
		if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
			$layout = '<div class="column-mask full-page">';
		}

		/** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
		if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
		     && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
		            && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) )
		) {
			$layout = '<div class="column-mask right-sidebar"><div class="column-left">';
		} elseif ( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
		           && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
		                  && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) )
		) {
			$layout = '<div class="column-mask right-sidebar"><div class="column-left">';
		}

		/** Test if at least one widget area in each sidebar area is active for a three-column layout */
		if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
			$layout = '<div class="column-mask blog-style"><div class="column-middle"><div class="column-left">';
		}

		return $layout;

	}


	/**
	 * No Search Results
	 *
	 * Outputs message if no posts are found by 'the_Loop' query
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    OpusPrimusArchives::archive_cloud
	 * @uses    OpusPrimusArchives::create_instance
	 * @uses    OpusPrimusArchives::categories_archives
	 * @uses    OpusPrimusNavigation::search_menu
	 * @uses    __
	 * @uses    apply_filters
	 * @uses    do_action
	 * @uses    esc_html
	 * @uses    get_search_form
	 * @uses    get_search_query
	 */
	function no_search_results() {

		/** Add empty hook before no posts results from the_loop query */
		do_action( 'opus_search_results_before' );

		/** No results from the_loop query */
		?>
		<h2 class="post-title">
			<?php
			printf(
				__( 'Search Results for: %s', 'opus-primus' ),
				apply_filters(
					'opus_search_results_for_text',
					'<span class="search-results">' . esc_html( get_search_query() ) . '</span>'
				)
			); ?>
		</h2><!-- .post-title -->

		<?php
		printf(
			'<p class="no-results">%1$s</p>',
			apply_filters(
				'opus_no_results_text',
				__( 'No results were found, would you like to try another search ...', 'opus-primus' )
			)
		);
		get_search_form();

		printf(
			'<p class="no-results">%1$s</p>',
			apply_filters(
				'opus_no_results_links_text',
				__( '... or try one of the links below.', 'opus-primus' )
			)
		);

		/** Get the class variables */
		$opus_archives   = OpusPrimusArchives::create_instance();
		$opus_navigation = OpusPrimusNavigation::create_instance();

		/** Display a list of categories to choose from */
		/** @noinspection PhpInternalEntityUsedInspection */
		$opus_archives->categories_archive(
			array(
				'orderby'      => 'count',
				'order'        => 'desc',
				'show_count'   => 1,
				'hierarchical' => 0,
				'title_li'     => sprintf( '<span class="title">%1$s</span>', apply_filters( 'opus_category_archives_title', __( 'Top 10 Categories by Post Count:', 'opus-primus' ) ) ),
				'number'       => 10,
			)
		);

		/** Display a list of tags to choose from */
		/** @noinspection PhpInternalEntityUsedInspection */
		$opus_archives->archive_cloud(
			array(
				'taxonomy' => 'post_tag',
				'orderby'  => 'count',
				'order'    => 'DESC',
				'number'   => 10,
			)
		);

		/** Display a list of pages to choose from */
		$opus_navigation->search_menu();

		/** Add empty hook after no posts results from the_loop query */
		do_action( 'opus_search_results_after' );

	}


	/**
	 * Replace Spaces
	 *
	 * Takes a string and replaces the spaces with a single hyphen by default
	 *
	 * @package       OpusPrimus
	 * @since         0.1
	 *
	 * @param   string $text
	 * @param   string $replacement
	 *
	 * @return  string - class
	 *
	 * @deprecated    1.2.5
	 * @date          July 24, 2014
	 * Replaced all instances with `sanitize_html_class`
	 */
	function replace_spaces( $text, $replacement = '-' ) {

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
	 * the_Loop
	 * The most basic structure for the posts loop
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    OpusPrimusStructures::no_search_results
	 * @uses    OpusPrimusNavigation::post_link
	 * @uses    OpusPrimusNavigation::pagination_wrapped
	 * @uses    do_action
	 * @uses    get_template_part
	 * @uses    get_post_format
	 * @uses    have_posts
	 * @uses    the_post
	 *
	 * @version 1.2
	 * @date    July 20, 2013
	 * Added post to post navigation in single view
	 */
	function the_loop() {

		$opus_navigation = OpusPrimusNavigation::create_instance();

		/** the_Loop begins */
		if ( have_posts() ) {

			while ( have_posts() ) {

				the_post();

				/** Add empty hook before get_template_part */
				do_action( 'opus_get_template_part_before' );

				get_template_part( 'opus-primus', get_post_format() );

				/** Add empty hook after get_template_part */
				do_action( 'opus_get_template_part_after' );

				/** In single view add post to post navigation */
				if ( is_single() ) {
					$opus_navigation->post_link();
				}

			}

		} else {

			$this->no_search_results();

		}

		/** Display links to previous and next pages */
		$opus_navigation->pagination_wrapped();
		/** the_Loop ends */

	}


	/**
	 * the_Loop Archives
	 *
	 * The most basic structure for the posts loop
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @uses       OpusPrimusNavigation::pagination_wrapped
	 * @uses       OpusPrimusStructures::no_search_results
	 * @uses       do_action
	 * @uses       get_template_part
	 * @uses       get_post_format
	 * @uses       have_posts
	 * @uses       the_post
	 *
	 * @version    1.2.5
	 * @date       June 22, 2014
	 * Changed navigation method from `posts_link` to `pagination_wrapped`
	 */
	function the_loop_archives() {

		/** the_Loop begins */
		if ( have_posts() ) {

			while ( have_posts() ) {

				the_post();

				/** Add empty hook before get_template_part */
				do_action( 'opus_get_template_part_before' );

				get_template_part( 'opus-primus-archive', get_post_format() );

				/** Add empty hook after get_template_part */
				do_action( 'opus_get_template_part_after' );

			}

		} else {

			$this->no_search_results();

		}

		$opus_navigation = OpusPrimusNavigation::create_instance();
		$opus_navigation->pagination_wrapped();
		/** the_Loop ends */

	}


	/**
	 * the_Loop Wrapped
	 *
	 * Wraps the_Loop, its wrapping action hooks, and class into a tidy method
	 *
	 * @package OpusPrimus
	 * @since   1.0.1
	 *
	 * @uses    OpusPrimusStructures::the_loop
	 * @uses    do_action
	 * @uses    dynamic_sidebar
	 * @uses    is_active_sidebar
	 */
	function the_loop_wrapped() {
		/** Add empty action before the_Loop */
		do_action( 'opus_the_loop_before' ); ?>

		<div class="the-loop">

			<?php
			/** Add before loop sidebar */
			if ( is_active_sidebar( 'before-loop' ) ) {
				dynamic_sidebar( 'before-loop' );
			}

			/** the_Loop structure in its most basic form */
			$this->the_loop();

			/** Add after loop sidebar */
			if ( is_active_sidebar( 'after-loop' ) ) {
				dynamic_sidebar( 'after-loop' );
			} ?>

		</div><!-- #the-loop -->

		<?php
		/** Add empty action after the_Loop */
		do_action( 'opus_the_loop_after' );

	}


	/**
	 * the_Loop Archives Wrapped
	 *
	 * Wraps the_Loop (archives), its wrapping action hooks, and class into a
	 * tidy method
	 *
	 * @package OpusPrimus
	 * @since   1.0.1
	 *
	 * @uses    OpusPrimusStructures::the_loop_archives
	 * @uses    do_action
	 * @uses    dynamic_sidebar
	 * @uses    is_active_sidebar
	 */
	function the_loop_archives_wrapped() {

		/** Add empty action before the_Loop */
		do_action( 'opus_the_loop_before' ); ?>

		<div class="the-loop">

			<?php
			/** Add before loop sidebar */
			if ( is_active_sidebar( 'before-loop' ) ) {
				dynamic_sidebar( 'before-loop' );
			}

			/** the_Loop structure in its most basic form */
			$this->the_loop_archives();

			/** Add after loop sidebar */
			if ( is_active_sidebar( 'after-loop' ) ) {
				dynamic_sidebar( 'after-loop' );
			} ?>

		</div><!-- #the-loop -->

		<?php
		/** Add empty action after the_Loop */
		do_action( 'opus_the_loop_after' );

	}


}

/** ------------------------------------------------------------------------- */
/** Testing ... testing ... testing ... */
function opus_test() {
	return 'BACON Test!!! PS: This works, too!';
}

function opus_number() {
	return 10;
}

function show_opus_test() {
	echo opus_test();
}

/** Un-comment the following for testing purposes */
// add_action( 'opus_before_modified_post', 'show_opus_test' );
// add_action( 'opus_before_get_template_part', 'show_opus_test' );

// add_filter( 'opus_post_byline_date', 'opus_test' );
// add_filter( 'opus_author_coda', 'opus_test' );
// add_filter( 'opus_author_description_excerpt_link', 'opus_test' );
// add_filter( 'opus_featured_image_before', 'show_opus_test' );
// add_filter( 'opus_featured_image_after', 'show_opus_test' );
// add_filter( 'opus_author_description_excerpt_length', 'opus_number' );