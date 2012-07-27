/**
 * Opus Primus JavaScripts
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

jQuery( document ).ready( function( $ ) {
    /** Note: $() will work as an alias for jQuery() inside of this function */
    /** Use fitText to display status update message across post */
    $( '.post.format-status div.opus-status-update' ).fitText( 1.50 );
    $( '.archive.term-post-format-status div.opus-status-update' ).fitText( 1.50 );
    /** Use fitVids to make video more responsive */
    $( 'div.post-content' ).fitVids();
    /** Add a drop shadow to make gallery images pop */
    $( '.format-gallery img.wp-post-image, .format-gallery img.attachment-thumbnail, .format-gallery .featured-image img' ).addClass( 'image-shadow' );
    /** Add a drop shadow to single attached images */
    $( '.single .attached-image img, span.archive-image img' ).addClass( 'image-shadow' );

} );