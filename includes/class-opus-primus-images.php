<?php
/**
 * Opus Primus Images
 *
 * Image related functionality
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
 * Class Opus Primus Images
 *
 * Handles the image elements of the Opus Primus WordPress theme
 *
 * @version     1.3.1
 * @date        Rare Disease Day 2015
 * Removed extraneous end of structure comments
 *
 * @version     1.4
 * @date        April 5, 2015
 * Change `Opus_Primus_Archives` to a singleton style class
 */
class Opus_Primus_Images {

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
	 * @return null|Opus_Primus_Images
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}


	/** Construct */
	function __construct() {
	}


	/**
	 * Opus Primus Archive Image Details
	 *
	 * Outputs details of the attached image, if they exist
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string $size standard WordPress post_thumbnail sizes / or custom defined sizes can be used.
	 *
	 * @see     Opus_Primus_Images::first_linked_image
	 * @see     __
	 * @see     apply_filters
	 * @see     esc_html
	 * @see     get_children
	 * @see     get_permalink
	 * @see     get_the_ID
	 * @see     is_single
	 * @see     the_title_attribute
	 * @see     wp_get_attachment_image
	 *
	 * @todo    Address $archive_image message(s) once `first_linked_image` is sorted out (1.2)
	 * @todo    Address CSS aesthetics on images not attached ... or find a way to display the post excerpt details (much better choice!) (1.2)
	 *
	 * @version 1.2
	 * @date    April 11, 2013
	 * Added `opus_archive_image_title` filter
	 * Added `opus_archive_image_excerpt` filter
	 * Added `opus_archive_image_content` filter
	 */
	function archive_image_details( $size = 'medium' ) {

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

		/** Set initial string values */
		$archive_image         = '<p class="archive-image">' . __( 'The Image archive looks much better if the image is set as an attachment of the post.', 'opus-primus' ) . '</p>';
		$archive_image_title   = '';
		$archive_image_excerpt = '';
		$archive_image_content = '';

		if ( empty( $attachments ) ) {
			$archive_image = $this->first_linked_image();
		}

		foreach ( $attachments as $opus_thumb_id => $attachment ) {
			$archive_image         = wp_get_attachment_image( $opus_thumb_id, $size );
			$archive_image_title   = $attachment->post_title;
			$archive_image_excerpt = $attachment->post_excerpt;
			$archive_image_content = $attachment->post_content;
		} ?>

		<table>

			<thead>

				<?php if ( ! empty( $archive_image_title ) ) { ?>
					<tr>
						<th>
							<?php printf(
								'<span class="archive-image-title">%1$s</span>',
								esc_html( apply_filters( 'opus_archive_image_title', sprintf( __( 'Image Title: %1$s', 'opus-primus' ), $archive_image_title ) ) )
							); ?>
						</th>
					</tr>
				<?php } ?>

			</thead>

			<tbody>
				<tr>
					<td class="archive-image">
						<?php
						if ( ! is_single() ) {
							echo '<span class="archive-image"><a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( the_title_attribute( array(
									'before' => __( 'View', 'opus-primus' ) . ' ',
									'after'  => ' ' . __( 'only', 'opus-primus' ),
									'echo'   => '0',
							) ) ) . '">' . esc_url( $archive_image ) . '</a></span>';
						} ?>
					</td>
				</tr>
				<tr>
					<?php
					if ( ! empty( $archive_image_excerpt ) ) {
						printf( '<td class="archive-image-excerpt">%1$s</td>', esc_html( apply_filters( 'opus_archive_image_excerpt', sprintf( __( 'Image Caption: %1$s', 'opus-primus' ), $archive_image_excerpt ) ) ) );
					} ?>
				</tr>
				<tr>
					<?php
					if ( ! empty( $archive_image_content ) ) {
						printf(
							'<td class="archive-image-content">%1$s</td>',
							esc_html( apply_filters( 'opus_archive_image_content', sprintf( __( 'Image Description: %1$s', 'opus-primus' ), $archive_image_content ) ) )
						);
					} ?>
				</tr>
			</tbody>

		</table>

	<?php }


	/**
	 * Opus Primus Display EXIF Box
	 *
	 * Outputs the EXIF data using a box-model (read: div container)
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @see      Opus_Primus_Images::exif_aperture
	 * @see      Opus_Primus_Images::exif_camera
	 * @see      Opus_Primus_Images::exif_caption
	 * @see      Opus_Primus_Images::exif_copyright
	 * @see      Opus_Primus_Images::exif_dimensions
	 * @see      Opus_Primus_Images::exif_focal_length
	 * @see      Opus_Primus_Images::exif_iso_speed
	 * @see      Opus_Primus_Images::exif_shutter
	 * @see      Opus_Primus_Images::exif_timestamp
	 * @see      Opus_Primus_Images::exif_title
	 * @see      __
	 * @see      apply_filters
	 * @see      do_action
	 * @see      esc_html
	 *
	 * @internal see display_exif_table for tabular output
	 *
	 * @version  1.2
	 * @date     April 12, 2013
	 * Added `opus_exif_*_label` filters for all details
	 *
	 * @version  1.2.2
	 * @date     September 12, 2013
	 * Added better i18n structures for EXIF data
	 */
	function display_exif_box() {

		/** Add empty hook before exif box */
		do_action( 'opus_exif_box_before' );

		/** Wrap the exif output in its own container */
		echo '<div class="display-exif-box">';

		/** If the exif value is set display it */
		if ( $this->exif_dimensions() ) {
			echo esc_html( sprintf( '<p class="exif-dimensions">%1$s</p>', $this->exif_dimensions() ) );
		}
		if ( $this->exif_copyright() ) {
			echo esc_html( sprintf( '<p class="exif-copyright">%1$s %2$s</p>', apply_filters( 'opus_exif_copyright_label', __( 'Copyright:', 'opus-primus' ) ), $this->exif_copyright() ) );
		}
		if ( $this->exif_timestamp() ) {
			echo esc_html( sprintf( '<p class="exif-timestamp">%1$s %2$s</p>', apply_filters( 'opus_exif_timestamp_label', __( 'Uploaded:', 'opus-primus' ) ), $this->exif_timestamp() ) );
		}
		if ( $this->exif_camera() ) {
			echo esc_html( sprintf( '<p class="exif-camera">%1$s %2$s</p>', apply_filters( 'opus_exif_camera_label', __( 'Camera:', 'opus-primus' ) ), $this->exif_camera() ) );
		}
		if ( $this->exif_shutter() ) {
			echo esc_html( sprintf( '<p class="exif-shutter">%1$s %2$s</p>', apply_filters( 'opus_exif_shutter_label', __( 'Shutter Speed:', 'opus-primus' ) ), $this->exif_shutter() ) );
		}
		if ( $this->exif_aperture() ) {
			echo esc_html( sprintf( '<p class="exif-aperture">%1$s F%2$s</p>', apply_filters( 'opus_exif_aperture_label', __( 'Aperture:', 'opus-primus' ) ), $this->exif_aperture() ) );
		}
		if ( $this->exif_caption() ) {
			echo esc_html( sprintf( '<p class="exif-caption">%1$s %2$s</p>', apply_filters( 'opus_exif_caption_label', __( 'Caption:', 'opus-primus' ) ), $this->exif_caption() ) );
		}
		if ( $this->exif_focal_length() ) {
			echo esc_html( sprintf( '<p class="exif-focal-length">%1$s %2$s</p>', apply_filters( 'opus_exif_focal_length_label', __( 'Focal Length:', 'opus-primus' ) ), $this->exif_focal_length() ) );
		}
		if ( $this->exif_iso_speed() ) {
			echo esc_html( sprintf( '<p class="exif-iso-speed">%1$s %2$s</p>', apply_filters( 'opus_exif_iso_speed_label', __( 'ISO Speed:', 'opus-primus' ) ), $this->exif_iso_speed() ) );
		}
		if ( $this->exif_title() ) {
			echo esc_html( sprintf( '<p class="exif-title">%1$s %2$s</p>', apply_filters( 'opus_exif_title_label', __( 'Title:', 'opus-primus' ) ), $this->exif_title() ) );
		}

		/** Close display exif box wrapper */
		echo '</div><!-- .display-exif-box -->';

		/** Add empty hook after exif box */
		do_action( 'opus_exif_box_after' );

	}


	/**
	 * Opus Primus Display EXIF Table
	 *
	 * Outputs the EXIF data using a table-model
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @see      Opus_Primus_Images::exif_aperture
	 * @see      Opus_Primus_Images::exif_camera
	 * @see      Opus_Primus_Images::exif_caption
	 * @see      Opus_Primus_Images::exif_copyright
	 * @see      Opus_Primus_Images::exif_dimensions
	 * @see      Opus_Primus_Images::exif_focal_length
	 * @see      Opus_Primus_Images::exif_iso_speed
	 * @see      Opus_Primus_Images::exif_shutter
	 * @see      Opus_Primus_Images::exif_timestamp
	 * @see      Opus_Primus_Images::exif_title
	 * @see      __
	 * @see      apply_filters
	 * @see      do_action
	 *
	 * @version  1.2
	 * @date     April 12, 2013
	 * Added `opus_display_exif_table_header_text` filter
	 * Added `opus_exif_*_label` filters for all details
	 *
	 * @version  1.2.2
	 * @date     September 12, 2013
	 * Corrected i18n code for EXIF data
	 *
	 * @version  1.4.2
	 * @date     2016-07-12
	 * Changed aperture from `F` to `f /`
	 */
	function display_exif_table() {

		/** Add empty hook before exif table */
		do_action( 'opus_exif_table_before' ); ?>

		<!-- Provide a CSS class for the exif output -->
		<table class="display-exif-table">
			<thead>
				<tr>
					<th>
						<?php echo esc_html( sprintf(
							'<span class="display-exif-table-header-text">%1$s</span>',
							apply_filters( 'opus_display_exif_table_header_text', __( 'Image Details', 'opus-primus' ) )
						) ); ?>
					</th>
				</tr>
			</thead>

			<tbody>
				<?php
				/** If the exif value is set display it */
				if ( $this->exif_dimensions() ) {
					echo esc_html( '<tr><td class="exif-dimensions">' . apply_filters( 'opus_exif_dimensions_label', __( 'Dimensions', 'opus-primus' ) ) . '</td><td>' . $this->exif_dimensions() . '</td></tr>' );
				}
				if ( $this->exif_copyright() ) {
					echo esc_html( '<tr><td class="exif-copyright">' . apply_filters( 'opus_exif_copyright_label', __( 'Copyright', 'opus-primus' ) ) . '</td><td>' . $this->exif_copyright() . '</td></tr>' );
				}
				if ( $this->exif_timestamp() ) {
					echo esc_html( '<tr><td class="exif-timestamp">' . apply_filters( 'opus_exif_timestamp_label', __( 'Uploaded', 'opus-primus' ) ) . '</td><td>' . $this->exif_timestamp() . '</td></tr>' );
				}
				if ( $this->exif_camera() ) {
					echo esc_html( '<tr><td class="exif-camera">' . apply_filters( 'opus_exif_camera_label', __( 'Camera', 'opus-primus' ) ) . '</td><td>' . $this->exif_camera() . '</td></tr>' );
				}
				if ( $this->exif_shutter() ) {
					echo esc_html( '<tr><td class="exif-shutter">' . apply_filters( 'opus_exif_shutter_label', __( 'Shutter Speed', 'opus-primus' ) ) . '</td><td>' . $this->exif_shutter() . '</td></tr>' );
				}
				if ( $this->exif_aperture() ) {
					echo esc_html( '<tr><td class="exif-aperture">' . apply_filters( 'opus_exif_aperture_label', __( 'Aperture', 'opus-primus' ) ) . '</td><td>f / ' . $this->exif_aperture() . '</td></tr>' );
				}
				if ( $this->exif_caption() ) {
					echo esc_html( '<tr><td class="exif-caption">' . apply_filters( 'opus_exif_caption_label', __( 'Caption', 'opus-primus' ) ) . '</td><td>' . $this->exif_caption() . '</td></tr>' );
				}
				if ( $this->exif_focal_length() ) {
					echo esc_html( '<tr><td class="exif-focal-length">' . apply_filters( 'opus_exif_focal_length_label', __( 'Focal Length', 'opus-primus' ) ) . '</td><td>' . $this->exif_focal_length() . '</td></tr>' );
				}
				if ( $this->exif_iso_speed() ) {
					echo esc_html( '<tr><td class="exif-iso-speed">' . apply_filters( 'opus_exif_iso_speed_label', __( 'ISO Speed', 'opus-primus' ) ) . '</td><td>' . $this->exif_iso_speed() . '</td></tr>' );
				}
				if ( $this->exif_title() ) {
					echo esc_html( '<tr><td class="exif-title">' . apply_filters( 'opus_exif_title_label', __( 'Title', 'opus-primus' ) ) . '</td><td>' . $this->exif_title() . '</td></tr>' );
				}
				?>
			</tbody>

			<tfoot></tfoot>

		</table><!-- .display-exif-table -->

		<?php
		/** Add empty hook after exif table */
		do_action( 'opus_exif_table_after' );

	}


	/**
	 * Opus Primus EXIF Aperture
	 *
	 * Outputs the aperture details from the EXIF data
	 *
	 * @package OpuysPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::exif_data
	 * @see     apply_filters
	 * @see     do_action
	 *
	 * @return  string
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_aperture() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF aperture */
		do_action( 'opus_exif_aperture_before' );

		/** Initialize aperture string */
		$aperture = '';

		/** Aperture Setting */
		if ( $image_data['image_meta']['aperture'] ) {
			$aperture .= $image_data['image_meta']['aperture'];
		}

		/** Return Aperture string */

		return apply_filters( 'opus_exif_aperture', $aperture );

	}


	/**
	 * Opus Primus EXIF Camera
	 *
	 * Outputs camera details from EXIF data
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::exif_data
	 * @see     apply_filters
	 * @see     do_action
	 *
	 * @return  string
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_camera() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF camera */
		do_action( 'opus_exif_camera_before' );

		/** Initialize camera string */
		$camera = '';

		/** Camera details */
		if ( $image_data['image_meta']['camera'] ) {
			$camera .= $image_data['image_meta']['camera'];
		}

		/** Return Camera string */

		return apply_filters( 'opus_exif_camera', $camera );

	}


	/**
	 * Opus Primus EXIF Caption
	 *
	 * Outputs the image caption from the EXIF data
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::exif_data
	 * @see     apply_filters
	 * @see     do_action
	 *
	 * @return  string
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_caption() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF caption */
		do_action( 'opus_exif_caption_before' );

		/** Initialize EXIF caption string */
		$exif_caption = '';

		/** Image caption from EXIF details */
		if ( $image_data['image_meta']['caption'] ) {
			$exif_caption .= $image_data['image_meta']['caption'];
		}

		/** Return Caption string */

		return apply_filters( 'opus_exif_caption', $exif_caption );

	}


	/**
	 * Opus Primus EXIF Copyright
	 *
	 * Outputs a string containing the author and copyright text
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::exif_data
	 * @see     apply_filters
	 * @see     do_action
	 * @see     get_the_time
	 *
	 * @return  string
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_copyright() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF copyright */
		do_action( 'opus_exif_copyright_before' );

		/** Initialize the copyright string */
		$copyright = '';

		/** Author Credit with Copyright details */
		if ( $image_data['image_meta']['credit'] ) {
			$copyright .= $image_data['image_meta']['credit'];
		}
		if ( $image_data['image_meta']['credit'] && $image_data['image_meta']['copyright'] ) {
			$copyright .= ' ';
		}
		if ( $image_data['image_meta']['copyright'] ) {
			$copyright .= sprintf( __( '&copy; %1$s %2$s', 'opus-primus' ), get_the_time( 'Y' ), $image_data['image_meta']['copyright'] );
		}

		/** Return Copyright string */

		return apply_filters( 'opus_exif_copyright', $copyright );

	}


	/**
	 * Opus Primus EXIF Data
	 *
	 * Returns an object containing the EXIF data found in an image if it exists
	 * otherwise it returns null.
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     wp_get_attachment_metadata
	 *
	 * @return  object|null
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed globalization of `$opus_image_meta`
	 */
	function exif_data() {

		/** EXIF information from image */
		$opus_image_meta = wp_get_attachment_metadata();

		if ( isset( $opus_image_meta ) ) {
			return $opus_image_meta;
		} else {
			return null;
		}

	}


	/**
	 * Opus Primus EXIF Dimensions
	 *
	 * Outputs the original/full width and height of the image being displayed
	 * with a link to the image itself.
	 *
	 * @package          OpusPrimus
	 * @since            0.1
	 *
	 * @see              Opus_Primus_Images::exif_data
	 * @see              (GLOBAL) $post
	 * @see              apply_filters
	 * @see              do_action
	 * @see              wp_get_attachment_url
	 *
	 * @return  string
	 *
	 * @version          1.2
	 * @date             April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_dimensions() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF dimension */
		do_action( 'opus_exif_dimensions_before' );

		$dimensions = '';
		$width      = $image_data['width'];
		$height     = $image_data['height'];

		/** Link to original image with size displayed */
		if ( $width && $height ) {

			global $post;
			$dimensions .= sprintf(
				__( '%1$s (Size: %2$s by %3$s)', 'opus-primus' ),
				'<a href="' . wp_get_attachment_url( $post->ID ) . '">' . sprintf( __( 'Original image', 'opus-primus' ) ) . '</a>',
				$width . 'px',
				$height . 'px'
			);

		}

		return apply_filters( 'opus_exif_dimensions', $dimensions );

	}


	/**
	 * Opus Primus EXIF Focal Length
	 *
	 * Outputs the focal length from the EXIF data
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @see      Opus_Primus_Images::exif_data
	 * @see      apply_filters
	 * @see      do_action
	 *
	 * @return  string
	 *
	 * @version  1.2
	 * @date     April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_focal_length() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF focal length */
		do_action( 'opus_exif_focal_length_before' );

		/** Initialize focal length string */
		$focal_length = '';

		/** Output Focal Length */
		if ( $image_data['image_meta']['focal_length'] ) {
			$focal_length .= $image_data['image_meta']['focal_length'] . 'mm';
		}

		/** Return Focal Length string */

		return apply_filters( 'opus_exif_focal_length', $focal_length );

	}


	/**
	 * Opus Primus EXIF ISO Speed
	 *
	 * Outputs the ISO speed from the EXIF data
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::exif_data
	 * @see     apply_filters
	 * @see     do_action
	 *
	 * @return  string
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_iso_speed() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF ISO speed */
		do_action( 'opus_exif_iso_speed_before' );

		/** Initialize ISO Speed string */
		$iso_speed = '';

		/** Output ISO Speed */
		if ( $image_data['image_meta']['iso'] ) {
			$iso_speed .= $image_data['image_meta']['iso'];
		}

		/** Return ISO Speed */

		return apply_filters( 'opus_exif_iso_speed', $iso_speed );

	}


	/**
	 * Opus Primus EXIF Shutter Speed
	 *
	 * Outputs the Shutter speed from the EXIF data
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::exif_data
	 * @see     apply_filters
	 * @see     do_action
	 * @see     number_format
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_shutter() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF shutter */
		do_action( 'opus_exif_shutter_before' );

		/** Initialize shutter string */
		$shutter = '';

		/** Shutter speed */
		if ( $image_data['image_meta']['shutter_speed'] ) {

			/** Shutter Speed Handler - "sec" is used as the short-form for time measured in seconds */
			if ( ( 1 / $image_data['image_meta']['shutter_speed'] ) > 1 ) {

				$shutter .= '1/';
				if ( number_format( ( 1 / $image_data['image_meta']['shutter_speed'] ), 1 ) === number_format( ( 1 / $image_data['image_meta']['shutter_speed'] ), 0 ) ) {
					$shutter .= number_format( ( 1 / $image_data['image_meta']['shutter_speed'] ), 0, '.', '' ) . ' ' . __( 'sec', 'opus-primus' );
				} else {
					$shutter .= number_format( ( 1 / $image_data['image_meta']['shutter_speed'] ), 1, '.', '' ) . ' ' . __( 'sec', 'opus-primus' );
				}
			} else {

				$shutter .= $image_data['image_meta']['shutter_speed'] . ' ' . __( 'sec', 'opus-primus' );

			}
		}

		/** Return Shutter string */

		return apply_filters( 'opus_exif_shutter', $shutter );

	}


	/**
	 * Opus Primus EXIF Timestamp
	 *
	 * Outputs the timestamp including date and time as found in the image meta
	 * data formatted per Settings > General as found in the Administration
	 * panels (aka Dashboard)
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::exif_data
	 * @see     __
	 * @see     apply_filters
	 * @see     date_i18n
	 * @see     do_action
	 * @see     get_option
	 *
	 * @return  string
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 *
	 * @version 1.3.1
	 * @date    March 1, 2015
	 * Changed from using `get_the_time` to `date_i18n`
	 */
	function exif_timestamp() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF timestamp */
		do_action( 'opus_exif_timestamp_before' );

		/** Initialize the timestamp string */
		$timestamp = '';

		/** Creation timestamp in end-user settings format */
		if ( $image_data['image_meta']['created_timestamp'] ) {

			$timestamp .= sprintf(
				__( '%1$s @ %2$s', 'opus-primus' ),
				date_i18n( get_option( 'date_format' ), $image_data['image_meta']['created_timestamp'] ),
				date_i18n( get_option( 'time_format' ), $image_data['image_meta']['created_timestamp'] )
			);

		}

		/** Return Timestamp string */

		return apply_filters( 'opus_exif_timestamp', $timestamp );

	}


	/**
	 * Opus Primus EXIF Title
	 *
	 * Outputs the image title from the EXIF data
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::exif_data
	 * @see     apply_filters
	 * @see     do_action
	 *
	 * @return  string
	 *
	 * @version 1.2
	 * @date    April 9, 2013
	 * Removed global `$opus_image_meta`; call `exif_data` method instead
	 */
	function exif_title() {

		/** Image meta data */
		$image_data = $this->exif_data();

		/** Add empty hook before EXIF Title */
		do_action( 'opus_exif_title_before' );

		/** Initialize EXIF Title string */
		$exif_title = '';

		/** Title from EXIF details */
		if ( $image_data['image_meta']['title'] ) {
			$exif_title .= $image_data['image_meta']['title'];
		}

		/** Return Title string */

		return apply_filters( 'opus_exif_title', $exif_title );

	}


	/**
	 * Opus Primus Featured Thumbnail
	 *
	 * Returns the Featured Image with default size set to thumbnail and aligned
	 * to the left
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string $size  default = thumbnail (uses WordPress sizes).
	 * @param   string $class default = alignleft (can be any CSS class).
	 *
	 * @see     esc_attr
	 * @see     esc_url
	 * @see     get_post_thumbnail_id
	 * @see     get_the_ID
	 * @see     has_post_thumbnail
	 * @see     is_archive
	 * @see     is_single
	 * @see     the_post_thumbnail
	 * @see     the_title_attribute
	 * @see     wp_get_attachment_image_src
	 *
	 * @return  string - Featured Thumbnail image and URL
	 *
	 * @version 1.2
	 * @date    April 18, 2013
	 * Changed `the_post_thumbnail` to use parameters which are set in the call to this method
	 * Remove `is_single` conditional in conjunction with displaying full image on single view of standard format posts
	 *
	 * @version 1.2.3
	 * @date    December 30, 2013
	 * Removed Featured Image thumbnail from index view
	 * Added Featured Image Thumbnail to archive views
	 *
	 * @version 1.2.4
	 * @date    May 10, 2014
	 * Bring the Featured Image Thumbnail back into the index view ... can you say "waffle"?
	 *
	 * @version 1.3.1
	 * @date    Rare Disease Day 2014
	 * Added some escaping sanitization and linked to post via its ID
	 * Change method to return the Featured Thumbnail versus outputting it
	 */
	function featured_thumbnail( $size = 'thumbnail', $class = 'alignleft' ) {

		$output = null;

		if ( has_post_thumbnail() ) {

			$output = '<a class="featured-thumbnail" href="' . esc_url( home_url( '/?p=' . get_the_ID() ) ) . '" title="' . esc_attr( the_title_attribute( 'echo=0' ) ) . '" >';
			$output .= get_the_post_thumbnail( get_the_ID(), $size, array( 'class' => $class ) );
			$output .= '</a>';

		}

		return $output;

	}


	/**
	 * Featured Thumbnail Single View
	 *
	 * @package OpusPrimus
	 * @since   1.3.1
	 *
	 * @see     Opus_Primus_Images::featured_thumbnail
	 * @see     get_post_thumbnail_id
	 * @see     is_bool
	 * @see     wp_get_attachment_metadata
	 *
	 * @param bool $use_portrait default = true.
	 *
	 * @return string
	 *
	 * @version 1.3.3
	 * @date    March 3, 2015
	 * Added sanity checks to ensure there is actually an image in use.
	 */
	function featured_thumbnail_single_view( $use_portrait = true ) {

		$featured_image_metadata = wp_get_attachment_metadata( get_post_thumbnail_id() );

		/** Use hook as toggle to display featured image with portrait consideration */
		$use_portrait = apply_filters( 'opus_featured_thumbnail_single_view_portrait', $use_portrait );

		/** Quick sanity check to ensure that a boolean value is used */
		if ( ! is_bool( $use_portrait ) ) {

			/** Set to true (default) */
			$use_portrait = true;

		}

		if ( isset( $featured_image_metadata['height'] ) && isset( $featured_image_metadata['width'] ) ) {

			if ( $use_portrait && ( $featured_image_metadata['height'] > $featured_image_metadata['width'] ) ) {
				return $this->featured_thumbnail( $size = 'full', $class = 'alignleft' );
			} else {
				return $this->featured_thumbnail( $size = 'full', $class = 'aligncenter' );
			}
		} else {

			return null;

		}

	}


	/**
	 * Show Featured Thumbnail
	 *
	 * Used to display the featured thumbnail image in templates
	 *
	 * @package Opus_Primus
	 * @since   1.2.4
	 *
	 * @param   bool $echo default = true, displays featured image thumbnail.
	 *
	 * @see     Opus_Primus_Images::featured_thumbnail
	 * @see     Opus_Primus_Images::featured_thumbnail_single_view
	 * @see     is_archive
	 * @see     is_single
	 *
	 * @version 1.3.1
	 * @date    Rare Disease Day 2015
	 * Extracted code to create `featured_thumbnail_single_view` method
	 * Method now also writes to the screen
	 */
	function show_featured_thumbnail( $echo = true ) {

		if ( $echo ) {

			/** Sanity check - are we in the right view to show the image? */
			if ( ! is_single() && is_archive() ) {

				echo esc_url( $this->featured_thumbnail( $size = 'thumbnail', $class = 'alignright' ) );

			} else {

				if ( ! is_single() ) {
					echo esc_url( $this->featured_thumbnail() );
				} else {
					echo esc_url( $this->featured_thumbnail_single_view() );
				}
			}
		}

	}


	/**
	 * First Linked Image
	 *
	 * Finds the first image in the post and returns it
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     (GLOBAL) $post
	 *
	 * @version 1.2.2
	 * @date    September 12, 2013
	 * Fixed undefined offset when there is no image found in post
	 *
	 * @todo    Return the same image "size" used in the "attachment" as found in the Post-Format: Image archive (1.2)
	 */
	function first_linked_image() {

		global $post;
		preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );

		/** Make sure there was an image found before using it for the URL  */
		if ( array() !== $matches[0] ) {
			$image_url = $matches[1][0];
		}

		/** Make sure the image URL is set before returning the image itself */
		if ( isset( $image_url ) ) {
			return '<img class="linked-image" src="' . $image_url . '" alt="" />';
		}

		/** Obviously if there is no image URL then return nothing */

		return null;

	}


	/**
	 * Opus Primus Image Title
	 *
	 * Used in the image Attachment template file to output the image title as
	 * noted in the media library
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   string $before text before title, default is none.
	 * @param   string $after  text after title, default is none.
	 * @param   bool   $echo   default = true, display image title text.
	 *
	 * @see     __
	 * @see     do_action
	 * @see     is_attachment
	 * @see     the_permalink
	 * @see     the_title
	 * @see     the_title_attribute
	 */
	function image_title( $before = '', $after = '', $echo = true ) {

		/** Add empty hook before the image title */
		do_action( 'opus_image_title_before' );

		/** Set `the_title` parameters */
		if ( empty( $before ) ) {
			$before = '<h2 class="image-title">';
		}

		if ( empty( $after ) ) {
			$after = '</h2>';
		}

		/** Wrap the title in an anchor tag and provide a nice tool tip */
		if ( ! is_attachment() ) { ?>

			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(
				array(
					'before' => __( 'View', 'opus-primus' ) . ' ',
					'after'  => ' ' . __( 'only', 'opus-primus' ),
				)
			); ?>">
				<?php the_title( $before, $after, $echo ); ?>
			</a>

			<?php
		} else {

			the_title( $before, $after, $echo );

		}

		/** Add empty hook after the image title */
		do_action( 'opus_image_title_after' );

	}


	/**
	 * Show First Linked Image
	 *
	 * Displays the output returned by `first_linked_image`
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Images::first_linked_image
	 */
	function show_first_linked_image() {

		echo esc_html( $this->first_linked_image() );
	}
}
