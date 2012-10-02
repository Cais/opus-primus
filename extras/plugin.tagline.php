<?php
/** Add Meta Boxes */
add_action( 'add_meta_boxes', 'opus_plugin_tagline_boxes' );

/** Create Meta Boxes */
function opus_plugin_tagline_boxes() {
    add_meta_box(
        'opus_plugin_tagline_id',
        'Opus Plugin Post Tagline',
        'opus_plugin_tagline_callback',
        'post',
        'advanced',
        'default',
        null
    );
    add_meta_box(
        'opus_plugin_tagline_id',
        'Opus Plugin Page Tagline',
        'opus_plugin_tagline_callback',
        'page',
        'advanced',
        'default',
        null
    );
}

/** Callback - HTML used to display Meta Box */
function opus_plugin_tagline_callback() {
    echo '<label for="opus_plugin_tagline_field">';
        _e( 'Enter Your Tagline Here:', 'opus_plugin' );
    echo '</label>';
    echo '<input type="text" id="opus_plugin_tagline_field" name="opus_plugin_tagline_field" value="Testing? Remove this later?" size="100%" />';
}

/** Display - untested */
function opus_plugin_tagline_display( $post_id ) {
    return get_post_meta( $post_id, 'opus_plugin_template_id' );
}