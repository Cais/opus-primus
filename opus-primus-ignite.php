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
 * Removed constant definitions that were replaced by the OpusPrimusRouter class
 */

/** Set Customization path and URL CONSTANTS with Sanity Checks */
if ( ! defined( 'OPUS_CUSTOM_PATH' ) ) {
	define( 'OPUS_CUSTOM_PATH', WP_CONTENT_DIR . '/opus-primus-customs/' );
}
/** End if - not defined */
if ( ! defined( 'OPUS_CUSTOM_URL' ) ) {
	define( 'OPUS_CUSTOM_URL', content_url( '/opus-primus-customs/' ) );
}
/** End if - not defined */

/** Get the router class so we can build the paths */
require_once( get_template_directory() . '/includes/' . 'class.OpusPrimusRouter.php' );
/** Call the global class variable for the router */
global $opus_router;

/** Add Global Defaults */
require_once( $opus_router->path( 'includes' ) . 'opus-primus-defaults.php' );

/** Add Widgets */
require_once( $opus_router->path( 'includes' ) . 'widgets.php' );

/** Load the classes - in order of appearance/dependency */
/** Add Navigation */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusNavigation.php' );
/** Add Structures */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusStructures.php' );
/** Add Headers */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusHeaders.php' );
/** Add Posts */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusPosts.php' );
/** Add Comments Hooks */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusComments.php' );
/** Add Images */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusImages.php' );
/** Add Gallery */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusGallery.php' );
/** Add Authors */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusAuthors.php' );
/** Add Archives */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusArchives.php' );
/** Add Breadcrumbs */
require_once( $opus_router->path( 'includes' ) . 'class.OpusPrimusBreadcrumbs.php' );

/** Add Stanzas */
require_once( $opus_router->path( 'stanzas' ) . 'stanzas.php' );