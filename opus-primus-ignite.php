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
 * Added `OPUS_LIB` constant for use with bundled libraries
 */

/** Set CONSTANTS */
define( 'OPUS_LIB', get_template_directory_uri() . '/lib/' );
define( 'OPUS_INC', get_template_directory() . '/includes/' );
define( 'OPUS_JS', get_template_directory_uri() . '/js/' );
define( 'OPUS_CSS', get_template_directory_uri() . '/css/' );
define( 'OPUS_IMAGES', get_template_directory_uri() . '/images/' );
define( 'OPUS_STANZAS', get_template_directory() . '/stanzas/' );
define( 'OPUS_STANZAS_URI', get_template_directory_uri() . '/stanzas/' );
define( 'OPUS_COMPAT', get_template_directory_uri() . '/compatibility/' );

/** Set Customization path and URL CONSTANTS */
define( 'OPUS_CUSTOM_PATH', WP_CONTENT_DIR . '/opus-primus-customs/' );
define( 'OPUS_CUSTOM_URL', content_url( '/opus-primus-customs/' ) );

/** For Testing Purposes */
define( 'OPUS_WIP', get_template_directory() . '/works-in-progress/' );


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