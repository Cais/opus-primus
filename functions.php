<?php
/**
 * Functions
 * Where the magic happens ...
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2014, Opus Primus
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
 * @version     1.2
 * @date        July 19, 2013
 * Removed 'style.less' related function and action calls
 * Merge `opus-primus-ignite.php` into `functions.php`
 *
 * @version     1.2.4
 * @date        April 7, 2014
 * Added `opus_primus_theme_version` function
 *
 * @version     1.2.5
 * @date        June 2, 2014
 * Added `opus-primus-ignite.php` for theme initialization requirements
 *
 * @version 1.3
 * @date    September 21, 2014
 * Replaced `require_once` with `locate_template`
 */

/** Fire up the theme with its classes, widgets, and defaults */
locate_template( 'opus-primus-ignite.php', true, true );

/**
 * Opus Primus Theme Version
 * Returns a filtered version of the theme version number to be used with
 * JavaScript and Style Sheet enqueue statements.
 *
 * @package             Opus_Primus
 * @since               1.2.4
 *
 * @uses                (GLOBAL) $wp_version
 * @uses                apply_filters
 * @uses                wp_get_theme
 *
 * @return string
 */
function opus_primus_theme_version() {

	return apply_filters( 'opus_primus_theme_version_text', wp_get_theme()->get( 'Version' ) );

}

/** End function - theme version */


if ( ! function_exists( 'opus_primus_enqueue_scripts' ) ) {
	/**
	 * Opus Primus Enqueue Scripts
	 * Use to enqueue the theme javascript and custom stylesheet, if it exists
	 *
	 * @package            OpusPrimus
	 * @since              0.1
	 *
	 * @uses               OpusPrimusRouter::path
	 * @uses               OpusPrimusRouter::path_uri
	 * @uses               opus_primus_theme_version
	 * @uses               get_header_image
	 * @uses               is_readable
	 * @uses               is_single
	 * @uses               wp_enqueue_script
	 * @uses               wp_enqueue_style
	 * @uses               wp_get_theme->get
	 *
	 * @internal           jQuery is enqueued as a dependency
	 *
	 * @version            1.1
	 * @date               March 18, 2013
	 * Enqueue jQuery UI Tabs script for Comments
	 *
	 * @version            1.2
	 * @date               July 19, 2013
	 * Added `is_single` conditional test before enqueue of Comment Tabs script
	 *
	 * @version            1.2.3
	 * @date               February 19, 2014
	 * Added `dashicons` dependency to main `Opus-Primus` stylesheet
	 *
	 * @version            1.2.4
	 * @date               April 7, 2014
	 * Replaced `wp_get_theme()->get( 'Version' )` version call with `opus_primus_theme_version` call as a more unique and informative value
	 *
	 * @version            1.2.5
	 * @date               June 15, 2014
	 * Enqueue custom stylesheet in an update safe location `/wp-content/opus-primus-customs/`
	 * Enqueue custom JavaScript in an update safe location `/wp-content/opus-primus-customs/`
	 * Remove conditional customization enqueue using internal theme folder as not working (or update safe)
	 *
	 * @version            1.3
	 * @since              August 24, 2014
	 * Replace CONSTANTS with OpusPrimusRouter methods
	 * Enqueue JavaScripts and CSS for SlickNav JavaScript plugin integration to handle mobile menus
	 */
	function opus_primus_enqueue_scripts() {
		/** Create OpusPrimusRouter class object */
		$opus_router = new OpusPrimusRouter();

		/** Enqueue Theme Scripts */
		/** Enqueue Opus Primus JavaScripts which will enqueue jQuery as a dependency */
		wp_enqueue_script( 'opus-primus', $opus_router->path_uri( 'js' ) . 'opus-primus.js', array( 'jquery' ), opus_primus_theme_version(), true );

		/** Enqueue Opus Primus Full Size Video which will enqueue jQuery as a dependency */
		wp_enqueue_script( 'opus-primus-full-size-video', $opus_router->path_uri( 'js' ) . 'opus-primus-full-size-video.js', array( 'jquery' ), opus_primus_theme_version(), true );

		/** Enqueue FitVids - improves responsiveness of videos */
		wp_enqueue_script( 'FitVids', $opus_router->path_uri( 'lib' ) . 'FitVids/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
		wp_enqueue_script(
			'opus-primus-fitvids-init', $opus_router->path_uri( 'lib' ) . 'opus-primus-fitvids-init.js', array(
				'jquery',
				'FitVids'
			), opus_primus_theme_version(), true
		);

		/** Enqueue Opus Primus Comment Tabs which will enqueue jQuery, jQuery UI Core, jQuery UI Widget, and jQuery UI Tabs as dependencies */
		if ( is_single() ) {
			wp_enqueue_script(
				'opus-primus-comment-tabs', $opus_router->path_uri( 'js' ) . 'opus-primus-comment-tabs.js', array(
					'jquery',
					'jquery-ui-core',
					'jquery-ui-widget',
					'jquery-ui-tabs'
				), opus_primus_theme_version(), true
			);
		}
		/** End if - is single */

		/** Enqueue Opus Primus Header Image Position (if there is a header image) which will enqueue jQuery as a dependency */
		if ( get_header_image() ) {
			wp_enqueue_script( 'opus-primus-header-image-position', $opus_router->path_uri( 'js' ) . 'opus-primus-header-image-position.js', array( 'jquery' ), opus_primus_theme_version(), true );
		}
		/** End if - get header image */

		/** Enqueue Theme Stylesheets */
		/** Theme Layouts */
		wp_enqueue_style( 'Opus-Primus-Layout', $opus_router->path_uri( 'css' ) . 'opus-primus-layout.css', array(), opus_primus_theme_version(), 'screen' );

		/** Main Theme Elements with dashicons dependency */
		wp_enqueue_style( 'Opus-Primus', $opus_router->path_uri( 'css' ) . 'opus-primus.css', array( 'dashicons' ), opus_primus_theme_version(), 'screen' );

		/** Media Queries and Responsive Elements */
		wp_enqueue_style( 'Opus-Primus-Media-Queries', $opus_router->path_uri( 'css' ) . 'opus-primus-media-queries.css', array(), opus_primus_theme_version(), 'screen' );

		/**
		 * Enqueue custom stylesheet after other stylesheets in an update safe
		 * location to maintain expected specificity
		 */
		if ( is_readable( OPUS_CUSTOM_PATH . 'opus-primus-custom-style.css' ) ) {
			wp_enqueue_style( 'Opus-Primus-Custom-Style', OPUS_CUSTOM_URL . 'opus-primus-custom-style.css', array(), opus_primus_theme_version(), 'screen' );
		}
		/** End if - is readable */

		/** Enqueue custom JavaScript in an update safe location */
		if ( is_readable( OPUS_CUSTOM_PATH . 'opus-primus-custom-script.js' ) ) {
			wp_enqueue_script( 'opus-primus-custom-script', OPUS_CUSTOM_URL . 'opus-primus-custom-script.js', array( 'jquery' ), opus_primus_theme_version(), true );
		}
		/** End if - is readable */

		/** Mobile Menu via SlickNav JavaScript plugin integration */
		/** Enqueue the SlickNav styles */
		wp_enqueue_style( 'SlickNav-CSS-main', $opus_router->path_uri( 'lib' ) . 'SlickNav/slicknav.css', array(), '1.0.1', 'screen' );
		/** Enqueue the SlickNav JavaScript with jQuery dependency */
		wp_enqueue_script( 'SlickNav-JS-main', $opus_router->path_uri( 'lib' ) . 'SlickNav/jquery.slicknav.min.js', array( 'jquery' ), '1.0.1', true );
		/** Enqueue SlickNav initialization script with jQuery and SlickNav dependencies */
		wp_enqueue_script(
			'SlickNav-init', $opus_router->path_uri( 'lib' ) . 'opus-primus-slicknav-init.js', array(
				'jquery',
				'SlickNav-JS-main'
			), opus_primus_theme_version(), true
		);
		/** Enqueue SlickNav mobile layout only styles with SlickNav dependency */
		wp_enqueue_style( 'SlickNav-layout', $opus_router->path_uri( 'lib' ) . 'opus-primus-slicknav.css', array( 'SlickNav-CSS-main' ), opus_primus_theme_version(), 'screen' );

	}
	/** End function - opus primus enqueue scripts */

}
/** End if - function exists - opus primus enqueue scripts */
add_action( 'wp_enqueue_scripts', 'opus_primus_enqueue_scripts' );


if ( ! function_exists( 'opus_primus_theme_setup' ) ) {
	/**
	 * Opus Primus Theme Setup
	 * Add theme support for: post-thumbnails, automatic feed links, TinyMCE
	 * editor style, custom background, post formats
	 *
	 * @package          OpusPrimus
	 * @since            0.1
	 *
	 * @uses             (GLOBAL) $content_width
	 * @uses             add_editor_style
	 * @uses             add_theme_support: automatic-feed-links
	 * @uses             add_theme_support: custom-background
	 * @uses             add_theme_support: custom-header
	 * @uses             add_theme_support: html5 (search form, comment form, comment list, caption, gallery)
	 * @uses             add_theme_support: post-formats
	 * @uses             add_theme_support: post-thumbnails
	 * @uses             load_theme_textdomain
	 * @uses             get_locale
	 * @uses             get_template_directory
	 * @uses             get_template_directory_uri
	 * @uses             register_nav_menus
	 *
	 * @version          1.2.5
	 * @date             July 20, 2014
	 * Added global $content_width
	 * Moved $content_width definition into theme setup function
	 *
	 * @version          1.3
	 * @date             August 22, 2014
	 * Added WordPress HTML5 markup support
	 */
	function opus_primus_theme_setup() {
		/** This theme uses post thumbnails */
		add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );

		/** Add default posts and comments RSS feed links to head */
		add_theme_support( 'automatic-feed-links' );

		/** Add theme support for editor-style */
		add_editor_style();

		/** This theme allows users to set a custom background */
		add_theme_support(
			'custom-background', array(
				'default-color' => 'ffffff',
				/** 'default-image' => get_stylesheet_directory_uri() . '/images/background.png' */
			)
		);

		/** Add support for ALL post-formats */
		add_theme_support(
			'post-formats', array(
				'aside',
				'audio',
				'chat',
				'gallery',
				'image',
				'link',
				'quote',
				'status',
				'video'
			)
		);

		/** @var $opus_custom_header_support - holds custom header parameters */
		$opus_custom_header_support = array(
			/**
			 * There is no default image in use.
			 * If you were to add one, use %s as a placeholder for the theme
			 * template directory URI.
			 */
			'default-image' => '',
			/** Support flexible heights. */
			'flex-height'   => true,
			/** Support flexible widths */
			'flex-width'    => true,
			/** Do not support text inside the header image. */
			'header-text'   => false,
		);
		/** Add support for Custom Header images */
		add_theme_support( 'custom-header', $opus_custom_header_support );

		/** Add WordPress HTML5 markup support */
		$html_items = array(
			'search-form',
			'comment-form',
			'comment-list',
			'caption',
			'gallery'
		);
		add_theme_support( 'html5', $html_items );

		/** Add custom menu support (Primary and Secondary) */
		register_nav_menus(
			array(
				'primary'   => __( 'Primary (Parent-Theme) Menu', 'opus-primus' ),
				'secondary' => __( 'Secondary Menu (not used in Parent-Theme)', 'opus-primus' ),
				'search'    => __( 'Search Results Menu', 'opus-primus' )
			)
		);

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 */
		load_theme_textdomain( 'opus-primus', get_template_directory() . '/languages' );
		$locale      = get_locale();
		$locale_file = get_template_directory_uri() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}
		/** End if - is readable */

		/** Set content width to 1000 - see Full Size Video script */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1000;
		}
		/** End if - not isset - content width */

	}
	/** End function - opus primus theme setup */

}
/** End if - function exists - opus primus theme setup */
add_action( 'after_setup_theme', 'opus_primus_theme_setup' );


/** Miscellaneous Functions */
/** Return a space when all other __return_* fail, use this?! */
function opus_primus_return_blank() {
	return ' ';
}

/**
 * Compatibility
 * Main compatibility conditionals
 *
 * @package            Opus_Primus
 * @subpackage         Compatibility
 * @since              1.2.3
 *
 * @uses               OpusPrimusRouter::path_uri
 * @uses               is_plugin_active
 * @uses               opus_primus_theme_version
 * @uses               wp_enqueue_style
 *
 * @version            1.3
 * @date               September 13, 2014
 * Replaced CONSTANT with OpusPrimusRouter method
 * Added Contact Form 7 compatibility
 */
function opus_primus_compatibility() {

	/** Call the wp-admin plugin code */
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

	/** Create OpusPrimusRouter class object */
	$opus_router = new OpusPrimusRouter();

	/**
	 * Soliloquy - slider plugin
	 * @link    http://soliloquywp.com/
	 */
	if ( is_plugin_active( 'soliloquy/soliloquy.php' ) ) {
		/** Enqueue Soliloquy Styles */
		wp_enqueue_style( 'Opus-Primus-Soliloquy', $opus_router->path_uri( 'compatibility' ) . 'opus-primus-soliloquy.css', array(), opus_primus_theme_version(), 'screen' );
	}
	/** End if - soliloquy plugin is active */

	/**
	 * Contact Form 7 - forms plugin
	 * @link    http://wordpress.org/plugins/contact-form-7/
	 */
	if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		/** Enqueue Soliloquy Styles */
		wp_enqueue_style( 'Opus-Primus-Contact-Form-7', $opus_router->path_uri( 'compatibility' ) . 'opus-primus-contact-form-7.css', array(), opus_primus_theme_version(), 'screen' );
	}
	/** End if - contact form 7 plugin is active */

}

/** End function - opus primus compatibility */
add_action( 'wp_enqueue_scripts', 'opus_primus_compatibility' );