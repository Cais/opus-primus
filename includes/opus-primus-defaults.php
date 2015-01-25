<?php
/**
 * Opus Primus Defaults
 *
 * Set global defaults for options used in theme
 *
 * @package        OpusPrimus
 * @since          1.2.5
 *
 * @author         Opus Primus <in.opus.primus@gmail.com>
 * @copyright      Copyright (c) 2014-2015, Opus Primus
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

/**
 * Post Byline and Post Author default parameters
 *
 * These can easily be over-written by way of using the `add_filter` function
 * call within a Child-Theme and the WordPress `__return_false()` function.
 *
 * @example    add_filter( 'opus_display_author_description_bool', '__return_false' );
 */
define( 'OPUS_DISPLAY_AUTHOR_DESCRIPTION', apply_filters( 'opus_display_author_description_bool', true ) );
define( 'OPUS_DISPLAY_AUTHOR_EMAIL', apply_filters( 'opus_display_author_email_bool', true ) );
define( 'OPUS_DISPLAY_AUTHOR_URL', apply_filters( 'opus_display_author_url_bool', true ) );
define( 'OPUS_DISPLAY_MOD_AUTHOR', apply_filters( 'opus_display_mod_author_bool', true ) );

define( 'OPUS_DISPLAY_PAGE_BYLINE', apply_filters( 'opus_display_page_byline_bool', true ) );

/**
 * Gallery Parameters
 *
 * These can easily be over-written by way of using the `add_filter` function
 * call within a child theme. The below will change the number of secondary
 * images used (those below the large gallery featured image) to five (5) images:
 *
 * @example    function new_number_of_images() { return 5; }
 * @example    add_filter( 'opus_number_of_secondary_images_value', 'new_number_of_images' );
 */
define( 'OPUS_NUMBER_OF_SECONDARY_IMAGES', apply_filters( 'opus_number_of_secondary_images_value', 3 ) );