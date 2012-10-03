<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ecaissie
 * Date: 10/3/12
 * Time: 10:09 AM
 * To change this template use File | Settings | File Templates.
 */

/** Add meta boxes */
add_action( 'add_meta_boxes', 'create_tagline_boxes' );

/** Do something with the data entered */
add_action( 'save_post', 'tagline_save_postdata' );

/** Send the tagline to the screen after the post title */
add_action( 'opus_after_post_title', 'tagline_output' );

/** Create Meta Boxes */
function create_tagline_boxes() {
    add_meta_box(
        'opus_tagline',
        'Post Tagline',
        'tagline_callback',
        'post',
        'advanced',
        'default',
        null
    );
    add_meta_box(
        'opus_tagline',
        'Page Tagline',
        'tagline_callback',
        'page',
        'advanced',
        'default',
        null
    );
}

/** Callback - show something */
function tagline_callback( $post ) {
    // Use nonce for verification
    // wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

    /** Create and display input for tagline text field */
    echo '<label for="tagline_text_field">';
        _e( 'Tagline: ', 'opusprimus' );
    echo '</label>';
    echo '<input type="text" id="tagline_text_field" name="tagline_text_field" value="' . get_post_meta( $post->ID, 'tagline_text_field', true ) . '" size="100%" />';
}

/** Save custom data */
function tagline_save_postdata( $post_id ) {
    /** If this is an auto save routine we do not want to do anything */
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    // if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) ) return;


    /**  Check user permissions on edit pages */
    if ( 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return;
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;
    }

    /** Save and update the data */
    $tagline_text = $_POST['tagline_text_field'];
    update_post_meta( $post_id, 'tagline_text_field', $tagline_text );
}

/** Create output to be used */
function tagline_output() {
    global $post;
    $tagline = apply_filters( 'opus_primus_tagline_output' , get_post_meta( $post->ID, 'tagline_text_field', true ) );
    /** Make sure there is a tagline before sending anything to the screen */
    if ( ! empty( $tagline ) ) {
        echo '<span class="opus-primus-post-tagline">' . $tagline . '</span>';
    }
}