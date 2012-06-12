<?php
/**
 * Opus Primus Gallery
 * Gallery and other related image functionality
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

class OpusPrimusGallery {

    /** Construct */
    function __construct() {

    }

    /**
     * Opus Primus Featured Image
     * If a featured image is assigned then return it's ID
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_thumb_id
     * @uses    do_action
     * @uses    get_children
     * @uses    get_post_thumbnail_id
     * @uses    has_post_thumbnail
     * @uses    the_post_thumbnail
     * @uses    wp_get_attachment_image
     *
     * @return  int|string - featured image ID
     */
    function featured_image() {
        global $opus_thumb_id;

        /** Add empty hook before featured image */
        do_action( 'opus_before_featured_image' );

        /**
         * @var $size - standard WordPress image size; large as the intent is
         * to use as the featured image for gallery posts
         */
        $size = 'large';
        if ( has_post_thumbnail() ) {
            /** use the thumbnail ("featured image") */
            /** @var $opus_thumb_id int|string */
            $opus_thumb_id = get_post_thumbnail_id();
            the_post_thumbnail( $size ); // whatever size you want
        } else {
            $attachments = get_children( array(
                    'post_parent'       => get_the_ID(),
                    'post_status'       => 'inherit',
                    'post_type'         => 'attachment',
                    'post_mime_type'    => 'image',
                    'order'             => 'ASC',
                    'orderby'           => 'menu_order ID',
                    'numberposts'       => 1
                ) );
            foreach ( $attachments as $opus_thumb_id => $attachment )
                echo wp_get_attachment_image( $opus_thumb_id, $size );
        }

        /** Add empty hook after featured image */
        do_action( 'opus_after_featured_image' );

    }

    /**
     * Opus Primus Secondary Images
     * Displays additional images from the gallery while excluding the image
     * with ID = $opus_thumb_id
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_thumb_id
     * @uses    WP_Query
     * @uses    do_action
     * @uses    get_permalink
     * @uses    get_the_ID
     * @uses    wp_get_attachment_image
     */
    function secondary_images() {
        global $opus_thumb_id;

        /** Add empty hook before secondary images */
        do_action( 'opus_before_secondary_images' );

        $images = new WP_Query( array(
            'post_parent'               => get_the_ID(),
            'post_status'               => 'inherit',
            'post_type'                 => 'attachment',
            'post_mime_type'            => 'image',
            'order'                     => 'ASC',
            'orderby'                   => 'menu_order ID',
            'posts_per_page'            => 3,
            'post__not_in'              => array( $opus_thumb_id ),
            'update_post_term_cache'    => false,
        ) );

        /**
         * @var $size - standard WordPress image size; thumbnail in this case
         * as the intent is to use these images as additional from gallery
         */
        $size = 'thumbnail';

        foreach ( $images->posts as $image ) {
            echo '<a href="' . get_permalink( $image->ID ) . '">' . wp_get_attachment_image( $image->ID, $size ) . '</a>';
        }

        /**
         * @todo Add link to gallery anchored on "this gallery" or "more images"
         * @todo Add some style to this!
         */
        if ( ( $images->found_posts + 1 ) > 4 ) {
            printf( '<br />' . __( 'There are %1$s more images in addition to these in this gallery.', 'opusprimus' ), ( $images->found_posts + 1 ) - 4 );
        }

        /** Add empty hook after secondary images */
        do_action( 'opus_after_secondary_images' );

    }

}
$opus_gallery = new OpusPrimusGallery();