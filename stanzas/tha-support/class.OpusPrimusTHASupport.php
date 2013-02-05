<?php
/**
 * Opus Primus THA Support
 * Support for the Theme Hook Alliance system of action hooks
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

class OpusPrimusTHASupport {

    /** Constructor */
    function __construct() {

        /** Pull in the main THA Theme Hooks file */
        require_once( OPUS_STANZAS . 'tha-support/tha-theme-hooks.php' );

        /** Hook after the main theme setup is done */
        add_action( 'after_theme_setup', array( $this, 'tha_in_opusprimus' ), 11 );

    }


    /**
     * THA in Opus Primus
     * Match up hooks in THA to existing hooks in Opus Primus then use
     * function to hook into `after_theme_setup`
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     *
     * @internal Directly related to THA v1.0
     */
    function tha_in_opusprimus() {

        /** Add all hooks */
        do_action( 'opus_before_html', 'tha_html_before' );
        do_action( 'opus_body_top', 'tha_body_top' );
        do_action( 'opus_body_bottom', 'tha_body_bottom' );
        do_action( 'tha_head_top' );
        do_action( 'tha_head_bottom' );
        do_action( 'tha_header_before' );
        do_action( 'tha_header_after' );
        do_action( 'tha_header_top' );
        do_action( 'tha_header_bottom' );
        do_action( 'tha_content_before' );
        do_action( 'tha_content_after' );
        do_action( 'opus_content_top', 'tha_content_top' );
        do_action( 'opusC_content_bottom', 'tha_content_bottom' );
        do_action( 'tha_entry_before' );
        do_action( 'tha_entry_after' );
        do_action( 'tha_entry_top' );
        do_action( 'tha_entry_bottom' );
        do_action( 'tha_comments_before' );
        do_action( 'tha_comments_after' );
        do_action( 'opus_before_sidebars', 'tha_sidebars_before' );
        do_action( 'opus_after_sidebars', 'tha_sidebars_after' );
        do_action( 'tha_sidebar_top' );
        do_action( 'tha_sidebar_bottom' );
        do_action( 'tha_footer_before' );
        do_action( 'tha_footer_after' );
        do_action( 'tha_footer_top' );
        do_action( 'tha_footer_bottom' );


    } /** End function - tha in opus primus */


} /** End class - THA Support */


/** @var $tha_support - new instance of class */
$tha_support = new OpusPrimusTHASupport();