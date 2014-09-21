<?php

/**
 * Opus Primus Breadcrumbs
 * Creates and display a breadcrumb trail for pages
 *
 * @package     OpusPrimus
 * @since       1.0.4
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2013-2014, Opus Primus
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
class OpusPrimusBreadcrumbs {

	function __construct() {
	}

	/**
	 * Breadcrumbs
	 * Collect the post ID of each post in the lineage from the top level
	 * "parent" to the current "child" for single view templates
	 *
	 * @package     OpusPrimus
	 * @subpackage  Structures
	 * @since       1.0.3-alpha
	 *
	 * @uses        is_single
	 * @uses        is_singular
	 * @uses        get_post
	 *
	 * @version     1.0.4
	 * @date        March 1, 2013
	 * Added 'Breadcrumbs' for pages completed
	 *
	 * @internal    Considered new feature for release at version 1.1.0
	 */
	function breadcrumbs() {

		/** Sanity check - are we on a single view template but not single */
		if ( is_singular() && ! is_single() ) {

			/** @var $breadcrumb - empty array to hold the breadcrumb */
			$breadcrumb = array();
			/** @var $x - array index */
			$x = 0;

			/** Get the current post (from outside the_Loop) */
			global $post;

			/** Set initial array element as current post ID */
			$breadcrumb[ $x ] = $post->ID;

			/** Walk back to the parent getting each post ID  */
			while ( get_post( $breadcrumb[ $x ] )->post_parent !== 0 ) {
				/** @var $parent_post - current index parent post ID */
				$parent_post = get_post( $breadcrumb[ $x ] )->post_parent;
				/** Add ID to breadcrumb array */
				$breadcrumb[] = $parent_post;
				/** Increment the index to check the next post */
				$x ++;
			}

			/** @var $breadcrumb - reverse the array for parent-child ordering */
			$breadcrumb = array_reverse( $breadcrumb );

			return $breadcrumb;

		}

		/** End if - is singular */

		return null;

	}

	/** End function - breadcrumbs */


	/**
	 * Post Breadcrumb
	 * Create a breadcrumb trail showing the first category and Post Format of
	 * the post where the category and Post Format link to their respective
	 * archive.
	 *
	 * @package OpusPrimus
	 * @since   1.1
	 *
	 * @uses    OpusPrimusBreadcrumbs::breadcrumb_categories
	 * @uses    OPusPrimusBreadcrumbs::breadcrumb_post_title
	 * @uses    OpusPrimusBreadcrumbs::post_format_name
	 * @uses    apply_filters
	 * @uses    home_url
	 * @uses    is_single
	 * @uses    is_singular
	 * @uses    is_sticky
	 * @uses    wp_get_shortlink
	 *
	 * @return  null|string
	 *
	 * @version 1.2
	 * @date    July 21, 2013
	 * Check for long post titles and trim as needed
	 *
	 * @version 1.2.2
	 * @date    October 26, 2013
	 * Extracted the $post_title management into the `breadcrumb_post_title` method
	 *
	 * @version 1.3
	 * @date    September 19, 2014
	 * Changed link to the WordPress shortlink
	 */
	function post_breadcrumbs() {

		/** Sanity check - are we on a single view template and single */
		if ( is_singular() && is_single() ) {

			/** Get the global post object */
			global $post;

			/** @var $post_ID - the post ID, since its outside the_Loop */
			$post_ID = $post->ID;

			/** @var $post_trail - variable holding the output */
			$post_trail = '<div id="breadcrumbs">';

			$post_trail .= '<ul class="breadcrumb">';

			$post_trail .= '<li class="post-breadcrumbs-home-text">'
			               . '<a href="' . home_url( '/' ) . '">' . apply_filters( 'opus_post_breadcrumbs_home_text', __( 'Home', 'opus-primus' ) ) . '</a>'
			               . '</li>';

			/** @var $post_trail - add breadcrumb categories */
			$post_trail = $this->breadcrumb_categories( $post_trail, $post_ID );

			/** @var $post_trail - add Post Format name */
			$post_trail = $this->post_format_name( $post_ID, $post_trail );

			/** If post is sticky add Sticky Post text */
			if ( is_sticky( $post_ID ) ) {
				$post_trail .= sprintf(
					'<li class="post-breadcrumbs-sticky-text"><a href="#">%1$s</a></li>',
					apply_filters( 'opus_post_breadcrumbs_sticky_text', __( 'Sticky Post', 'opus-primus' ) )
				);
			}
			/** Enf if - is sticky */

			$post_title = $this->breadcrumb_post_title( $post, $post_ID );

			$post_trail .= '<li><a href="' . wp_get_shortlink() . '">' . $post_title . '</a></li>';

			$post_trail .= '</ul><!-- breadcrumb -->';

			$post_trail .= '</div><!-- #breadcrumbs -->';

			return $post_trail;

		}

		/** End if - is singular */

		return null;

	}

	/** End function - post_breadcrumbs */


	/**
	 * Post Format Name
	 * Display the Post Format name as part of the post trail
	 *
	 * @package OpusPrimus
	 * @since   1.1
	 *
	 * @param   $post_trail - existing post trail
	 * @param   $post_ID    - post ID, since breadcrumbs are outside of the_Loop
	 *
	 * @uses    get_post_format
	 * @uses    get_post_format_link
	 * @uses    get_post_format_string
	 *
	 * @return  null|string
	 */
	function post_format_name( $post_ID, $post_trail ) {

		/** @var $post_format_name - get Post Format name */
		$post_format_name = get_post_format_string( get_post_format( $post_ID ) );

		/** @var $post_format_output - create link to Post Format archive */
		$post_format_output = '<a href="' . get_post_format_link( get_post_format( $post_ID ) ) . '" title="' . sprintf( __( 'View the %1$s archive.', 'opus-primus' ), $post_format_name ) . '">' . $post_format_name . '</a>';

		/** Only show Post Format if it is not the Standard */
		if ( 'Standard' == $post_format_name ) {
			$post_trail .= '';
		} else {
			$post_trail .= '<li>' . $post_format_output . '</li>';
		}

		/** End if - standard is post format name */

		return $post_trail;

	}

	/** End function - post format name */


	/**
	 * Breadcrumb Categories
	 * Adds the post categories to the post trail
	 *
	 * @package OpusPrimus
	 * @since   1.1
	 *
	 * @param   $post_trail - existing post trail
	 * @param   $post_ID    - post ID, since breadcrumbs are outside of the_Loop
	 *
	 * @uses    get_the_category
	 * @uses    home_url
	 *
	 * @return  null|string
	 */
	function breadcrumb_categories( $post_trail, $post_ID ) {

		/** Add categories unordered list to post trail */
		$post_trail .= '<li><ul class="post-trail-categories">';

		$post_categories = get_the_category( $post_ID );
		/** Loop through categories */
		foreach ( $post_categories as $category ) {

			$post_trail .= '<li>';
			$post_trail .= '<a href="' . home_url( '/?cat=' ) . $category->cat_ID . '">' . $category->name . '</a>';
			$post_trail .= '</li>';

		}
		/** End for - categories loop */

		/** Close categories unordered list */
		$post_trail .= '</ul></li>';

		/** Return categories part of post trail to be added to post trail */

		return $post_trail;

	}

	/** End function - breadcrumb categories */


	/**
	 * The Trail
	 * Create the trail of breadcrumbs
	 *
	 * @package     OpusPrimus
	 * @subpackage  Breadcrumbs
	 * @since       1.0.4
	 *
	 * @uses        OpusPrimusBreadcrumbs::breadcrumbs
	 * @uses        get_post
	 * @uses        home_url
	 */
	function the_trail() {

		/**
		 * Hansel and Gretel did not need breadcrumbs until they left home, no
		 * reason we need to have them if we are at home, too.
		 */
		if ( null !== $this->breadcrumbs() ) {

			$trail = '<div id="breadcrumbs">';
			$trail .= '<ul class="breadcrumb">';

			$trail .= '<li>'
			          . '<a href="' . home_url( '/' ) . '">' . __( 'Home', 'opus-primus' ) . '</a>'
			          . '</li>';

			foreach ( $this->breadcrumbs() as $steps ) {

				$post_title = empty( get_post( $steps )->post_title )
					? sprintf( __( 'Page ID: %1$s', 'opus-primus' ), get_post( $steps )->ID )
					: get_post( $steps )->post_title;

				$trail .= '<li>'
				          . '<a title="' . $post_title . '" href="' . home_url( '/?page_id=' ) . get_post( $steps )->ID . '">' . $post_title . '</a>'
				          . '</li>';

			}
			/** End foreach - steps */

			$trail .= '</ul><!-- breadcrumb -->';
			$trail .= '</div><!-- #breadcrumbs -->';

			return $trail;

		}

		/** End if - no breadcrumbs */

		return null;

	}

	/** End function - the trail */


	/**
	 * Breadcrumb Post Title
	 * Manages the creation of a post title reference for the breadcrumb by
	 * either using the existing title or by creating a post title using its ID
	 *
	 * @package     OpusPrimus
	 * @subpackage  Breadcrumbs
	 * @since       1.2.2
	 *
	 * @param       $post
	 * @param       $post_ID
	 *
	 * @uses        apply_filters
	 *
	 * @return      string $post_title
	 */
	function breadcrumb_post_title( $post, $post_ID ) {

		/** @var $post_title - sets Post Title to ID if empty */
		$post_title = empty( $post->post_title )
			? sprintf( __( 'Post %1$s', 'opus-primus' ), $post_ID )
			: $post->post_title;

		/** @var int $maximum_post_title_length - allowable length of post title */
		$maximum_post_title_length = apply_filters( 'opus_post_breadcrumbs_maximum_post_title_length', 50 );

		/** Check for long post titles after removing HTML tags and trim as needed afterward */
		if ( strlen( strip_tags( $post_title ) ) > intval( $maximum_post_title_length ) ) {

			/** @var string $post_title - contains HTML stripped truncated post title */
			$post_title = substr( strip_tags( $post_title ), 0, $maximum_post_title_length ) . apply_filters( 'opus_post_breadcrumbs_shortened_title_suffix', '&hellip;' );

			return $post_title;

		}

		/** End if - post title longer than 50 characters */

		return $post_title;

	}

	/** End function - breadcrumb post title */


	/**
	 * Show The Trail
	 * Shows the trail of breadcrumbs
	 *
	 * @package     OpusPrimus
	 * @subpackage  Breadcrumbs
	 * @since       1.0.4
	 *
	 * @uses        OpusPrimusBreadcrumbs::the_trail
	 * @uses        OpusPrimusBreadcrumbs::post_breadcrumbs
	 *
	 * @version     1.2.2
	 * @date        October 26, 2013
	 * Added conditional test rather than print both breadcrumbs (one empty)
	 */
	function show_the_trail() {

		if ( is_page() ) {
			echo $this->the_trail();
		} else {
			echo $this->post_breadcrumbs();
		}
		/** End if - is page */

	}
	/** End function - show the trail */


}

/** End class - opus primus breadcrumbs */