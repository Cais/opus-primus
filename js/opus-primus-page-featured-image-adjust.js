/**
 * Opus Primus Page Featured Image Adjust Script
 * Adjusts the featured image width and height to a golden ratio based on the
 * page content area width
 *
 * @package     OpusPrimus
 * @since       1.2
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2013, Opus Primus
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

jQuery( document ).ready( function( $ ) {
    /** Note: $() will work as an alias for jQuery() inside of this function */

    /** Get the page content width */
    var page_content = $( 'body.page div.the-loop div.page');

    var page_width = page_content.width();
    alert( page_width );

    var golden_height = page_width / 1.618;
    alert( golden_height );

    /** Get the image width */
    var featured_image = $( 'body.page div.page a.featured-thumbnail img' );
    var featured_image_width = featured_image.attr( 'width' );
    alert(featured_image_width);

    var featured_image_height = featured_image.attr( 'height' );
    alert(featured_image_height);

    if ( ( featured_image_width / 1.618 ) < golden_height ) {
        alert( 'featured_image_width: ' + featured_image_width )
        featured_image.attr( 'width', golden_height );
        featured_image.attr( 'height', 'auto' );
    }

} );