<?php
/**
 * Theme Hook Alliance Support
 * Provide a bridge from the Theme Hook Alliance (THA) hooks to the relevant
 * Opus Primus hooks.
 *
 * @package     OpusPrimus
 * @subpackage  THA
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2013-2014, Opus Primus
 *
 * This file is part of Opus Primus THA, a part of Opus Primus.
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
 * @version     1.0.1
 * @date        February 21, 2013
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>` matching the THA formats
 */

/** Sanity check - make sure the hooks file exists before adding the bridges */
if ( file_exists( OPUS_STANZAS . 'tha/tha-theme-hooks.php' ) ) {

	/** Grab the THA theme hooks file */
	require_once( OPUS_STANZAS . 'tha/tha-theme-hooks.php' );

	/** @example add_action( 'opus_*', 'tha_*' ); */

	/** HTML <html> hook */
	add_action( 'opus_html_before', 'tha_html_before' );

	/** HTML <body> hooks */
	add_action( 'opus_body_top', 'tha_body_top' );
	add_action( 'opus_body_bottom', 'tha_body_bottom' );

	/** HTML <head> hooks */
	add_action( 'opus_head_top', 'tha_head_top' );
	add_action( 'opus_head_bottom', 'tha_head_bottom' );

	/** Semantic <header> hooks */
	add_action( 'opus_header_before', 'tha_header_before' );
	add_action( 'opus_header_after', 'tha_header_after' );
	add_action( 'opus_header_top', 'tha_header_top' );
	add_action( 'opus_header_bottom', 'tha_header_bottom' );

	/** Semantic <content> hooks */
	add_action( 'opus_content_before', 'tha_content_before' );
	add_action( 'opus_content_after', 'tha_content_after' );
	add_action( 'opus_content_top', 'tha_content_top' );
	add_action( 'opus_content_bottom', 'tha_content_bottom' );

	/** Semantic <entry> hooks */
	add_action( 'opus_the_loop_before', 'tha_entry_before' );
	add_action( 'opus_the_loop_after', 'tha_entry_after' );
	add_action( 'opus_get_template_part_before', 'tha_entry_top' );
	add_action( 'opus_get_template_part_after', 'tha_entry_bottom' );

	/** Comments block hooks */
	add_action( 'opus_comments_before', 'tha_comments_before' );
	add_action( 'opus_comments_after', 'tha_comments_after' );

	/** Semantic <sidebar> hooks */
	add_action( 'opus_sidebars_before', 'tha_sidebars_before' );
	add_action( 'opus_sidebars_after', 'tha_sidebars_after' );
	add_action( 'opus_first_sidebar_before', 'tha_sidebar_top' );
	add_action( 'opus_first_sidebar_after', 'tha_sidebar_bottom' );
	add_action( 'opus_second_sidebar_before', 'tha_sidebar_top' );
	add_action( 'opus_second_sidebar_after', 'tha_sidebar_bottom' );

	/** Semantic <footer> hooks */
	add_action( 'opus_footer_before', 'tha_footer_before' );
	add_action( 'opus_footer_after', 'tha_footer_after' );
	add_action( 'opus_footer_top', 'tha_footer_top' );
	add_action( 'opus_footer_bottom', 'tha_footer_bottom' );

} /** End if - file exists */