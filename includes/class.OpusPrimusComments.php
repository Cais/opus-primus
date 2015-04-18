<?php

/**
 * Opus Primus Comments
 *
 * Comments related functions
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2015, Opus Primus
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
 * @version     1.1.1
 * @date        March 22, 2013
 * Added `comments only tab`, `pingbacks only tab`, `trackbacks only tab`,
 * `comments only panel`, `pingbacks only panel` and `trackbacks only panel`
 * functionality class methods from 'comments.php' template
 * Added `all_comments_count` and `show_all_comments_count` to be used in the
 * 'comments.php' template to display total comments
 *
 * @version     1.2
 * @date        March 31, 2013
 * Added filtered `comment_form_required_field_glyph` method for comment fields
 * Change comment fields into an unordered list
 *
 * @version     1.4
 * @date        March 31, 2015
 * Change `OpusPrimusComments` to a singleton style class
 * Returned `before_comment_form` and `comments_form_closed` methods
 */
class OpusPrimusComments {

	private static $instance = null;

	/**
	 * Create Instance
	 *
	 * Creates a single instance of the class
	 *
	 * @since   1.4
	 * @date    March 31, 2015
	 *
	 * @return null|OpusPrimusComments
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}


	/**
	 * Constructor
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @uses       add_action
	 * @uses       add_filter
	 */
	function __construct() {
		/** Add comment actions - enqueue threaded comments */
		add_action(
			'comment_form_before', array(
			$this,
			'enqueue_comment_reply'
		) );

		add_action( 'comment_form_before', array(
			$this,
			'before_comment_form'
		) );
		add_action( 'comment_form_comments_closed', array(
			$this,
			'comments_form_closed'
		) );

		/** Add comment actions - wrap comment fields in unordered list */
		add_action(
			'comment_form_before_fields', array(
			$this,
			'comment_fields_wrapper_start'
		) );
		add_action(
			'comment_form_after_fields', array(
			$this,
			'comment_fields_wrapper_end'
		) );

		/** Add comment filters - NB: Order of these filters is important! */
		add_filter( 'comment_class', array( $this, 'comment_author_class' ) );

		add_filter(
			'comment_form_defaults', array(
			$this,
			'change_comment_form_required_field_glyph'
		) );

		/** Add comment filters - change fields to list items from paragraphs */
		add_filter(
			'comment_form_default_fields', array(
			$this,
			'comment_fields_as_list_items'
		) );

	}


	/**
	 * Enqueue Comment Reply
	 *
	 * If the page being viewed is a single post/page; and, comments are open;
	 * and, threaded comments are turned on then enqueue the built-in
	 * comment-reply script.
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    is_singular
	 * @uses    comments_open
	 * @uses    get_option
	 * @uses    wp_enqueue_script
	 */
	function enqueue_comment_reply() {

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}


	/**
	 * Before Comment Form
	 *
	 * Text to be shown before form
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @uses     __
	 * @uses     apply_filters
	 * @uses     have_comments
	 * @uses     post_password_required
	 *
	 * @version  1.0.1
	 * @date     February 19, 2013
	 * Fixed no comments message
	 */
	function before_comment_form() {
		/** Conditional check for password protected posts ... no comments for you! */
		if ( post_password_required() ) {
			printf(
				'<span class="comments-password-message">' .
				apply_filters( 'opus_comments_password_required', __( 'This post is password protected. Enter the password to view comments.', 'opus-primus' ) ) .
				'</span>'
			);

			return;
		}

		/** If comments are open, but there are no comments. */
		if ( ! have_comments() ) {
			printf(
				'<span class="no-comments-message">' .
				apply_filters( 'opus_no_comments_message', __( 'Start a discussion ...', 'opus-primus' ) ) .
				'</span>'
			);
		}

	}


	/**
	 * Comment Form Required Field Glyph
	 *
	 * Returns a filtered glyph used with Comment Form Required Fields
	 *
	 * @package OpusPrimus
	 * @since   1.2
	 *
	 * @uses    __
	 * @uses    apply_filters
	 *
	 * @return  mixed|void - default glyph - asterisk (*)
	 *
	 * @version 1.4
	 * @date    April 18, 2015
	 * Symbolic characters do not need to be translated
	 */
	function comment_form_required_field_glyph() {

		$glyph = apply_filters( 'opus_comment_form_required_field_glyph', '*' );

		return $glyph;

	}


	/**
	 * Change Comment Form Required Field Glyph
	 *
	 * Changes the default asterisk (*) to a filtered function
	 *
	 * @package  OpusPrimus
	 * @since    1.2
	 *
	 * Props to Sergey Biryukov via the WordPress core trac for the base code
	 * used in this method
	 * @link     https://core.trac.wordpress.org/ticket/23870
	 *
	 * @uses     OpusPrimusComments::comment_form_required_field_glyph
	 *
	 * @param   $defaults
	 *
	 * @return  mixed
	 */
	function change_comment_form_required_field_glyph( $defaults ) {

		$defaults['fields']['author']     = str_replace( '*', $this->comment_form_required_field_glyph(), $defaults['fields']['author'] );
		$defaults['fields']['email']      = str_replace( '*', $this->comment_form_required_field_glyph(), $defaults['fields']['email'] );
		$defaults['comment_notes_before'] = str_replace( '*', $this->comment_form_required_field_glyph(), $defaults['comment_notes_before'] );

		return $defaults;

	}


	/**
	 * Comments Form Closed
	 *
	 * Test to be displayed if comments are closed
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @uses     __
	 * @uses     apply_filters
	 * @uses     is_page
	 */
	function comments_form_closed() {

		if ( ! is_page() ) {

			printf(
				'<span class="comments-closed-message">' .
				apply_filters( 'opus_comments_form_closed', __( 'New comments are not being accepted at this time, please feel free to contact the post author directly.', 'opus-primus' ) ) .
				'</span>'
			);

		}

	}


	/**
	 * Comment Author Class
	 *
	 * Add additional classes to the comment based on the author
	 *
	 * @package          OpusPrimus
	 * @since            0.1
	 *
	 * @uses             (GLOBAL) $comment
	 * @uses             user_can
	 *
	 * @param   array $classes
	 *
	 * @return  array $classes - original array plus additional role and user-id
	 */
	function comment_author_class( $classes ) {

		global $comment;

		/** Add classes based on user role */
		if ( user_can( $comment->user_id, 'administrator' ) ) {
			$classes[] = 'administrator';
		} elseif ( user_can( $comment->user_id, 'editor' ) ) {
			$classes[] = 'editor';
		} elseif ( user_can( $comment->user_id, 'contributor' ) ) {
			$classes[] = 'contributor';
		} elseif ( user_can( $comment->user_id, 'subscriber' ) ) {
			$classes[] = 'subscriber';
		} else {
			$classes[] = 'guest';
		}

		/** Add user ID based classes */
		if ( $comment->user_id == 1 ) {
			/** Administrator 'Prime' => first registered user ID */
			$userid = "administrator-prime user-id-1";
		} else {
			/** All other users - NB: user-id-0 -> non-registered user */
			$userid = "user-id-" . ( $comment->user_id );
		}

		$classes[] = $userid;

		return $classes;

	}


	/**
	 * Comment Fields as List Items
	 *
	 * @package OpusPrimus
	 * @since   1.2
	 *
	 * @uses    esc_attr
	 * @uses    get_option
	 * @uses    wp_get_current_commenter
	 *
	 * @return  array
	 */
	function comment_fields_as_list_items() {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );

		$fields = array(
			'author' => '<li class="comment-form-author">' . '<label for="author">' . __( 'Name', 'opus-primus' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . ' " size="30" ' . $aria_req . ' /></li>',
			'email'  => '<li class="comment-form-email"><label for="email">' . __( 'Email', 'opus-primus' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			            '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . ' " size="30" ' . $aria_req . ' /></li>',
			'url'    => '<li class="comment-form-url"><label for="url">' . __( 'Website', 'opus-primus' ) . '</label>' .
			            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></li>',
		);

		return $fields;

	}


	/**
	 * Comment Fields Wrapper Start
	 *
	 * Echoes an opening `ul` tag
	 *
	 * @package  OpusPrimus
	 * @since    1.2
	 *
	 * @internal Works in conjunction with `comment_fields_as_list_items`
	 */
	function comment_fields_wrapper_start() {
		echo '<ul id="comment-fields-listed-wrapper">';
	}


	/**
	 * Comment Fields Wrapper End
	 *
	 * Echoes a closing `ul` tag
	 *
	 * @package  OpusPrimus
	 * @since    1.2
	 *
	 * @internal Works in conjunction with `comment_fields_as_list_items`
	 */
	function comment_fields_wrapper_end() {
		echo '</ul><!-- #comment-fields-listed-wrapper -->';
	}


	/**
	 * Comments Link
	 *
	 * Displays amount of approved comments the post or page has
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    OpusPrimusComments::comments_closed_class
	 * @uses    OpusPrimusComments::has_comments_class
	 * @uses    comments_popup_link
	 * @uses    do_action
	 * @uses    is_archive
	 * @uses    is_single
	 *
	 * @version 1.2.4
	 * @date    May 10, 2014
	 * Added sanity check to only display comments_link when not in single view or in an archive view
	 *
	 * @version 1.4
	 * @date    April 18, 2015
	 * Refactored to use the WordPress core more effectively
	 * Added two classes for use in rendering the text displayed ... or not
	 */
	function comments_link() {

		/** Only show the comments_link when not in single views or in archive views */
		if ( ! is_single() || is_archive() ) {

			/** Add empty hook before comments link */
			do_action( 'opus_comments_link_before' );


			echo '<h5 class="comments-link ' . $this->comments_closed_class() . ' ' . $this->has_comments_class() . '">';

			comments_popup_link();

			echo '</h5><!-- .comments-link -->';


			/** Add empty hook after comments link */
			do_action( 'opus_comments_link_after' );

		}

	}


	/**
	 * Comments Closed Class
	 *
	 * Returns an appropriate string indicating if comments are open of closed
	 * on the post or page in question
	 *
	 * @package OpusPrimus
	 * @since   1.4
	 *
	 * @uses    comments_open
	 *
	 * @return string
	 */
	function comments_closed_class() {

		if ( ! comments_open() ) {
			return 'comments-closed';
		} else {
			return 'comments-open';
		}

	}


	/**
	 * Has Comments Class
	 *
	 * Returns an appropriate string indicating if comments exist for the post
	 * or page in question
	 *
	 * @package OpusPrimus
	 * @since   1.4
	 *
	 * @uses    get_comments_number
	 *
	 * @return string
	 */
	function has_comments_class() {

		if ( 0 < get_comments_number() ) {
			return 'has-comments';
		} else {
			return 'no-comments';
		}

	}


	/**
	 * Wrapped Comments Template
	 *
	 * Wraps the comments_template call in action hooks
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @uses    do_action
	 * @uses    comments_template
	 */
	function wrapped_comments_template() {

		/** Add empty hook before comments */
		do_action( 'opus_comments_before' );

		comments_template( '/comments.php', true );

		/** Add empty hook after comments */
		do_action( 'opus_comments_after' );

	}


	/**
	 * Comments Only Tab
	 *
	 * Displays number of comments for the type:comment tab
	 *
	 * @package OpusPrimus
	 * @since   1.1.1
	 *
	 * @uses    WP_Query::comments_by_type
	 * @uses    __
	 * @uses    _n
	 * @uses    number_format_i18n
	 *
	 * @version 1.4
	 * @date    April 11, 2015
	 * Added `number_format_i18n` to better accommodate locale based values
	 */
	function comments_only_tab() {

		global $wp_query;

		$comments_only = $wp_query->comments_by_type['comment'];

		if ( ! empty( $comments_only ) ) { ?>

			<li id="comments-only-tab">
				<a href="#comments-only">
					<h3 id="comments">
						<?php
						printf(
							_n(
								__( '%1$s Comment', 'opus-primus' ),
								__( '%1$s Comments', 'opus-primus' ),
								count( $comments_only )
							),
							number_format_i18n( count( $comments_only ) )
						); ?>
					</h3><!-- #comments -->
				</a>
			</li><!-- #comments-only-tab -->

		<?php }

	}


	/**
	 * Pingbacks Only Tab
	 *
	 * Displays number of comments for the type:pingback tab
	 *
	 * @package OpusPrimus
	 * @since   1.1.1
	 *
	 * @uses    WP_Query::comments_by_type
	 * @uses    __
	 * @uses    _n
	 * @uses    number_format_i18n
	 *
	 * @version 1.4
	 * @date    April 11, 2015
	 * Added `number_format_i18n` to better accommodate locale based values
	 */
	function pingbacks_only_tab() {

		global $wp_query;

		$pingbacks_only = $wp_query->comments_by_type['pingback'];

		if ( ! empty( $pingbacks_only ) ) { ?>

			<li id="pingbacks-only-tab">
				<a href="#pingbacks-only">
					<h3 id="pingbacks">
						<?php
						printf(
							_n(
								__( '%1$s Pingback', 'opus-primus' ),
								__( '%1$s Pingbacks', 'opus-primus' ),
								count( $pingbacks_only )
							),
							number_format_i18n( count( $pingbacks_only ) )
						); ?>
					</h3><!-- #pingbacks -->
				</a>
			</li><!-- #pingbacks-only-tab -->

		<?php }

	}


	/**
	 * Trackbacks Only Tab
	 *
	 * Displays number of comments for the type:trackback tab
	 *
	 * @package OpusPrimus
	 * @since   1.1.1
	 *
	 * @uses    WP_Query::comments_by_type
	 * @uses    __
	 * @uses    _n
	 * @uses    number_format_i18n
	 *
	 * @version 1.4
	 * @date    April 11, 2015
	 * Added `number_format_i18n` to better accommodate locale based values
	 */
	function trackbacks_only_tab() {

		global $wp_query;

		$trackbacks_only = $wp_query->comments_by_type['trackback'];

		if ( ! empty( $trackbacks_only ) ) { ?>

			<li id="trackbacks-only-tab">
				<a href="#trackbacks-only">
					<h3 id="trackbacks">
						<?php
						printf(
							_n(
								__( '%1$s Trackback', 'opus-primus' ),
								__( '%1$s Trackbacks', 'opus-primus' ),
								count( $trackbacks_only )
							),
							number_format_i18n( count( $trackbacks_only ) )
						); ?>
					</h3><!-- #trackbacks -->
				</a>
			</li><!-- #trackbacks-only-tab -->

		<?php }

	}


	/**
	 * Comments Only Panel
	 *
	 * Displays only those comments of type: comment
	 *
	 * @package OpusPrimus
	 * @since   1.1.1
	 *
	 * @uses    OpusPrimusNavigation::comments_navigation
	 * @uses    WP_Query::comments_by_type
	 * @uses    get_option
	 * @uses    wp_list_comments
	 */
	function comments_only_panel() {

		global $wp_query;

		$comments_only = $wp_query->comments_by_type['comment'];

		if ( ! empty( $comments_only ) ) { ?>

			<div id="comments-only">
				<ul class="comments-list">
					<?php wp_list_comments( 'type=comment' ); ?>
				</ul>
				<!-- comments-list -->
				<?php
				if ( get_option( 'comments_per_page' ) < count( $comments_only ) ) {
					$opus_navigation = OpusPrimusNavigation::create_instance();
					$opus_navigation->comments_navigation();
				} ?>
			</div><!-- #comments-only -->

		<?php }

	}


	/**
	 * Pingbacks Only Panel
	 *
	 * Displays only those comments of type: pingback
	 *
	 * @package OpusPrimus
	 * @since   1.1.1
	 *
	 * @uses    OpusPrimusNavigation::comments_navigation
	 * @uses    WP_Query::comments_by_type
	 * @uses    get_option
	 * @uses    wp_list_comments
	 */
	function pingbacks_only_panel() {

		global $wp_query;

		$pingbacks_only = $wp_query->comments_by_type['pingback'];

		if ( ! empty( $pingbacks_only ) ) { ?>

			<div id="pingbacks-only">
				<ul class="pingbacks-list">
					<?php wp_list_comments( 'type=pingback' ); ?>
				</ul>
				<!-- pingbacks-list -->
				<?php
				if ( get_option( 'comments_per_page' ) < count( $pingbacks_only ) ) {
					$opus_navigation = OpusPrimusNavigation::create_instance();
					$opus_navigation->comments_navigation();
				} ?>
			</div><!-- #pingbacks-only -->

		<?php }

	}


	/**
	 * Trackbacks Only Panel
	 *
	 * Displays only those comments of type: trackback
	 *
	 * @package OpusPrimus
	 * @since   1.1.1
	 *
	 * @uses    OpusPrimusNavigation::comments_navigation
	 * @uses    WP_Query::comments_by_type
	 * @uses    get_option
	 * @uses    wp_list_comments
	 */
	function trackbacks_only_panel() {

		global $wp_query;

		$trackbacks_only = $wp_query->comments_by_type['trackback'];

		if ( ! empty( $trackbacks_only ) ) { ?>

			<div id="trackbacks-only">
				<ul class="trackbacks-list">
					<?php wp_list_comments( 'type=trackback' ); ?>
				</ul>
				<!-- trackbacks-list -->
				<?php
				if ( get_option( 'comments_per_page' ) < count( $trackbacks_only ) ) {
					$opus_navigation = OpusPrimusNavigation::create_instance();
					$opus_navigation->comments_navigation();
				} ?>
			</div><!-- #trackbacks-only -->

		<?php }

	}


	/**
	 * All Comments Count
	 *
	 * Calculates total comments by adding the totals of each of the comment
	 * types: comment, pingback, and trackback
	 *
	 * @package OpusPrimus
	 * @since   1.1.1
	 *
	 * @uses    WP_Query::comments_by_type
	 *
	 * @return  string
	 */
	function all_comments_count() {

		global $wp_query;

		$comments_only   = intval( count( $wp_query->comments_by_type['comment'] ) );
		$pingbacks_only  = intval( count( $wp_query->comments_by_type['pingback'] ) );
		$trackbacks_only = intval( count( $wp_query->comments_by_type['trackback'] ) );

		/** @var $all_comments - initialize comments counter */
		$all_comments = 0;
		/**
		 * To remove a comment type count simply comment out or remove the
		 * appropriate line. This will affect the value passed to the method
		 * used to display the value.
		 * NB: This would be best done via a Child-Theme.
		 */
		$all_comments = $all_comments + $comments_only;
		$all_comments = $all_comments + $pingbacks_only;
		$all_comments = $all_comments + $trackbacks_only;

		return $all_comments;

	}


	/**
	 * Show All Comments Count
	 *
	 * Displays the `all_comments_count` value
	 *
	 * @package OpusPrimus
	 * @since   1.1.1
	 *
	 * @uses    OpusPrimusComments::all_comments_count
	 * @USES    __
	 * @uses    _n
	 * @uses    do_action
	 * @uses    number_format_i18n
	 *
	 * @version 1.4
	 * @date    April 11, 2015
	 * Added `number_format_i18n` to better accommodate locale based values
	 */
	function show_all_comments_count() {

		/** Add empty hook before all comments count */
		do_action( 'opus_all_comments_count_before' );

		/** Get the total from `all_comments_count` */
		$total_comments = $this->all_comments_count();

		/** Check if there are any comments */
		if ( $total_comments > 0 ) {
			$show_all_comments_count = sprintf( _n( __( '%s Response', 'opus-primus' ), __( '%s Responses', 'opus-primus' ), $total_comments ), number_format_i18n( $total_comments ) );
		} else {
			$show_all_comments_count = __( 'No Responses', 'opus-primus' );
		}

		/** Display the total comments message */
		echo $show_all_comments_count;

		/** Add empty hook after all comments count */
		do_action( 'opus_all_comments_count_after' );

	}


}