/**
 * Opus Primus Full Size Embedded Video
 * Over writes the $content_width value and adjust the height value of an
 * embed / iframe video to fill the post content area
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2013, Opus Primus
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

    /** Get the initial width and height values */
    var embed_width;
    embed_width = $('.format-video embed, .format-video iframe').attr('width');
    var embed_height;
    embed_height = $('.format-video embed, .format-video iframe').attr('height');

    /**
     * Find the ration between the height and the width to recalculate the
     * height of the embedded video
     */
    var embed_ratio;
    embed_ratio = embed_height / embed_width;

    /**
     * Change the embed / iframe video to use the full width of the post content
     */
    $('.format-video embed, .format-video iframe').attr('width','100%');

    /** Get the new width value as a number and replace the 100% value */
    var new_width;
    new_width = $('.format-video embed, .format-video iframe').width();
    $('.format-video embed, .format-video iframe').attr('width', new_width );

    /**
     * Calculate the new height by multiplying the new width times the original
     * ratio. Then change the embed / iframe video height to the new height.
     */
    var new_height;
    new_height =  new_width * embed_ratio;
    $('.format-video embed, .format-video iframe').attr('height', new_height);

} );