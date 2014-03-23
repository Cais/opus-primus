<?php

/**
 * Opus Primus Posts
 * Controls for the organization and layout of the post and its content.
 *
 * @package        OpusPrimus
 * @since          0.1
 *
 * @author         Opus Primus <in.opus.primus@gmail.com>
 * @copyright      Copyright (c) 2012-2014, Opus Primus
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
 * @version        1.0.1
 * @date           February 21, 2013
 * Re-order methods: action and filter calls by request order, then alphabetical
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 *
 * @version        1.1
 * @date           March 7, 2013
 * Added `excerpt_more_link` and attached to `excerpt_more` filter
 * Added `anchor_title_text` for use with `excerpt_more_link` and permalinks in the post meta details
 *
 * @version        1.2.3
 * @date           January 12, 2014
 * Provide unique class for post coda if the post has a post format
 */
class OpusPrimusPosts {
	/**
	 * Constructor
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    add_filter
	 */
	function __construct() {
		/** Add excerpt more link */
		add_filter( 'excerpt_more', array( $this, 'excerpt_more_link' ) );

		/** Add classes to post tag */
		add_filter( 'post_class', array( $this, 'post_classes' ) );
	}

	/** End function - construct */


	/** ---- Action and Filter Methods ---- */


	/**
	 * Excerpt More Link
	 *
	 * @package          OpusPrimus
	 * @class            Posts
	 * @since            1.0.5
	 *
	 * @uses             OpusPrimusPosts::anchor_title_text
	 * @uses    (GLOBAL) $post
	 * @uses             apply_filters
	 * @uses             get_permalink
	 *
	 * @return  string
	 *
	 * @version          1.2.3
	 * @date             February 3, 2014
	 * Moved the ellipsis out of the read more link
	 * Removed unused parameter `$more`
	 */
	function excerpt_more_link() {

		/** Get global for the post */
		global $post;

		/** @var $link_text - text for the title attribute */
		$link_text = sprintf( __( 'Read more of %1$s', 'opus-primus' ), $this->anchor_title_text() );

		/** @var $link_url - URL to single view */
		$link_url = apply_filters(
			'opus_excerpt_more_link',
			' &hellip; ' . '<a class="excerpt-more-link" title="' . $link_text . '" href="' . get_permalink( $post->ID ) . '">&infin;</a>'
		);

		return $link_url;

	}

	/** End function - excerpt more link */


	/**
	 * Post Classes
	 * A collection of classes added to the post_class for various purposes
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   $classes - existing post classes
	 *
	 * @uses    OpusPrimusStructures::replace_spaces
	 * @uses    get_post_meta
	 * @uses    get_the_author_meta
	 * @uses    get_the_date
	 * @uses    get_the_modified_date
	 * @uses    get_userdata
	 *
	 * @return  string - specific class based on active columns
	 */
	function post_classes( $classes ) {
		/** Call the structure class to use replace spaces */
		global $opus_structures;

		/** Original Post Classes */
		/** Year */
		$post_year      = get_the_date( 'Y' );
		$classes[]      = 'year-' . $post_year;
		$post_leap_year = get_the_date( 'L' );
		if ( '1' == $post_leap_year ) {
			$classes[] = 'leap-year';
		}
		/** End if - leap year */

		/** Month */
		$post_month_numeric = get_the_date( 'm' );
		$classes[]          = 'month-' . $post_month_numeric;
		$post_month_short   = get_the_date( 'M' );
		$classes[]          = 'month-' . strtolower( $post_month_short );
		$post_month_long    = get_the_date( 'F' );
		$classes[]          = 'month-' . strtolower( $post_month_long );

		/** Day */
		$post_day_of_month      = get_the_date( 'd' );
		$classes[]              = 'day-' . $post_day_of_month;
		$post_day_of_week_short = get_the_date( 'D' );
		$classes[]              = 'day-' . strtolower( $post_day_of_week_short );
		$post_day_of_week_long  = get_the_date( 'l' );
		$classes[]              = 'day-' . strtolower( $post_day_of_week_long );

		/** Time: Hour */
		$post_24_hour = get_the_date( 'H' );
		$classes[]    = 'hour-' . $post_24_hour;
		$post_12_hour = get_the_date( 'ha' );
		$classes[]    = 'hour-' . $post_12_hour;

		/** Author */
		$opus_author_id = get_the_author_meta( 'ID' );
		$classes[]      = 'author-' . $opus_author_id;
		$display_name   = $opus_structures->replace_spaces( strtolower( get_the_author_meta( 'display_name', $opus_author_id ) ) );
		$classes[]      = 'author-' . $display_name;

		/** Modified Post Classes */
		if ( get_the_date() <> get_the_modified_date() ) {
			$classes[] = 'modified-post';

			/** Year - Modified */
			$post_year      = get_the_modified_date( 'Y' );
			$classes[]      = 'modified-year-' . $post_year;
			$post_leap_year = get_the_modified_date( 'L' );
			if ( '1' == $post_leap_year ) {
				$classes[] = 'modified-leap-year';
			}
			/** End if - leap year */

			/** Month - Modified */
			$post_month_numeric = get_the_modified_date( 'm' );
			$classes[]          = 'modified-month-' . $post_month_numeric;
			$post_month_short   = get_the_modified_date( 'M' );
			$classes[]          = 'modified-month-' . strtolower( $post_month_short );
			$post_month_long    = get_the_modified_date( 'F' );
			$classes[]          = 'modified-month-' . strtolower( $post_month_long );

			/** Day - Modified */
			$post_day_of_month      = get_the_modified_date( 'd' );
			$classes[]              = 'modified-day-' . $post_day_of_month;
			$post_day_of_week_short = get_the_modified_date( 'D' );
			$classes[]              = 'modified-day-' . strtolower( $post_day_of_week_short );
			$post_day_of_week_long  = get_the_modified_date( 'l' );
			$classes[]              = 'modified-day-' . strtolower( $post_day_of_week_long );

			/** Time: Hour - Modified */
			$post_24_hour = get_the_modified_date( 'H' );
			$classes[]    = 'modified-hour-' . $post_24_hour;
			$post_12_hour = get_the_modified_date( 'ha' );
			$classes[]    = 'modified-hour-' . $post_12_hour;

			global $post;
			/** @var $last_user - establish the last user */
			$last_user = '';
			if ( $last_id = get_post_meta( $post->ID, '_edit_last', true ) ) {
				$last_user = get_userdata( $last_id );
			}
			/** End if - last id */

			/** @var $mod_author_id - ID of the last user */
			$mod_author_id           = $last_user->ID;
			$classes[]               = 'modified-author-' . $mod_author_id;
			$mod_author_display_name = $opus_structures->replace_spaces( $last_user->display_name );
			$classes[]               = 'modified-author-' . $mod_author_display_name;
		}

		/** Return the classes for use with the `post_class` hook */

		return $classes;

	}

	/** End function - post classes */


	/** ---- Additional Methods ---- */


	/**
	 * Author Posts Link
	 * Displays URL to author archive
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    __
	 * @uses    esc_attr
	 * @uses    get_author_posts_url
	 * @uses    get_the_author_meta
	 * @uses    get_the_author
	 *
	 * @return  string - URL to author archive
	 */
	function author_posts_link() {
		return sprintf(
			'<span class="author-url"><a class="archive-url" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			esc_attr( sprintf( __( 'View all posts by %1$s', 'opus-primus' ), get_the_author() ) ),
			get_the_author()
		);
	}

	/** End function - author posts link */


	/**
	 * Anchor Title Text
	 * Returns the post title text to be used as the anchor title if it exists
	 *
	 * @package     OpusPrimus
	 * @subpackage  Posts
	 * @since       1.0.5
	 *
	 * @uses        __
	 * @uses        the_title_attribute
	 *
	 * @return      null|string|void - anchor text
	 */
	function anchor_title_text() {

		/** @var $link_title_text - initialize variable for the title */
		$link_title_text = the_title_attribute( 'echo=0' );

		/** Return the string */

		return empty( $link_title_text ) ? __( 'post', 'opus-primus' ) : $link_title_text;

	}

	/** End function - anchor title text */


	/**
	 * Meta Tags
	 * Prints HTML with meta information for the current post (category, tags
	 * and permalink) - inspired by TwentyTen
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @internal REQUIRES use within the_Loop
	 *
	 * @param   string $anchor ( default = Posted ) - passed from the loops
	 *
	 * @uses     OpusPrimusPosts::anchor_title_text
	 * @uses     OpusPrimusPosts::no_title_link
	 * @uses     OpusPrimusPosts::status_update
	 * @uses     __
	 * @uses     do_action
	 * @uses     get_permalink
	 * @uses     get_post_type
	 * @uses     get_the_category_list
	 * @uses     get_the_tag_list
	 * @uses     no_title_link
	 * @uses     the_title_attribute
	 * @uses     uncategorized
	 *
	 * @version  1.2
	 * @date     July 11, 2013
	 * Changed `meta-byline` container from `p` to `div`
	 */
	function meta_tags( $anchor ) {
		/** Add empty hook before meta tags */
		do_action( 'opus_meta_tags_before' );

		/**
		 * Retrieves tag list of current post, separated by commas; if there are
		 * tags associated with the post show them, If there are no tags for the
		 * post do not make any references to tags.
		 */
		$opus_tag_list = get_the_tag_list( '', ', ', '' );

		if ( ( $opus_tag_list ) && ( ! $this->uncategorized() ) ) {
			$opus_posted_in = __( '%1$s in %2$s and tagged %3$s. Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark. %6$s', 'opus-primus' );
		} elseif ( ( $opus_tag_list ) && ( $this->uncategorized() ) ) {
			$opus_posted_in = __( '%1$s and tagged %3$s. Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark. %6$s', 'opus-primus' );
		} elseif ( ( ! $opus_tag_list ) && ( ! $this->uncategorized() ) ) {
			$opus_posted_in = __( '%1$s in %2$s. Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark. %6$s', 'opus-primus' );
		} else {
			$opus_posted_in = __( 'Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark. %6$s', 'opus-primus' );
		}
		/** End if - tag list */

		/** Prints the "opus_posted_in" string, replacing the placeholders */
		printf(
			'<div class="meta-tags">' . $opus_posted_in . '</div><!-- .meta-tags -->',
			$this->no_title_link( $anchor ),
			get_the_category_list( ', ' ),
			$opus_tag_list,
			get_permalink(),
			$this->anchor_title_text(),
			$this->status_update()
		);

		/** Add empty hook after meta tags */
		do_action( 'opus_meta_tags_after' );

	}

	/** End function - meta tags */


	/**
	 * Modified Author Posts Link
	 * Creates link to the modified author's post archive
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    __
	 * @uses    esc_attr
	 * @uses    home_url
	 *
	 * @param   $last_user - passed from OpusPrimusPosts::modified_post
	 *
	 * @return  string - URL to author archive
	 */
	function modified_author_posts_link( $last_user ) {
		return sprintf(
			'<span class="author-url"><a class="archive-url" href="%1$s" title="%2$s">%3$s</a></span>',
			home_url( '?author=' . $last_user->ID ),
			esc_attr( sprintf( __( 'View all posts by %1$s', 'opus-primus' ), $last_user->display_name ) ),
			$last_user->display_name
		);
	}

	/** End function - modified posts link */


	/**
	 * Modified Post
	 * If the post time and the last modified time are different display
	 * modified date and time and the modifying author
	 *
	 * @package          OpusPrimus
	 * @since            0.1
	 *
	 * @param   string $tempus - date|time ( default = date )
	 *
	 * @uses    (GLOBAL) $opus_author_id
	 * @uses    (GLOBAL) $post
	 * @uses             __
	 * @uses             apply_filters
	 * @uses             do_action
	 * @uses             get_avatar
	 * @uses             get_post_meta
	 * @uses             get_the_date
	 * @uses             get_the_modified_date
	 * @uses             get_the_modified_time
	 * @uses             get_the_time
	 * @uses             get_userdata
	 * @uses             home_url
	 *
	 * @version          1.0.1
	 * @date             February 22, 2013
	 * Wrapped 'opus_modified_post_after' in conditional making it consistent with 'opus_modified_post_before'
	 *
	 * @version          1.2.4
	 * @date             March 22, 2014
	 * Corrected modified date/time output for scheduled posts so they do not show a modified date/time until after they have been published
	 */
	function modified_post( $tempus = 'date' ) {
		/** Grab the $post object and bring in the original post author ID */
		global $post, $opus_author_id;

		/** @var $last_user - establish the last user */
		$last_user = '';
		if ( $last_id = get_post_meta( $post->ID, '_edit_last', true ) ) {
			$last_user = get_userdata( $last_id );
		}
		/** End if - last id */

		/**
		 * @var $line_height - set value for use with `get_avatar`
		 * @todo Review if this can be set programmatically (1.2)
		 */
		$line_height = 18;

		/** @var string $mod_author_phrase - create the "mod_author_phrase"
		 * depending on whether or not the modifying author is the same as the
		 * post author or another author.
		 */
		$mod_author_phrase = ' ';
		/**
		 * Check last_user ID exists in database; and, then compare user IDs.
		 * If the last user is not in the database an error will occur, and if
		 * the last user is not in the database then the modifications should
		 * not be noted ( per developer prerogative ).
		 */
		if ( ( ! empty( $last_user ) ) && ( $opus_author_id <> $last_id ) ) {
			$mod_author_phrase .= apply_filters( 'opus_mod_different_author_phrase', __( 'Last modified by %1$s %2$s %3$s %4$s.', 'opus-primus' ) );
			$mod_author_avatar = get_avatar( $last_user->user_email, $line_height );

			/**
			 * Add empty hook before modified post author for use when the post
			 * author and the last (modified) author are different.
			 */
			do_action( 'opus_modified_post_before' );

		} else {
			$mod_author_phrase .= apply_filters( 'opus_mod_same_author_phrase', __( 'and modified %3$s %4$s.', 'opus-primus' ) );
			$mod_author_avatar = '';
		}
		/** End if - not empty last user */

		/** Check if there is a time difference from the original post date */
		if ( 'time' == $tempus ) {
			if ( ( get_the_time() <> get_the_modified_time() ) && ( get_the_time() < get_the_modified_time() ) ) {
				/** @var $mod_author_phrase string */
				printf(
					'<span class="author-modified-time">' . $mod_author_phrase . '</span>',
					$mod_author_avatar,
					apply_filters( 'opus_post_byline_mod_author', $this->modified_author_posts_link( $last_user ) ),
					apply_filters( 'opus_post_byline_mod_date', sprintf( __( 'on %1$s', 'opus-primus' ), get_the_modified_date( get_option( 'date_format' ) ) ) ),
					apply_filters( 'opus_post_byline_mod_time', sprintf( __( 'at %1$s', 'opus-primus' ), get_the_modified_time( get_option( 'time_format' ) ) ) )
				);
			}
			/** End if - get the time */
		} else {
			if ( ( get_the_date() <> get_the_modified_date() ) && ( get_the_date() < get_the_modified_date() ) ) {
				printf(
					'<span class="author-modified-date">' . $mod_author_phrase . '</span>',
					$mod_author_avatar,
					apply_filters( 'opus_post_byline_mod_author', $this->modified_author_posts_link( $last_user ) ),
					apply_filters( 'opus_post_byline_mod_date', sprintf( __( 'on %1$s', 'opus-primus' ), get_the_modified_date( get_option( 'date_format' ) ) ) ),
					apply_filters( 'opus_post_byline_mod_time', sprintf( __( 'at %1$s', 'opus-primus' ), get_the_modified_time( get_option( 'time_format' ) ) ) )
				);
			}
			/** End if - get the date */
		}
		/** End if - time */

		/** Add empty hook after modified post author if one exists */
		if ( ( ! empty( $last_user ) ) && ( $opus_author_id <> $last_id ) ) {
			do_action( 'opus_modified_post_after' );
		}
		/** End if - not empty */

	}

	/** End function - modified post */


	/**
	 * No Title Link
	 * This returns a URL to the post using the anchor text 'Posted' in the meta
	 * details with the post excerpt as the URL title; or, returns the word
	 * 'Posted' if the post title exists
	 *
	 * @package     OpusPrimus
	 * @since       0.1
	 *
	 * @param       string $anchor - word or phrase to use as anchor text when no title is present
	 *
	 * @uses        apply_filters
	 * @uses        esc_attr
	 * @uses        get_permalink
	 * @uses        get_the_excerpt
	 * @uses        get_the_title
	 *
	 * @return      string - URL|text
	 */
	function no_title_link( $anchor ) {
		/** Create URL or string text */
		$opus_no_title = get_the_title();
		empty( $opus_no_title )
			? $opus_no_title = '<span class="no-title"><a href="' . get_permalink() . '" title="' . esc_attr( get_the_excerpt() ) . '">' . $anchor . '</span></a>'
			: $opus_no_title = $anchor;

		return apply_filters( 'opus_no_title_link', $opus_no_title );

	}

	/** End function - no title link */


	/**
	 * Post Byline
	 * Outputs post meta details consisting of a configurable anchor for post
	 * link anchor text, the date and time posted, and the post author. The post
	 * author is also linked to the author's archive page.
	 *
	 * @package     OpusPrimus
	 * @since       0.1
	 *
	 * @param   array|string $byline_args - function controls
	 *
	 * @internal    @param string $anchor ( default = Posted )
	 * @internal    @param string $display_mod_author ( default = false )
	 * @internal    @param string $sticky_flag ( default = '' )
	 * @internal    @param string $tempus ( default = date ) - date|time
	 *
	 * @example     post_byline( array( 'anchor' => 'Written', 'tempus' => 'time' ) )
	 * @internal    This example will use the word "Written" as the anchor text
	 * if there is no title for the post; using 'time' will show the modified
	 * post author if there is any difference in time while using the default
	 * 'date' will only show if there is a difference of more than one (1) day.
	 * Also note, 'display_mod_author' is not needed if 'tempus' is set to 'time'.
	 *
	 * @uses        OpusPrimusPosts::author_posts_link
	 * @uses        OpusPrimusPosts::modified_post
	 * @uses        OpusPrimusPosts::no_title_link
	 * @uses        OpusPrimusPosts::post_coda
	 * @uses        OpusPrimusPosts::post_format_flag
	 * @uses        OpusPrimusPosts::sticky_flag
	 * @uses        __
	 * @uses        do_action
	 * @uses        esc_attr
	 * @uses        get_author_posts_url
	 * @uses        get_option ( date_format, time_format )
	 * @uses        get_the_author
	 * @uses        get_the_author_meta ( ID )
	 * @uses        get_the_date
	 * @uses        get_the_time
	 * @uses        wp_parse_args
	 *
	 * @version     1.2
	 * @date        July 11, 2013
	 * Added individual filters for anchor, date, time, and author elements
	 * Added `echo` parameter to display the post coda instead of the byline
	 * meta details
	 * Changed `opus_post_byline_details` filter to `opus_post_byline_phrase`
	 */
	function post_byline( $byline_args = '' ) {
		/** Set defaults */
		$defaults    = array(
			'anchor'             => __( 'Posted', 'opus-primus' ),
			'display_mod_author' => false,
			'sticky_flag'        => '',
			'tempus'             => 'date',
			'echo'               => true,
		);
		$byline_args = wp_parse_args( (array) $byline_args, $defaults );

		/** Grab the author ID from within the loop and globalize it for later use. */
		global $opus_author_id;
		$opus_author_id = get_the_author_meta( 'ID' );

		/** Add empty hook before post by line */
		do_action( 'opus_post_byline_before' );

		/** @var string $opus_post_byline - create byline phrase string */
		$opus_post_byline = apply_filters(
			'opus_post_byline_phrase',
			__( '%1$s %2$s %3$s %4$s', 'opus-primus' )
		);

		if ( true == $byline_args['echo'] ) {
			/** Output post byline */
			echo '<div class="meta-byline">';

			/** Post By-Line filtered components */
			printf(
				$opus_post_byline,
				apply_filters(
					'opus_post_byline_anchor',
					$this->no_title_link( $byline_args['anchor'] )
				),
				apply_filters(
					'opus_post_byline_date',
					sprintf(
						__( 'on %1$s', 'opus-primus' ),
						get_the_date( get_option( 'date_format' ) )
					)
				),
				apply_filters(
					'opus_post_byline_time',
					sprintf(
						__( 'at %1$s', 'opus-primus' ),
						get_the_time( get_option( 'time_format' ) )
					)
				),
				apply_filters(
					'opus_post_byline_author',
					sprintf(
						__( 'by %1$s', 'opus-primus' ),
						$this->author_posts_link()
					)
				)
			);

			/**
			 * Show modified post author if set to true or if the time span is
			 * measured in hours
			 */
			if ( $byline_args['display_mod_author'] || ( 'time' == $byline_args['tempus'] ) ) {
				$this->modified_post( $byline_args['tempus'] );
			}
			/** End if - byline args */

			/** Add a sticky note flag to the byline */
			echo $this->sticky_flag( $byline_args['sticky_flag'] );
			/** Add a post-format flag to the byline */
			echo $this->post_format_flag();

			/** Close CSS wrapper for the post byline */
			echo '</div><!-- .meta-byline -->';
		} else {
			$this->post_coda();
		}
		/** End if - echo the by line */

		/** Add empty hook after post by line */
		do_action( 'opus_post_byline_after' );

	}

	/** End function - post byline */


	/**
	 * Post Coda
	 * Adds text art after post content to signify the end of the post
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    apply_filters
	 * @uses    do_action
	 * @uses    has_post_format
	 * @uses    get_post_format
	 */
	function post_coda() {
		/** Add empty hook before post coda */
		do_action( 'opus_post_coda_before' );

		/** Create the text art */
		$post_coda = '* * * * *';

		if ( has_post_format() ) {
			$post_coda_class = 'post-coda-' . get_post_format();
		} else {
			$post_coda_class = 'post-coda';
		}
		/** End if - has post format */

		printf(
			'<div class="' . $post_coda_class . '">%1$s</div>',
			apply_filters( 'opus_post_coda', $post_coda )
		);

		/** Add empty hook after the post coda */
		do_action( 'opus_post_coda_after' );

	}

	/** End function - post coda */


	/**
	 * Post Content
	 * Outputs `the_content` and allows for the_content parameters to be used
	 *
	 * @link     http://codex.wordpress.org/Function_Reference/the_content
	 * @example  post_content( __( 'Read more of ... ', 'opus-primus' ) . the_title( '', '', false ) )
	 * @internal The above example, when the <!--more--> tag is used, will
	 * provide a link to the single view of the post with the anchor text of:
	 * "Read more of ... <the-post-title>"
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @param   string $more_link_text
	 * @param   string $stripteaser
	 *
	 * @uses     __
	 * @uses     do_action
	 * @uses     the_content
	 * @uses     the_title
	 */
	function post_content( $more_link_text = '', $stripteaser = '' ) {
		/** Add empty hook before the content */
		do_action( 'opus_the_content_before' );

		/** Check if there the more_link_text parameter has been set */
		if ( empty( $more_link_text ) ) {
			$more_link_text = __( 'Continue reading ... ', 'opus-primus' ) . the_title( '', '', false );
		}
		/** End if - empty - more link text */

		/** Check if there the stripteaser parameter has been set */
		if ( empty( $stripteaser ) ) {
			$stripteaser = '';
		}
		/** End if - empty - stripteaser */

		/** Wrap the post content in its own container */
		echo '<div class="post-content">';
		the_content( $more_link_text, $stripteaser );
		echo '</div><!-- .post-content -->';

		/** Add empty hook after the content */
		do_action( 'opus_the_content_after' );

	}

	/** End function - post content */


	/**
	 * Post Excerpt
	 * Outputs `the_excerpt`
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    do_action
	 * @uses    the_excerpt
	 */
	function post_excerpt() {
		/** Add empty hook before the excerpt */
		do_action( 'opus_the_excerpt_before' );

		/** Wrap the post excerpt in its own CSS container */
		echo '<div class="post-excerpt">';
		the_excerpt();
		echo '</div><!-- .post-excerpt -->';

		/** Add empty hook after the excerpt */
		do_action( 'opus_the_excerpt_after' );

	}

	/** End function - post excerpt */


	/**
	 * Post Format Flag
	 * Returns a string with the post-format type; optionally can not display a
	 * flag for the standard post-format (default).
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @uses       __
	 * @uses       apply_filters
	 * @uses       get_post_format
	 * @uses       get_post_format_link
	 * @uses       get_post_format_string
	 *
	 * @return  string - link to the post-format specific archive
	 *
	 * @version    1.2.3
	 * @date       February 20, 2014
	 * Refactored `$output` to use `button` class versus the button element
	 */
	function post_format_flag() {
		/** @var $flag_text - post-format */
		$flag_text  = get_post_format_string( get_post_format() );
		$title_text = $flag_text;
		if ( 'Standard' == $flag_text ) {
			return null;
		} else {
			$flag_text = '<span class="post-format-flag">' . $flag_text . '</span>';
		}
		/** End if - flag text */

		/** @var $output - the post format type linked to its archive */
		$output = '<a class="button" href="' . get_post_format_link( get_post_format() ) . '" title="' . sprintf( __( 'View the %1$s archive.', 'opus-primus' ), $title_text ) . '">' . $flag_text . '</a>';

		return apply_filters( 'opus_post_format_flag', $output );

	}

	/** End function - post format flag */


	/**
	 * Post Title
	 * Outputs the post title
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string $before
	 * @param   string $after
	 * @param   bool   $echo
	 *
	 * @uses    __
	 * @uses    do_action
	 * @uses    the_permalink
	 * @uses    the_title
	 * @uses    the_title_attribute
	 */
	function post_title( $before = '', $after = '', $echo = true ) {
		/** Add empty hook before the post title */
		do_action( 'opus_post_title_before' );

		/** Set `the_title` parameters */
		if ( empty( $before ) ) {
			$before = '<h2 class="post-title">';
		}
		/** End if - before */
		if ( empty( $after ) ) {
			$after = '</h2>';
		}
		/** End if - after */

		/** Wrap the title in an anchor tag and provide a nice tool tip */
		?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(
			array(
				'before' => __( 'View', 'opus-primus' ) . ' ',
				'after'  => ' ' . __( 'only', 'opus-primus' )
			)
		); ?>">
			<?php the_title( $before, $after, $echo ); ?>
		</a>

		<?php
		/** Add empty hook after the post title */
		do_action( 'opus_post_title_after' );

	}

	/** End function - post title */


	/**
	 * Show Status Update
	 * Used to display the status update outside of the post Meta Tags
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    OpusPrimusPosts::status_update
	 * @uses    do_action
	 */
	function show_status_update() {

		/** Add empty hook before status update output */
		do_action( 'opus_status_update_before' );

		echo $this->status_update();

		/** Add empty hook after status update output */
		do_action( 'opus_status_update_after' );

	}

	/** End function - show status update */


	/**
	 * Status Update
	 * Displays the human time difference based on how long ago the post was
	 * updated
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @param   string $update_text
	 * @param   int    $time_ago - measured in seconds, default equals one week
	 *
	 * @uses     __
	 * @uses     apply_filters
	 * @uses     current_time
	 * @uses     get_the_modified_time
	 * @uses     get_the_time
	 * @uses     human_time_diff
	 *
	 * @internal Used with Post-Format: Status
	 *
	 * @return  null|string
	 */
	function status_update( $update_text = '', $time_ago = 604800 ) {

		/**
		 * Set the default text if the update text is not passed to the function
		 * and/or allow it to be filtered
		 */
		if ( empty( $update_text ) ) {
			$update_text = sprintf(
				'<span class="status-update-text">%1$s</span>',
				apply_filters( 'opus_status_update_text', __( 'Updated again', 'opus-primus' ) )
			);
		}
		/** End if - empty update text */

		$output = '';

		/** @var int $time_diff - initialize as zero */
		$time_diff = 0;
		/** Check if the post has been modified and get how long ago that was */
		if ( get_the_modified_time( 'U' ) != get_the_time( 'U' ) ) {
			$time_diff = current_time( 'timestamp' ) - get_the_modified_time( 'U' );
		}
		/** End if - get the modified time */

		/** Compare time difference between modification and actual post */
		if ( ( $time_diff > $time_ago ) && ( $time_diff < 31449600 ) ) {
			$output = sprintf(
				'<span class="opus-status-update">%1$s</span>',
				apply_filters(
					'opus_status_update',
					sprintf(
						__( '%1$s %2$s ago.', 'opus-primus' ),
						$update_text,
						human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) )
					)
				)
			);
		} elseif ( $time_diff >= 31449600 ) {
			$output = sprintf(
				'<span class="opus-status-update">%1$s</span>',
				apply_filters( 'opus_status_update_over_year', $update_text . ' ' . __( 'over a year ago.', 'opus-primus' ) )
			);
		}
		/** End if - time diff */

		if ( 'status' == get_post_format() ) {
			return $output;
		} else {
			return null;
		}
		/** End if - format is status */

	}

	/** End function - status update */


	/**
	 * Sticky Flag
	 * Returns a text string as a button that links to the post, used with the
	 * "sticky" post functionality of WordPress
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @param   string $sticky_text
	 *
	 * @uses       __
	 * @uses       apply_filters
	 * @uses       is_sticky
	 * @uses       get_permalink
	 *
	 * @return  string
	 *
	 * @version    1.2.3
	 * @date       February 20, 2014
	 * Refactored `$output` to use `button` class versus the button element
	 *
	 * @version    1.2.4
	 * @date       February 22, 2014
	 * Change `$output = null` to `$output = ''`
	 */
	function sticky_flag( $sticky_text = '' ) {

		if ( '' == $sticky_text ) {
			$sticky_text = __( 'Featured', 'opus-primus' );
			$sticky_text = apply_filters( 'opus_default_sticky_flag', $sticky_text );
		}
		/** End if - sticky text */

		if ( is_sticky() ) {
			$output = '<a class="button" href="' . get_permalink() . '" title="' . sprintf( __( 'Go to %1$s post', 'opus-primus' ), strtolower( $sticky_text ) ) . '">'
					  . '<span class="sticky-flag-text">'
					  . $sticky_text
					  . '</span>'
					  . '</a>';
		} else {
			$output = '';
		}

		/** End if - is sticky */

		return apply_filters( 'opus_sticky_flag', $output );

	}

	/** End function - sticky flag */


	/**
	 * Uncategorized
	 * Returns true if there is only one category assigned to the post and it is
	 * the WordPress default "Uncategorized". Renaming the default category will
	 * avoid this function being used.
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @internal Must be called inside the_Loop
	 * @internal This works because the default category is ID 1 and the default
	 * objects returned are in ID order.
	 * @internal used for conditional test in meta_tags method
	 *
	 * @uses     get_the_category
	 * @uses     is_page
	 *
	 * @return bool
	 */
	function uncategorized() {
		/** @var $post_categories - holds all of the post category objects */
		$post_categories = get_the_category();
		/**
		 * If the first category object is 'uncategorized' and there is no
		 * second category by checking if the second object is empty then
		 * return true ... else return false
		 */
		if ( ! is_page() && 'uncategorized' == $post_categories[0]->slug ) {
			if ( empty( $post_categories[1]->slug ) ) {
				return true;
			}
			/** End if - empty */
		}

		/** End if - uncategorized */

		return false;

	}
	/** End function - uncategorized */


}

/** End Opus Primus Posts class */


/** @var $opus_posts - new instance of class */
$opus_posts = new OpusPrimusPosts();