/**
 * Opus Primus SlickNav initialization script
 * Initializes the SlickNav JavaScript using the `nav-menu` class
 *
 * @package        OpusPrimus
 * @subpackage    Mobile_Menu
 * @since        1.3
 *
 * @author        Opus Primus <in.opus.primus@gmail.com>
 * @copyright    Copyright (c) 2014-2015, Opus Primus
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
 * @version     1.3.4
 * @date        March 11,2015
 * Used a more specific element identifier for the `prependTo` parameter
 */
jQuery(document).ready(function ($) {
	/** Note: $() will work as an alias for jQuery() inside of this function */
	$('.nav-menu').slicknav({
		prependTo: 'header > nav'
	});
});