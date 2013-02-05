<?php
/**
 * Theme Hook Alliance Support
 * Provide a bridge from the Theme Hook Alliance (THA) hooks to the relevant
 * Opus Primus hooks.
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

/** Grab the THA theme hooks file */
require_once( OPUS_STANZAS . 'tha/tha-theme-hooks.php' );

/**
 * @todo Change all of the do_action calls to add_action calls with the appropriate opus_* hooks
 * @example add_action( 'opus_*', 'tha_*' );
 */

/** HTML <html> hook */
do_action( 'tha_html_before' );

/** HTML <body> hooks */
do_action( 'tha_body_top' );
do_action( 'tha_body_bottom' );

/** HTML <head> hooks */
do_action( 'tha_head_top' );
do_action( 'tha_head_bottom' );

/** Semantic <header> hooks */
do_action( 'tha_header_before' );
do_action( 'tha_header_after' );
do_action( 'tha_header_top' );
do_action( 'tha_header_bottom' );

/** Semantic <content> hooks */
do_action( 'tha_content_before' );
do_action( 'tha_content_after' );
do_action( 'tha_content_top' );
do_action( 'tha_content_bottom' );

/** Semantic <entry> hooks */
do_action( 'tha_entry_before' );
do_action( 'tha_entry_after' );
do_action( 'tha_entry_top' );
do_action( 'tha_entry_bottom' );

/** Comments block hooks */
do_action( 'tha_comments_before' );
do_action( 'tha_comments_after' );

/** Semantic <sidebar> hooks */
do_action( 'tha_sidebars_before' );
do_action( 'tha_sidebars_after' );
do_action( 'tha_sidebar_top' );
do_action( 'tha_sidebar_bottom' );

/** Semantic <footer> hooks */
do_action( 'tha_footer_before' );
do_action( 'tha_footer_after' );
do_action( 'tha_footer_top' );
do_action( 'tha_footer_bottom' );