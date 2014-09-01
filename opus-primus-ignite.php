<?php
/**
 * Opus Primus Ignite
 * Initialization file for the theme: defined CONSTANTS; and, included classes.
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
 * @version     1.1
 * @date        March 9, 2013
 * Added call to 'Header' class
 *
 * @version     1.2
 * @date        July 19, 2013
 * Merged into `functions.php` retained for reference purposes only
 *
 * @version     1.2.5
 * @date        July 14, 2014
 * Renamed `opus-ignite.php` to `opus-primus-ignite.php` and moved to theme root
 * Added back into theme core to reduce clutter in `functions.php`
 * Set Customization path and URL CONSTANTS
 *
 * @version     1.3
 * @date        September 1, 2014
 * Added sanity checks to ensure constants are not already defined
 * Added `OPUS_LIB` constant for use with bundled libraries
 */

/**
 * Set CONSTANTS with Sanity Checks
 * Although there really should not be any significant cases where the following
 * constants would be defined elsewhere, there does exist the possibility a
 * Child-Theme may want to provide a definition using a different path.
 */
if ( ! defined( 'OPUS_LIB' ) ) {
	define( 'OPUS_LIB', get_template_directory_uri() . '/lib/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_INC' ) ) {
	define( 'OPUS_INC', get_template_directory() . '/includes/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_JS' ) ) {
	define( 'OPUS_JS', get_template_directory_uri() . '/js/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_CSS' ) ) {
	define( 'OPUS_CSS', get_template_directory_uri() . '/css/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_IMAGES' ) ) {
	define( 'OPUS_IMAGES', get_template_directory_uri() . '/images/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_STANZAS' ) ) {
	define( 'OPUS_STANZAS', get_template_directory() . '/stanzas/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_STANZAS_URI' ) ) {
	define( 'OPUS_STANZAS_URI', get_template_directory_uri() . '/stanzas/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_COMPAT' ) ) {
	define( 'OPUS_COMPAT', get_template_directory_uri() . '/compatibility/' );
}
/** End if - not defined */

/** Set Customization path and URL CONSTANTS with Sanity Checks */
if ( ! defined( 'OPUS_CUSTOM_PATH' ) ) {
	define( 'OPUS_CUSTOM_PATH', WP_CONTENT_DIR . '/opus-primus-customs/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_CUSTOM_URL' ) ) {
	define( 'OPUS_CUSTOM_URL', content_url( '/opus-primus-customs/' ) );
}
/** End if - not defined */

/** For Testing Purposes */
if ( ! defined( 'OPUS_WIP' ) ) {
	define( 'OPUS_WIP', get_template_directory() . '/works-in-progress/' );
}
/** End if - not defined */
/** End: CONSTANTS ---------------------------------------------------------- */


/** Add Widgets */
require_once( OPUS_INC . 'widgets.php' );

/** Load the classes - in order of appearance/dependency */
/** Add Global Defaults */
require_once( OPUS_INC . 'opus-primus-defaults.php' );
/** Add Navigation */
require_once( OPUS_INC . 'class.OpusPrimusNavigation.php' );
/** Add Structures */
require_once( OPUS_INC . 'class.OpusPrimusStructures.php' );
/** Add Headers */
require_once( OPUS_INC . 'class.OpusPrimusHeaders.php' );
/** Add Posts */
require_once( OPUS_INC . 'class.OpusPrimusPosts.php' );
/** Add Comments Hooks */
require_once( OPUS_INC . 'class.OpusPrimusComments.php' );
/** Add Images */
require_once( OPUS_INC . 'class.OpusPrimusImages.php' );
/** Add Gallery */
require_once( OPUS_INC . 'class.OpusPrimusGallery.php' );
/** Add Authors */
require_once( OPUS_INC . 'class.OpusPrimusAuthors.php' );
/** Add Archives */
require_once( OPUS_INC . 'class.OpusPrimusArchives.php' );
/** Add Breadcrumbs */
require_once( OPUS_INC . 'class.OpusPrimusBreadcrumbs.php' );

/** Add Stanzas */
require_once( OPUS_STANZAS . 'stanzas.php' );