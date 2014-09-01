<?php

/**
 * Opus Primus New Custom Stanza
 * No significant usefulness is being provided by this class except as an
 * example to be used in a New Custom Stanza
 *
 * @package     OpusPrimus
 * @subpackage  NewCustomStanza
 * @since       1.2
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2013-2014, Opus Primus
 *
 * This file is part of Opus Primus New Custom Stanza, a part of Opus Primus.
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
class OpusPrimusNewCustomStanza {

	function __construct() {
		/** Test only - should not use as is */
		// add_action( 'opus_the_content_before', array( $this, 'test' ) );

	}

	/** End function - constructor */


	function test() {
		echo 'New Custom Stanza ... the class test!!!';
	}
	/** End function - test */

}

/** End class - opus primus new stanza */


/** @var $opus_new_stanza - new class instance */
$opus_new_custom_stanza = new OpusPrimusNewCustomStanza();