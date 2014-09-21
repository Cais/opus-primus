<?php

/**
 * Opus Primus Router
 * Defines the theme path structures
 *
 * @package     OpusPrimus
 * @since       1.3
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2014, Opus Primus
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
 * @todo        - Review for uses with Child-Themes
 */
class OpusPrimusRouter {

	/**
	 * Constructor
	 *
	 * @package    OpusPrimus
	 * @since      1.3
	 */
	function __construct() {
	} /** End function - construct */

	/**
	 * Path
	 * Retrieves the absolute path to the directory of the current theme
	 * appended with the folder and trailing slash
	 *
	 * @package    OpusPrimus
	 * @since      1.3
	 *
	 * @uses       get_template_directory
	 *
	 * @param $string
	 *
	 * @return string
	 */
	function path( $string ) {
		return get_template_directory() . '/' . $string . '/';
	}

	/**
	 * Path
	 * Retrieve template directory URI for the current theme appended with the
	 * folder and trailing slash
	 *
	 * @package    OpusPrimus
	 * @since      1.3
	 *
	 * @uses       get_template_directory_uri
	 *
	 * @param $string
	 *
	 * @return string
	 */
	function path_uri( $string ) {
		return get_template_directory_uri() . '/' . $string . '/';
	}

}

/** End class - Opus Primus Router */