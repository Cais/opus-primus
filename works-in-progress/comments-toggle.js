/**
 * Opus Primus Comments Toggle
 * Hides comments form when there are no comments until end user clicks to begin
 *
 * @package     OpusPrimus
 * @since       0.1
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
 *
 * @todo Add documentation to clarify what is happening
 */

jQuery( document ).ready( function( $ ) {
    /** Note: $() will work as an alias for jQuery() inside of this function */
    $( document ).ready( function() {
        /** Add id to link to from index page */
        $( '.comments-wrapper' ).attr( 'id', 'comments-toggle-respond' );

        // var linkage = $('a.comments-link').attr('href').replace('#respond','#comments-toggle-respond');
        // alert (linkage);
        $('a.comments-link').attr('href').replace('#respond','#comments-toggle-respond');

        /** Add Question Mark cursor as a visual aid */
        $( 'span.no-comments-message' ).addClass( 'question-mark' );
        /** Start toggle class as closed then use click function to change */
        $( 'span.no-comments-message + div#respond' ).addClass( 'closed' );
        $( 'span.no-comments-message' ).click( function() {
            $( 'span.no-comments-message + div#respond' ).toggleClass( "open" ).toggleClass( "closed" );
        } );
    } );
} );
