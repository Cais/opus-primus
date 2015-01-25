<?php
/**
 * Opus Primus Ignite
 *
 * Initialization file for the theme: defined CONSTANTS; and, included classes.
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
 * @version     1.2.5
 * @date        July 14, 2014
 * Renamed `opus-ignite.php` to `opus-primus-ignite.php` and moved to theme root
 * Added back into theme core to reduce clutter in `functions.php`
 * Set Customization path and URL CONSTANTS
 *
 * @version     1.3
 * @date        September 1, 2014
 * Removed constant definitions that were replaced by the OpusPrimusRouter class
 * Replaced `required_once` with `locate_template`
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
locate_template( 'includes/class.OpusPrimusRouter.php', true, true );

/** Add Global Defaults */
locate_template( 'includes/opus-primus-defaults.php', true, true );

/** Add Widgets */
locate_template( 'includes/widgets.php', true, true );

/** Load the classes - in order of appearance/dependency */
/** Add Navigation */
locate_template( 'includes/class.OpusPrimusNavigation.php', true, true );
/** Add Structures */
locate_template( 'includes/class.OpusPrimusStructures.php', true, true );
/** Add Headers */
locate_template( 'includes/class.OpusPrimusHeaders.php', true, true );
/** Add Posts */
locate_template( 'includes/class.OpusPrimusPosts.php', true, true );
/** Add Comments Hooks */
locate_template( 'includes/class.OpusPrimusComments.php', true, true );
/** Add Images */
locate_template( 'includes/class.OpusPrimusImages.php', true, true );
/** Add Gallery */
locate_template( 'includes/class.OpusPrimusGallery.php', true, true );
/** Add Authors */
locate_template( 'includes/class.OpusPrimusAuthors.php', true, true );
/** Add Archives */
locate_template( 'includes/class.OpusPrimusArchives.php', true, true );
/** Add Breadcrumbs */
locate_template( 'includes/class.OpusPrimusBreadcrumbs.php', true, true );

/** Add Stanzas */
locate_template( 'stanzas/stanzas.php', true, true );