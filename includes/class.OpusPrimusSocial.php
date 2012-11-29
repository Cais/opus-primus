<?php
/**
 * Opus Primus Social
 * Controls for the social extensions, buttons, shares, etc.
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
 *
 * @date    November 29, 2012
 */

class OpusPrimusSocial {
    /**
     * Constructor
     *
     * @package Opus_Primus
     * @since   0.1
     *
     * @uses    add_action
     * @uses    add_filter
     */
    function __construct() {
        /** Add Google+ Contact Method */
        add_filter( 'user_contactmethods', array( $this, 'google_plus_contact_method' ) );

        /** Add Google+ Header Meta */
        add_action( 'wp_head', array( $this, 'google_plus_header_meta' ) );
    }

    /**
     * Google+ Contact Method
     * Add a Google+ ID field to the user contact method details
     *
     * @package Opus_Primus
     * @since   0.1
     *
     * @param $contactmethods
     *
     * @return object
     */
    function google_plus_contact_method( $contactmethods ) {
        if ( ! isset( $contactmethods['google_plus'] ) ) {
            $contactmethods['google_plus'] = 'Google+ ID (only)';
        }
        return $contactmethods;
    }

    /**
     * Google+ Header Meta
     * Add meta details to header of single view posts if the Google+ ID is set
     * in the user details. Only requires the Google+ ID number.
     *
     * @package Opus_Primus
     * @since   0.1
     *
     * @uses    get_current_user_id
     * @uses    get_the_author_meta
     * @uses    is_singular
     *
     * @internal Google+ ID template: https://plus.google.com/u/0/<$google_plus>/
     */
    function google_plus_header_meta() {
        if ( is_singular() ) {
            $google_plus = get_the_author_meta( 'google_plus', get_current_user_id() );
            if ( $google_plus ) {
                echo '<link rel="author" href="https://plus.google.com/u/0/' . $google_plus . '/" />' . "\n";
            }
        }
    }
}
$opus_shares = new OpusPrimusSocial();
