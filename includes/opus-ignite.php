<?php
/**
 * Opus Ignite
 * Initialization file for the theme: defined CONSTANTS; and, included classes.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
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

/** Set CONSTANTS */
define( 'OPUS_INC', get_template_directory() . '/includes/' );
define( 'OPUS_JS', get_template_directory_uri() . '/js/' );
define( 'OPUS_CSS', get_template_directory_uri() . '/css/' );

/** Add Archives */
require_once( OPUS_INC . 'class.OpusPrimusArchives.php' );
/** Add Post Structures */
require_once( OPUS_INC . 'class.OpusPrimusStructures.php' );
/** Add Navigation */
require_once( OPUS_INC . 'class.OpusPrimusNavigation.php' );
/** Add Gallery */
require_once( OPUS_INC . 'class.OpusPrimusGallery.php' );
/** Add Sharing */
require_once( OPUS_INC . 'class.OpusPrimusSocial.php' );