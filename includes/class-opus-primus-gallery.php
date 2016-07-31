<?php
/**
 * Opus Primus Gallery
 *
 * Gallery and other related image functionality
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
 * Class Opus Primus Gallery
 *
 * Used to manage the default gallery displays in the Opus Primus WordPress theme
 *
 * @version     1.0.1
 * @date        February 21, 2013
 * Re-order methods: alphabetical
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 *
 * @version     1.4
 * @date        April 5, 2015
 * Change `Opus_Primus_Gallery` to a singleton style class
 */
class Opus_Primus_Gallery {

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
	 * @return null|Opus_Primus_Gallery
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
	 * Opus Primus Featured Image
	 *
	 * If a featured image is assigned then return it's ID; wrap it in anchor
	 * tags if not in the single view, otherwise just output the picture itself
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string $size thumbnail|medium|large|full (default WordPress image sizes).
	 *
	 * @see     Opus_Primus_Gallery::get_gallery_attr_featured_ids
	 * @see     (GLOBAL) $opus_thumb_id
	 * @see     __
	 * @see     do_action
	 * @see     esc_html
	 * @see     get_children
	 * @see     get_permalink
	 * @see     get_post_thumbnail_id
	 * @see     get_the_ID
	 * @see     has_post_thumbnail
	 * @see     is_single
	 * @see     the_post_thumbnail
	 * @see     the_title_attribute
	 * @see     wp_get_attachment_image
	 *
	 * @version 1.2.3
	 * @date    February 2, 2014
	 * Moved `featured_image` wrapper into method
	 *
	 * @todo    Review hooks and when they they should be usable.
	 */
	function featured_image( $size = 'large' ) {

		global $opus_thumb_id;

		/** Show Featured Image when not in single view */
		if ( ! is_single() ) {

			/** Add CSS Wrapper */
			echo '<div class="gallery-featured-image">';

			/** Add empty hook before featured image */
			do_action( 'opus_featured_image_before' );

			/**
			 * Standard WordPress image size; large as the intent is to use as
			 * the featured image for gallery posts
			 */
			if ( has_post_thumbnail() ) {

				/** Use the thumbnail ("featured image") */
				$opus_thumb_id = get_post_thumbnail_id();

				if ( ! is_single() ) {

					echo esc_html( '<p class="featured-image has-post-thumbnail"><a href="' . get_permalink() . '" title="' . the_title_attribute(
							array(
								'before' => __( 'View', 'opus-primus' ) . ' ',
								'after'  => ' ' . __( 'only', 'opus-primus' ),
								'echo'   => '0',
							)
						) . '">' );
					the_post_thumbnail( $size );
					echo '</a></p>';

				} else {

					the_post_thumbnail( $size );

				}
			} else {

				$attachments = get_children(
					array(
						'post_parent'    => get_the_ID(),
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'order'          => 'ASC',
						'orderby'        => 'menu_order ID',
						'numberposts'    => 1,
					)
				);

				/**
				 * If there are no attachments then use a random(?) image from
				 * the gallery
				 */
				if ( empty( $attachments ) ) {

					$opus_thumb_id = intval( $this->get_gallery_attr_featured_ids() );

					if ( ! is_single() ) {

						echo esc_html( '<p class="featured-image no-attachments"><a href="'
						               . get_permalink()
						               . '" title="' . the_title_attribute( array(
									'before' => __( 'View', 'opus-primus' ) . ' ',
									'after'  => ' ' . __( 'only', 'opus-primus' ),
									'echo'   => '0',
								)
						               )
						               . '">'
						               . wp_get_attachment_image( $opus_thumb_id, $size )
						               . '</a></p>'
						);

					} else {

						echo wp_get_attachment_image( $opus_thumb_id, $size );

					}
				} else {

					foreach ( $attachments as $opus_thumb_id => $attachment ) {

						if ( ! is_single() ) {

							echo esc_html( '<p class="featured-image no-post-thumbnail"><a href="'
							               . get_permalink()
							               . '" title="' . the_title_attribute( array(
										'before' => __( 'View', 'opus-primus' ) . ' ',
										'after'  => ' ' . __( 'only', 'opus-primus' ),
										'echo'   => '0',
									)
							               )
							               . '">'
							               . wp_get_attachment_image( $opus_thumb_id, $size )
							               . '</a></p>'
							);

						} else {

							echo wp_get_attachment_image( $opus_thumb_id, $size );

						}
					}
				}
			}

			/** Add empty hook after featured image */
			do_action( 'opus_featured_image_after' );

			/** Close CSS Wrapper */
			echo '</div><!-- gallery-featured-image -->';

		}

	}


	/**
	 * Get Gallery Shortcode Attribute Featured ids
	 *
	 * Using the shortcode regex find the attributes for the gallery shortcode
	 * and identify the values used in the ids parameter. If the ids parameter
	 * is used then store the values in an array ... and carry on ...
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     get_shortcode_regex
	 * @see     get_the_content
	 * @see     shortcode_parse_atts
	 *
	 * @return  null|int - array index value
	 *
	 * @version 1.2.2
	 * @date    September 3, 2013
	 * Add sanity check to make sure match variable is actually set
	 *
	 * @version 1.3
	 * @date    October 3, 2014
	 * Update to use `preg_match_all`
	 */
	function get_gallery_attr_featured_ids() {

		/** Holds the regex pattern used to check shortcode */
		$pattern = get_shortcode_regex();

		/** Find any shortcode being used in post */
		preg_match_all( '/' . $pattern . '/s', get_the_content(), $matches );

		/** Find the gallery shortcode usages after a sanity check */
		if ( isset( $matches[2] ) && ( 'gallery' === $matches[2] ) ) {

			/** Holds the gallery shortcode parameters used */
			$attrs = shortcode_parse_atts( $matches[3] );

			/** Array of image ids used */
			$images = isset( $attrs['ids'] ) ? explode( ',', $attrs['ids'] ) : false;

			/**
			 * If there are no images carry on; otherwise, return the first
			 * image index [0] as this is what the end-user would have chosen
			 * first as well.
			 */
			if ( $images ) {
				return $images[0];
			}
		}

		/** Keeping the return Gods happy - won't likely ever get here. */

		return null;

	}


	/**
	 * Get Gallery Shortcode Attribute Secondary ids
	 *
	 * Using the shortcode regex find the attributes for the gallery shortcode
	 * and identify the values used in the ids parameter. If the ids parameter
	 * is used then store the values in an array ... and carry on ...
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Gallery::get_gallery_attr_featured_ids
	 * @see     get_shortcode_regex
	 * @see     get_the_content
	 * @see     shortcode_parse_atts
	 *
	 * @return  array
	 *
	 * @version 1.2.2
	 * @date    September 3, 2013
	 * Add sanity check to make sure match variable is actually set
	 *
	 * @version 1.3
	 * @date    October 3, 2014
	 * Update to use `preg_match_all`
	 */
	function get_gallery_attr_secondary_ids() {

		/** Holds the regex pattern used to check shortcode */
		$pattern = get_shortcode_regex();

		/** Find any shortcode being used in post */
		preg_match_all( '/' . $pattern . '/s', get_the_content(), $matches );

		/** Find the gallery shortcode usages after a sanity check */
		if ( isset( $matches[2] ) && ( 'gallery' === $matches[2] ) ) {

			/** Holds the gallery shortcode parameters used */
			$attrs = shortcode_parse_atts( $matches[3] );

			/** Array of image ids used */
			$images = isset( $attrs['ids'] ) ? explode( ',', $attrs['ids'] ) : false;

			/**
			 * If there are no images carry on; otherwise, return the "ids"
			 * parameter values (less the featured image "ids" value) in a
			 * string to be used as the array elements for the query when no
			 * images are attached to the post.
			 */
			if ( $images ) {
				/** Initialize string to empty */
				$string = '';

				/** Loop through images getting their ids value */
				foreach ( $images as $image ) {
					/** If image has the featured image "ids" do not include */
					if ( intval( $image ) !== intval( $this->get_gallery_attr_featured_ids() ) ) {
						$string .= intval( $image ) . ',';
					}
				}

				/**
				 * Cleaned version of string to be returned. Used as `post__in`
				 * parameter value when no images are attached to the post
				 */
				$string = explode( ',', substr( $string, 0, strlen( $string ) - 1 ) );

				return $string;

			}
		}

		/** Keeping the return Gods happy - won't likely ever get here. */

		return null;

	}


	/**
	 * Opus Primus Secondary Images
	 *
	 * Displays additional images from the gallery while excluding the image
	 * with ID = $opus_thumb_id
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     (CONSTANT) OPUS_NUMBER_OF_SECONDARY_IMAGES
	 * @see     (GLOBAL) $opus_thumb_id
	 * @see     WP_Query
	 * @see     apply_filters
	 * @see     do_action
	 * @see     get_permalink
	 * @see     get_the_ID
	 * @see     is_single
	 * @see     number_format_i18n
	 * @see     the_title_attribute
	 * @see     wp_get_attachment_image
	 * @see     wp_parse_args
	 *
	 * @param   array|string $secondary_images_args arguments used to display images.
	 *
	 * @version 1.2.5
	 * @date    July 20, 2014
	 * Changed call to `$opus_defaults->number_of_secondary_images` to use `OPUS_NUMBER_OF_SECONDARY_IMAGES` constant
	 *
	 * @version 1.4
	 * @date    April 11, 2015
	 * Added `number_format_i18n` to better accommodate locale based values
	 */
	function secondary_images( $secondary_images_args = '' ) {

		global $opus_thumb_id;

		/** Set defaults */
		$defaults              = array(
			'order'   => 'ASC',
			'orderby' => 'menu_order ID',
			'images'  => OPUS_NUMBER_OF_SECONDARY_IMAGES,
		);
		$secondary_images_args = wp_parse_args( (array) $secondary_images_args, $defaults );

		/** Holds the regex pattern used to check shortcode */
		$pattern = get_shortcode_regex();

		/** Find any shortcode being used in post */
		preg_match( "/$pattern/s", get_the_content(), $match );

		/** Find the gallery shortcode usages after a sanity check */
		if ( isset( $match[2] ) && ( 'gallery' === $match[2] ) ) {

			/** Add empty hook before secondary images */
			do_action( 'opus_secondary_images_before' );

			/** Object to hold images attached to post */
			$images = new WP_Query(
				array(
					'post_parent'            => get_the_ID(),
					'post_status'            => 'inherit',
					'post_type'              => 'attachment',
					'post_mime_type'         => 'image',
					'order'                  => $secondary_images_args['order'],
					'orderby'                => $secondary_images_args['orderby'],
					'posts_per_page'         => $secondary_images_args['images'],
					'post__not_in'           => array( $opus_thumb_id ),
					'update_post_term_cache' => false,
				)
			);

			/**
			 * No images attached to post? Rerun query using actual "ids" values
			 */
			if ( 0 === $images->found_posts ) {

				$images = new WP_Query(
					array(
						'post__in'               => $this->get_gallery_attr_secondary_ids(),
						'post_status'            => 'inherit',
						'post_type'              => 'attachment',
						'post_mime_type'         => 'image',
						'order'                  => $secondary_images_args['order'],
						'orderby'                => $secondary_images_args['orderby'],
						'posts_per_page'         => $secondary_images_args['images'],
						'post__not_in'           => array( $opus_thumb_id ),
						'update_post_term_cache' => false,
					)
				);

			}

			/** Do not display default gallery if not in single view */
			if ( ! is_single() ) {
				add_filter( 'post_gallery', 'opus_primus_return_blank' );
			}

			/**
			 * Standard WordPress image size; using thumbnail in this case as
			 * the intent is to use these images as additional from gallery
			 */
			$size = 'thumbnail';

			/** Only display when not in single view */
			if ( ! is_single() ) {

				/** Wrap the output in its own DIV */
				echo '<div class="gallery-secondary-images">';

				/**
				 * Cycle through images and display them linked to their permalink
				 */
				foreach ( $images->posts as $image ) {
					echo esc_html( '<a href="' . get_permalink( $image->ID ) . '">' . wp_get_attachment_image( $image->ID, $size ) . '</a>' );
				}

				/**
				 * Display a message indicating if more images are in the
				 * gallery than what are displayed in the post stream. If more
				 * images are in the gallery the text showing how many more will
				 * link to the single post
				 */
				if ( ( $images->found_posts + 1 ) > ( $secondary_images_args['images'] + 1 ) ) {

					echo esc_html(
						sprintf( '<p class="more-images">%1$s</p>',
							apply_filters(
								'opus_more_images_text',
								sprintf(
									_n(
										__( 'There is %2$s%1$s more image%3$s in addition to these in the gallery.', 'opus-primus' ),
										__( 'There are %2$s%1$s more images%3$s in addition to these in the gallery.', 'opus-primus' ),
										( $images->found_posts + 1 ) - ( $secondary_images_args['images'] + 1 )
									),
									number_format_i18n( ( $images->found_posts + 1 ) - ( $secondary_images_args['images'] + 1 ) ),
									'<a href="' . get_permalink() . '" title="' . the_title_attribute(
										array(
											'before' => __( 'View', 'opus-primus' ) . ' ',
											'after'  => ' ' . __( 'only', 'opus-primus' ),
											'echo'   => '0',
										)
									) . '">',
									'</a>'
								)
							)
						)
					);

				}

				/** Close wrapping DIV element */
				echo '</div><!-- gallery-secondary-images -->';

			}

			/** Add empty hook after secondary images */
			do_action( 'opus_secondary_images_after' );

		}

	}
}
