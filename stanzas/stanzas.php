<?php
/**
 * Stanzas
 * Includes all of the current stanzas aka extensions
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
 * @version     1.0.3
 * @date        February 28, 2013
 * Added Taglines as a Stanza versus a theme feature
 *
 * @version     1.2
 * @date        April 5, 2013
 * Added mechanism to find and include new custom stanzas
 */

/** Add Pull Quotes */
require_once( OPUS_STANZAS . 'pullquotes/class.OpusPrimusPullQuotes.php' );

/** Add TagLines */
require_once( OPUS_STANZAS . 'taglines/class.OpusPrimusTagLines.php' );

/** Add Theme Hook Alliance Support */
require_once( OPUS_STANZAS . 'tha/tha-support.php' );


/** === New Custom Stanzas === ---------------------------------------------- */
/** Get all files with a .txt extension. */
$stanzas = glob( OPUS_STANZAS . '*.txt' );

/** Sanity check ... make sure there are custom stanzas to be added first */
if ( $stanzas ) {
	foreach ( $stanzas as $stanza ) {
		require_once( OPUS_STANZAS . basename( $stanza, '.txt' ) . '/' . basename( $stanza, '.txt' ) . '.php' );
	}
	/** End foreach - add each custom stanza */
} /** End if - stanzas */