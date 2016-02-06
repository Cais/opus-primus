/**
 * Opus Primus Header Image Position
 * Used to re-position header to center of container when the image size is
 * greater than 50% of the container width.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2013-2016, Opus Primus
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

jQuery( document ).ready( function ( $ ) {
	/** Note: $() will work as an alias for jQuery() inside of this function */
	var image_selector = $( 'img.opus-custom-header' );

	/** Get widths of image and the parent container */
	var image_width = image_selector.width();
	var container_width = $( '.masthead' ).width();

	/**
	 * Compare widths - if the image is great than half of its parent container
	 * then center the header image and the header text (via the site-* ids)
	 */
	if ( container_width * 0.50 < image_width ) {
		$( 'h1#site-title, h2#site-description' ).css( 'text-align', 'center' );
		image_selector.addClass( 'aligncenter' );
	}
	/** End if - conditional width */

} );