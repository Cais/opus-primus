<?php
/**
 * Opus Primus Authors
 *
 * Controls for the organization and layout of the author sections of the site.
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
 */

/**
 * Class Opus Primus Authors
 *
 * Used for constructs related to authors in the Opus Primus WordPress theme
 *
 * @version     1.2
 * @date        April 17, 2013
 * Added `get_author_description` method
 *
 * @version     1.4
 * @date        April 24, 2015
 * Added `Share the Author Wealth` method, not implemented as a display element
 * Change `Opus_Primus_Authors` to a singleton style class
 */
class Opus_Primus_Authors {

	/**
	 * Set the instance to null initially
	 *
	 * @var $instance null
	 */
	private static $instance = null;

	/**
	 * Create Instance
	 *
	 * Creates a single instance of the class
	 *
	 * @package OpusPrimus
	 * @since   1.4
	 * @date    April 5, 2015
	 *
	 * @return null|Opus_Primus_Authors
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}


	/**
	 * Constructor
	 */
	function __construct() {
	}


	/**
	 * Author Classes
	 *
	 * Additional author classes related to the use and their capabilities
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @param   int $author_id author ID used for referencing role.
	 *
	 * @see        get_the_author_meta
	 * @see        sanitize_html_class
	 * @see        user_can
	 *
	 * @version    1.2.5
	 * @date       July 24, 2014
	 * Replaced `Opus_Primus_Structures::replace_spaces` with `sanitize_html_class`
	 */
	function author_classes( $author_id ) {

		/**
		 * Add class as related to the user role
		 * - see 'Role:' drop-down in User options
		 */
		if ( user_can( $author_id, 'administrator' ) ) {
			echo 'administrator';
		} elseif ( user_can( $author_id, 'editor' ) ) {
			echo 'editor';
		} elseif ( user_can( $author_id, 'contributor' ) ) {
			echo 'contributor';
		} elseif ( user_can( $author_id, 'subscriber' ) ) {
			echo 'subscriber';
		} else {
			echo 'guest';
		}

		/** Check if this is the first user */
		if ( ( '1' === $author_id ) ) {
			echo ' administrator-prime';
		}

		echo ' author-' . sanitize_html_class( $author_id );
		echo ' author-' . sanitize_html_class( get_the_author_meta( 'display_name', $author_id ), 'noah-body' );

	}


	/**
	 * Author Coda
	 *
	 * Adds text art after the author details to signify the end of the output
	 * block
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     apply_filters
	 * @see     do_action
	 * @see     esc_html
	 */
	function author_coda() {

		/** Add empty hook before post coda */
		do_action( 'opus_author_coda_before' );

		/** Create the text art */
		$author_coda = '|=|=|=|=|';
		echo sprintf( '<div class="author-coda">%1$s</div>', esc_html( apply_filters( 'opus_author_coda', $author_coda ) ) );

		/** Add empty hook after the post coda */
		do_action( 'opus_author_coda_after' );

	}


	/**
	 * Get Author Description
	 *
	 * Returns the author description from the user profile. This will also
	 * shorten the User Description  / Biography if the length is greater
	 * than 140 characters and it is not being shown on an author page. The
	 * description will also be shortened on author archive pages after the
	 * first page.
	 *
	 * @package OpusPrimus
	 * @since   1.2
	 *
	 * @param   int $author_id author ID used as reference for the author description.
	 *
	 * @see     (GLOBAL) $paged
	 * @see     apply_filters()
	 * @see     esc_attr()
	 * @see     get_the_author_meta()
	 * @see     home_url()
	 * @see     is_author()
	 *
	 * @return  string
	 */
	function get_author_description( $author_id ) {

		global $paged;

		/** Default string to be returned */
		$user_desc = get_the_author_meta( 'user_description', $author_id );

		/**
		 * Shorten the description and add an ellipsis and the infinity symbols.
		 */
		if ( ( ! is_author() && ( strlen( $user_desc ) > 140 ) ) || ( is_author() && ( $paged > 1 ) ) ) {

			/** Filtered character count value */
			$characters = apply_filters( 'opus_author_description_excerpt_length', '139' );

			/** Sanity check - make sure we are dealing with an integer */
			if ( ! is_int( $characters ) ) {
				$characters = 139;
			}

			/** Manipulated string */
			$user_desc = substr( $user_desc, 0, intval( $characters ) )
			             . apply_filters( 'opus_author_description_excerpt_extender', '&hellip;' )
			             . apply_filters(
				             'opus_author_description_excerpt_link',
				             sprintf(
					             '<span class="opus-author-about">%1$s</span>',
					             sprintf(
						             '<span class="author-url"><a class="archive-url" href="%1$s" title="%2$s">%3$s</a></span>',
						             home_url( '/?author=' . $author_id ),
						             esc_attr(
							             sprintf(
								             __( 'View the full biography ... and all posts by %1$s', 'opus-primus' ),
								             get_the_author_meta( 'display_name', $author_id )
							             )
						             ),
						             '&infin;'
					             )
				             )
			             );

		}

		return $user_desc;

	}


	/**
	 * Author Details
	 *
	 * Takes the passed author ID parameter and creates / collects various
	 * details to be used when outputting author information, by default,
	 * at the end of the post or page single view.
	 *
	 * @package    OpusPrimus
	 * @since      0.1
	 *
	 * @param int    $author_id         from the `post_author` method.
	 * @param string $show_author_url   boolean - default: true.
	 * @param string $show_author_email boolean - default: true.
	 * @param string $show_author_desc  boolean - default: true.
	 *
	 * @see        Opus_Primus_Authors::author_classes
	 * @see        Opus_Primus_Authors::get_author_description
	 * @see        antispambot
	 * @see        esc_attr
	 * @see        esc_html
	 * @see        esc_url
	 * @see        get_avatar
	 * @see        get_the_author_meta
	 * @see        home_url
	 * @see        sanitize_email
	 * @see        user_can
	 *
	 * @version    1.1
	 * @date       March 7, 2013
	 * Added classes to `h2`, `ul`, and `li` elements
	 *
	 * @version    1.2.5
	 * @date       June 5, 2014
	 * Added `antispambot` email protection
	 */
	function author_details( $author_id, $show_author_url, $show_author_email, $show_author_desc ) {

		/** Collect details from the author's profile */
		$author_display_name = get_the_author_meta( 'display_name', $author_id );
		$author_url          = get_the_author_meta( 'user_url', $author_id );
		$author_email        = antispambot( get_the_author_meta( 'user_email', $author_id ) );
		$author_desc         = $this->get_author_description( $author_id );

		/** Add empty hook before author details */
		do_action( 'opus_author_details_before' ); ?>

		<div class="author-details <?php $this->author_classes( $author_id ); ?>">

			<h2 class="opus-author-details-header">
				<?php
				/** Sanity check - an author id should always be present */
				if ( ! empty( $author_id ) ) {
					echo get_avatar( $author_id );
				}

				printf(
					'<span class="opus-author-about">%1$s</span>',
					sprintf(
						'<span class="author-url"><a class="archive-url" href="%1$s" title="%2$s">%3$s</a></span>',
						esc_url( home_url( '/?author=' . $author_id ) ),
						esc_attr( sprintf( __( 'View all posts by %1$s', 'opus-primus' ), $author_display_name ) ),
						esc_html( $author_display_name )
					)
				); ?>
			</h2><!-- opus-author-details-header -->

			<ul class="opus-author-detail-items">

				<?php
				/**
				 * Check for the author URL; if show Author URL is true; and,
				 * show Author email is true
				 */
				if ( ! empty( $author_url ) && $show_author_url && $show_author_email ) { ?>

					<li class="opus-author-contact">
						<?php
						printf(
							'<span class="opus-author-contact-text">' . esc_html__( 'Visit the web site of %1$s or email %2$s.', 'opus-primus' ) . '</span>',
							'<a class="opus-author-url" href="' . esc_url( $author_url ) . '">' . esc_html( $author_display_name ) . '</a>',
							'<a class="opus-author-email" href="mailto:' . esc_attr( sanitize_email( $author_email ) ) . '">' . esc_html( $author_display_name ) . '</a>'
						); ?>
					</li><!-- opus-author-contact -->

					<?php
					/**
					 * Check for the author URL; show Author URL is true; and,
					 * show Author email is false
					 */
				} elseif ( ! empty( $author_url ) && $show_author_url && ! $show_author_email ) { ?>

					<li class="opus-author-contact">
						<?php
						printf(
							'<span class="opus-author-contact-text">' . esc_html( __( 'Visit the web site of %1$s.', 'opus-primus' ) ) . '</span>',
							'<a class="opus-author-url" href="' . esc_url( $author_url ) . '">' . esc_html( $author_display_name ) . '</a>'
						); ?>
					</li><!-- opus-author-contact -->

					<?php
					/**
					 * Check for the author URL; show Author URL is false; and,
					 * show Author email is true
					 */
				} elseif ( ! empty( $author_url ) && ! $show_author_url && $show_author_email ) { ?>

					<li class="opus-author-contact">
						<?php
						printf(
							'<span class="opus-author-contact-text">' . esc_html__( 'Email: %1$s.', 'opus-primus' ) . '</span>',
							'<a class="opus-author-email" href="mailto:' . esc_attr( sanitize_email( $author_email ) ) . '">' . esc_html( $author_display_name ) . '</a>'
						); ?>
					</li><!-- opus-author-contact -->

					<?php
					/**
					 * The last option available in this logic chain: no Author
					 * URL and show Author email is true
					 */
				} elseif ( $show_author_email ) { ?>

					<li class="opus-author-contact">
						<?php
						printf(
							'<span class="opus-author-contact-text">' . esc_html__( 'Email: %1$s.', 'opus-primus' ) . '</span>',
							'<a class="opus-author-email" href="mailto:' . esc_url( $author_email ) . '">' . esc_html( $author_display_name ) . '</a>'
						); ?>
					</li><!-- opus-author-contact -->

				<?php }

				/**
				 * Check for the author bio; and, if show Author Desc is true
				 */
				if ( ! empty( $author_desc ) && $show_author_desc ) { ?>

					<li class="opus-author-biography">
						<?php
						printf(
							'<span class="opus-author-biography-text">' . esc_html__( 'Biography: %1$s', 'opus-primus' ) . '</span>',
							esc_html( $author_desc )
						); ?>
					</li><!-- opus-author-biography -->

				<?php } ?>

			</ul>
			<!-- opus-author-detail-items -->

		</div><!-- author details -->

		<?php
		/** Add empty hook after author details */
		do_action( 'opus_author_details_after' );

		return;

	}


	/**
	 * Share the Author Wealth
	 *
	 * Displays a list of all site authors with published posts
	 *
	 * @package     OpusPrimus
	 * @since       1.4
	 *
	 * @see         esc_html
	 * @see         is_multi_author
	 * @see         wp_list_authors
	 *
	 * @param bool $echo default = true to display authors.
	 *
	 * @return null|string
	 */
	function share_the_author_wealth( $echo = true ) {

		$author_args = array(
			'optioncount'   => true,
			'show_fullname' => true,
			'echo'          => false,
		);

		if ( is_multi_author() ) {
			$output = wp_list_authors( $author_args );
		} else {
			$output = null;
		}

		/** Wrapped in ul element */
		$output = '<ul class="authors-list">' . $output . '</ul><!-- authors-list -->';

		/** Last chance to change content with a hook */
		$output = apply_filters( 'opus_authors_list', $output );

		if ( true === $echo ) {
			echo esc_html( $output );
		} else {
			return $output;
		}

		return null;

	}


	/**
	 * Post Author
	 *
	 * Outputs the author details: web address, email, and biography from the
	 * user profile information - not designed for use in the post meta section.
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   array $post_author_args the arguments for the options to be used.
	 *
	 * @see     (GLOBAL) $opus_author_id - from Opus_Primus_Posts::post_byline
	 * @see     (GLOBAL) $post
	 * @see     Opus_Primus_Authors::author_coda
	 * @see     Opus_Primus_Authors::author_details
	 * @see     apply_filters
	 * @see     do_action
	 * @see     get_post_meta
	 * @see     get_the_date
	 * @see     get_the_modified_date
	 * @see     wp_parse_args
	 */
	function post_author( $post_author_args ) {

		/** Defaults */
		$defaults         = array(
			'display_mod_author'   => true,
			'display_author_url'   => true,
			'display_author_email' => true,
			'display_author_desc'  => true,
		);
		$post_author_args = wp_parse_args( (array) $post_author_args, $defaults );

		/** Get global variables for the author ID and the post object */
		global $opus_author_id, $post;
		if ( ! isset( $opus_author_id ) ) {
			$opus_author_id = '';
		}

		/** Add empty hook before post author section */
		do_action( 'opus_post_author_top' );

		/** Add empty hook before first author details */
		do_action( 'opus_author_details_before' );

		/** Output author details */
		echo '<div class="first-author-details">';
		echo sprintf(
			'<div class="first-author-details-text">%1$s</div><!-- .first-author-details-text -->',
			esc_html( apply_filters(
				'opus_first_author_by_text',
				__( 'Author:', 'opus-primus' )
			) )
		);
		$this->author_details( $opus_author_id, $post_author_args['display_author_url'], $post_author_args['display_author_email'], $post_author_args['display_author_desc'] );
		echo '</div><!-- .first-author-details -->';
		$this->author_coda();

		/** Add empty hook after first author details */
		do_action( 'opus_author_details_after' );

		/** Modified Author Details */
		/** Set last user ID */
		$last_id = get_post_meta( $post->ID, '_edit_last', true );

		/**
		 * If the modified dates are different; and, the modified author is not
		 * the same as the original author; and, showing the modified author is
		 * set to true
		 */
		if ( ( get_the_date() !== get_the_modified_date() ) && ( $opus_author_id !== $last_id ) && $post_author_args['display_mod_author'] ) {

			/** Add empty hook before modified author details */
			do_action( 'opus_modified_author_details_before' );

			/** Output author details based on the last one to edit the post */
			echo '<div class="modified-author-details">';
			echo sprintf(
				'<div class="modified-author-details-text">%1$s</div><!-- modified-author-details-text -->',
				esc_html( apply_filters(
					'opus_modified_author_by_text',
					__( 'Modified by:', 'opus-primus' )
				) )
			);
			$this->author_details( $last_id, $post_author_args['display_author_url'], $post_author_args['display_author_email'], $post_author_args['display_author_desc'] );
			echo '</div><!-- .modified-author-details -->';
			$this->author_coda();

			/** Add empty hook after modified author details */
			do_action( 'opus_modified_author_details_after' );

		}

		/** Add empty hook after post author section */
		do_action( 'opus_post_author_bottom' );

	}
}
