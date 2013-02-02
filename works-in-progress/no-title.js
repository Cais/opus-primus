/**
 * Opus Primus No Title
 * If a page is created without a title the default `wp_list_pages` will display
 * a blank in its place. This script provides a title in the form of the page's
 * post ID. (This only works with the default permalinks.)
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
 */

jQuery( document ).ready( function( $ ) {
    /** Note: $() will work as an alias for jQuery() inside of this function */

    var selector = $('header nav ul.nav-menu li.page_item a');

    selector.each(function() {
        if ($(this).text() == "") {
            //Do Something
            var postage = selector.attr('href');
            var postage_id = postage.split('?');
            var postage_id_number = postage_id[1].split('=');
            $(this).html('Page-' + postage_id_number[1]);
        }
    });

} );
