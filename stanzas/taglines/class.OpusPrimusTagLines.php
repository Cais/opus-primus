<?php

/**
 * Opus Primus TagLines
 * Add a meta box for a tagline to various places in the administration panels
 *
 * @package     OpusPrimus
 * @subpackage  TagLines
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2014, Opus Primus
 *
 * This file is part of Opus Primus Taglines, a part of Opus Primus.
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
 * Re-order methods: action and filter calls by request order, then alphabetical
 * Modified action hook call to use current standard
 *
 * @version     1.0.3
 * @date        February 28, 2013
 * Changed name from "Meta_Boxes" to "TagLines" and moved to Stanzas
 */
class OpusPrimusTagLines {
	/**
	 * Constructor
	 *
	 * @package        OpusPrimus
	 * @sub-package    TagLines
	 * @since          0.1
	 *
	 * @uses           add_action
	 */
	function __construct() {
		/** Enqueue Styles */
		add_action(
			'wp_enqueue_scripts', array(
				$this,
				'scripts_and_styles'
			)
		);

		/** Add taglines meta boxes */
		add_action( 'add_meta_boxes', array( $this, 'tagline_create_boxes' ) );

		/** Save tagline data entered */
		add_action( 'save_post', array( $this, 'tagline_save_postdata' ) );

		/** Send tagline to screen after post title */
		add_action( 'opus_post_title_after', array( $this, 'tagline_output' ) );

		/** Set Opus Primus Tagline stanza off by default */
		add_filter(
			'default_hidden_meta_boxes', array(
				$this,
				'default_screen_option'
			), 10, 2
		);

	} /** End function - construct */


	/** ---- Action and Filter Methods ---- */


	/**
	 * Enqueue Scripts and Styles
	 * Use to enqueue the extension scripts and stylesheets, if they exists
	 *
	 * @package            OpusPrimus
	 * @subpackage         TagLines
	 * @since              1.0.3
	 *
	 * @uses    (CONSTANT) OPUS_STANZAS_URI
	 * @uses               opus_primus_theme_version
	 * @uses               wp_enqueue_script
	 * @uses               wp_enqueue_style
	 * @uses               wp_get_theme
	 *
	 * @version            1.2.4
	 * @date               May 17, 2014
	 * Use `opus_primus_theme_version` in place of `wp_get_theme` call
	 */
	function scripts_and_styles() {
		/** Enqueue Styles */
		/** Enqueue Taglines Stanza Stylesheets */
		wp_enqueue_style( 'Opus-Primus-TagLines', OPUS_STANZAS_URI . 'taglines/opus-primus.taglines.css', array(), opus_primus_theme_version(), 'screen' );
	} /** End function - scripts and styles */


	/**
	 * Create Tagline Boxes
	 * Create Meta Boxes for use with the taglines feature
	 *
	 * @package           OpusPrimus
	 * @since             0.1
	 *
	 * @uses              OpusPrimusTagLines::tagline_callback
	 * @uses     (GLOBAL) $post - post_type
	 * @uses              add_meta_box
	 *
	 * @internal          used with action hook add_meta_boxes
	 *
	 * @version           1.2.5
	 * @date              July 27, 2014
	 * Refactored to clarify the parameter usage
	 */
	function tagline_create_boxes() {
		global $post;

		/** May not work with attachments */
		if ( 'attachment' <> $post->post_type ) {
			/** @var string $context - valid values: advanced, normal, or side */
			$context = 'normal';
			/** @var string $priority - valid values: default, high, low, or core */
			$priority = 'high';

			/** $context / $priority = normal / high should put this above revisions on the editor pages */

			add_meta_box(
				'opus_tagline',
				apply_filters( 'opus_taglines_meta_box_title', sprintf( __( '%1$s Tagline', 'opus-primus' ), ucfirst( $post->post_type ) ) ),
				array( $this, 'tagline_callback' ),
				$post->post_type,
				$context,
				$priority,
				null
			);
		}
		/** End if - attachment */

	} /** End function - tagline create boxes */


	/**
	 * Tagline Save Postdata
	 * Save tagline text field data entered via callback
	 *
	 * @package            OpusPrimus
	 * @since              0.1
	 *
	 * @param   $post_id
	 *
	 * @uses    (CONSTANT) DOING_AUTOSAVE
	 * @uses               check_admin_referrer
	 * @uses               current_user_can
	 * @uses               update_post_meta
	 */
	function tagline_save_postdata( $post_id ) {
		/** If this is an auto save routine we do not want to do anything */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		/** End if - DOING AUTOSAVE */

		/** Check if this is a new post and if user can edit pages */
		if ( isset( $_POST['post_type'] ) && ( 'page' == $_POST['post_type'] ) ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
			/** End if - not current user can */
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			/** End if - not current user can */
		}
		/** End if - isset */

		/** If tagline is set, save and update the post meta data */
		if ( isset( $_POST['tagline_text_field'] ) ) {
			$tagline_text = $_POST['tagline_text_field'];
			update_post_meta( $post_id, 'tagline_text_field', $tagline_text );
		}
		/** End if - isset */

	} /** End function - tagline save postdata */


	/**
	 * Tagline Output
	 * Create output to be used
	 *
	 * @package          OpusPrimus
	 * @since            0.1
	 *
	 * @uses    (GLOBAL) $post - ID, post_type
	 * @uses             apply_filters
	 * @uses             get_post_meta
	 *
	 * @version          1.2.4
	 * @date             May 19, 2014
	 * Separated the output class into two different classes
	 */
	function tagline_output() {
		/** Since we are not inside the loop grab the global post object */
		global $post;
		$tagline = apply_filters( 'opus_tagline_output_' . $post->ID, get_post_meta( $post->ID, 'tagline_text_field', true ) );

		/** Make sure there is a tagline before sending anything to the screen */
		if ( ! empty( $tagline ) ) {
			echo '<div class="opus-primus-tagline"><span class="' . $post->post_type . '-tagline">' . $tagline . '</span></div>';
		}
		/** End if - not empty */

	} /** End function - tagline output */


	/** ---- Additional Methods ---- */


	/**
	 * Tagline Callback
	 * Used to display text field box on edit page
	 *
	 * @package OpusPrimus
	 * @since   0.1
	 *
	 * @param   $post -> ID, post_type
	 *
	 * @uses    __
	 * @uses    apply_filters
	 * @uses    get_post_meta
	 */
	function tagline_callback( $post ) {
		/** Create and display input for tagline text field */
		echo '<label for="tagline_text_field">';
		echo apply_filters( 'opus_taglines_text_field_description', sprintf( __( 'Add custom tagline to this %1$s: ', 'opus-primus' ), $post->post_type ) );
		echo '</label>';
		echo '<input type="text" id="tagline_text_field" name="tagline_text_field" value="' . get_post_meta( $post->ID, 'tagline_text_field', true ) . '" size="100%" />';

	} /** End function - tagline callback */


	/**
	 * Default Screen Option
	 * Used to set Opus Primus Tagline off by default in editor screen options
	 *
	 * @package       OpusPrimus
	 * @subpackage    TagLines
	 * @since         1.2.5
	 *
	 * @param $hidden
	 * @param $screen
	 *
	 * @return array
	 */
	function default_screen_option( $hidden, $screen ) {

		/** Add `opus_tagline` to default hidden screen options array */
		$hidden[] = 'opus_tagline';

		return $hidden;

	}
	/** End function - default screen option */


}

/** End Opus Primus TagLines class */

/** @var $opus_taglines - new instance of class */
$opus_taglines = new OpusPrimusTagLines();