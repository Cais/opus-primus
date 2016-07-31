<?php
/**
 * Opus Primus Headers
 *
 * Functionality specifically found in the header area / templates
 *
 * @package     OpusPrimus
 * @since       1.1
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
 * Class Opus Primus Header
 *
 * Handles header related items for the Opus Primus WordPress theme
 *
 * @version     1.4
 * @date        April 5, 2015
 *
 * Change `OpusPrimusHeader` to a singleton style class
 * Renamed file to `class-opus-primus-header.php` for consistency
 */
class Opus_Primus_Header {

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
	 * @return null|Opus_Primus_Header
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
	 * Site Title
	 *
	 * Generates the site title output
	 *
	 * @package OpusPrimus
	 * @since   1.1
	 *
	 * @see     esc_attr
	 * @see     esc_url
	 * @see     get_bloginfo
	 * @see     home_url
	 */
	function site_title() {
		?>

		<h1 id="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h1><!-- #site-title -->

	<?php }


	/**
	 * Site Title Block
	 *
	 * Wraps the site title in action hooks
	 *
	 * @package OpusPrimus
	 * @since   1.1
	 *
	 * @see     Opus_Primus_Header::site_title
	 * @see     do_action
	 */
	function site_title_block() {

		/** Add empty hook before site title */
		do_action( 'opus_site_title_before' );

		/** Site Title */
		$this->site_title();

		/** Add empty hook after site title */
		do_action( 'opus_site_title_after' );

	}


	/**
	 * Site Description
	 *
	 * Displays site description
	 *
	 * @package OpusPrimus
	 * @since   1.1
	 *
	 * @see     bloginfo
	 */
	function site_description() {
		?>

		<h2 id="site-description">
			<?php bloginfo( 'description' ); ?>
		</h2><!-- #site-description -->

	<?php }


	/**
	 * Site Description Block
	 *
	 * Displays site description wrapped in action hooks
	 *
	 * @package OpusPrimus
	 * @since   1.1
	 *
	 * @see     Opus_Primus_Header::site_description
	 * @see     do_action
	 */
	function site_description_block() {

		/** Add empty hook before site description */
		do_action( 'opus_site_description_before' );

		/** Add site description */
		$this->site_description();

		/** Add empty hook after site description */
		do_action( 'opus_site_description_after' );

	}


	/**
	 * Custom Header Image
	 *
	 * Returns the string to display the custom header image.
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     get_header_image
	 *
	 * @return string
	 */
	function custom_header_image() {

		$header_image = '<img class="opus-custom-header" src="' . get_header_image() . '" alt="" />';

		return $header_image;

	}


	/**
	 * Show Custom Header Image
	 *
	 * Writes to the screen the URL return by custom_header_image
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @see     Opus_Primus_Headers::custom_header_image
	 * @see     esc_html
	 * @see     get_header_image
	 */
	function show_custom_header_image() {

		if ( get_header_image() ) {
			echo esc_html( $this->custom_header_image() );
		}

	}


	/**
	 * Show Custom Header Image Block
	 *
	 * Outputs the Custom Header image wrapped in action hooks
	 *
	 * @package OpusPrimus
	 * @since   1.1
	 *
	 * @see     Opus_Primus_Header::show_custom_header_image
	 * @see     do_action
	 */
	function show_custom_header_image_block() {

		/** Add empty hook before custom header image */
		do_action( 'opus_custom_header_image_before' );

		$this->show_custom_header_image();

		/** Add empty hook after custom header image */
		do_action( 'opus_custom_header_image_after' );

	}
}
