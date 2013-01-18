<?php
/**
 * Opus Primus Meta Boxes
 * Add meta boxes to various places in the administration panels
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

class OpusPrimusMetaBoxes {
    /** Constructor */
    function __construct() {
        /** Add taglines meta boxes */
        add_action( 'add_meta_boxes', array( $this, 'tagline_create_boxes' ) );

        /** Save tagline data entered */
        add_action( 'save_post', array( $this, 'tagline_save_postdata' ) );

        /** Send tagline to screen after post title */
        add_action( 'opus_after_post_title', array( $this, 'tagline_output' ) );
    } /** End function - construct */

    /**
     * Create Tagline Boxes
     * Create Meta Boxes for use with the taglines feature
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $post (global) - post_type
     * @uses    add_meta_box
     * @internal used with action hook add_meta_boxes
     */
    function tagline_create_boxes() {
        global $post;
        /** May not work with attachments */
        if ( 'attachment' <> $post->post_type ) {
            add_meta_box(
                'opus_tagline',
                apply_filters( 'opus_taglines_meta_box_title', sprintf( __( '%1$s Tagline', 'opusprimus' ), ucfirst( $post->post_type ) ) ),
                array( $this, 'tagline_callback' ),
                $post->post_type,
                'advanced',
                'default',
                null
            );
        } /** End if - attachment */
    } /** End function - tagline create boxes */


    /**
     * Tagline Callback
     * Used to display text field box on edit page
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   $post -> ID, post_type
     *
     * @uses    get_post_meta
     */
    function tagline_callback( $post ) {
        /** Create and display input for tagline text field */
        echo '<label for="tagline_text_field">';
            echo apply_filters( 'opus_taglines_text_field_description', sprintf( __('Add custom tagline to this %1$s: ', 'opusprimus' ), $post->post_type ) );
        echo '</label>';
        echo '<input type="text" id="tagline_text_field" name="tagline_text_field" value="' . get_post_meta( $post->ID, 'tagline_text_field', true ) . '" size="100%" />';
    } /** End function - tagline callback */


    /**
     * Tagline Save Postdata
     * Save tagline text field data entered via callback
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   $post_id
     *
     * @uses    (constant) DOING_AUTOSAVE
     * @uses    check_admin_referrer
     * @uses    current_user_can
     * @uses    update_post_meta
     */
    function tagline_save_postdata( $post_id ) {
        /** If this is an auto save routine we do not want to do anything */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        } /** End if - DOING AUTOSAVE */

        /** Check if this is a new post and if user can edit pages */
        if ( isset( $_POST['post_type'] ) && ( 'page' == $_POST['post_type'] ) ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            } /** End if - not current user can */
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            } /** End if - not current user can */
        } /** End if - isset */

        /** If tagline is set, save and update the post meta data */
        if ( isset( $_POST['tagline_text_field'] ) ) {
            $tagline_text = $_POST['tagline_text_field'];
            update_post_meta( $post_id, 'tagline_text_field', $tagline_text );
        } /** End if - isset */

    } /** End function - tagline save postdata */


    /**
     * Tagline Output
     * Create output to be used
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $post (global) - ID, post_type
     * @uses    apply_filters
     * @uses    get_post_meta
     */
    function tagline_output() {
        /** Since we are not inside the loop grab the global post object */
        global $post;
        $tagline = apply_filters( 'opus_tagline_output_' . $post->ID, get_post_meta( $post->ID, 'tagline_text_field', true ) );

        /** Make sure there is a tagline before sending anything to the screen */
        if ( ! empty( $tagline ) ) {
            echo '<div class="opus-primus-' . $post->post_type . '-tagline">' . $tagline . '</div>';
        } /** End if - not empty */

    } /** End function - tagline output */

} /** End Opus Primus Meta Boxes class */

/** @var $opus_meta_boxes - new instance of class */
$opus_meta_boxes = new OpusPrimusMetaBoxes();