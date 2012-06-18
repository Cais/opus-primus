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
     * If a featured image is assigned then return it's ID; wrap it in anchor
     * tags if not in the single view, otherwise just output the picture itself
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $size - thumbnail|medium|large|full (default WordPress image sizes)
     *
     * @uses    (global) $opus_thumb_id
     * @uses    do_action
     * @uses    get_children
     * @uses    get_permalink
     * @uses    get_post_thumbnail_id
     * @uses    get_the_ID
     * @uses    has_post_thumbnail
     * @uses    the_post_thumbnail
     * @uses    the_title_attribute
     * @uses    wp_get_attachment_image
     *
     * @return  int|string - featured image ID
     */
    function featured_image( $size = 'large' ) {
        global $opus_thumb_id;

        /** Add empty hook before featured image */
        do_action( 'opus_before_featured_image' );

        /**
         * @var $size - standard WordPress image size; large as the intent is
         * to use as the featured image for gallery posts
         */
        if ( has_post_thumbnail() ) {
            /** use the thumbnail ("featured image") */
            /** @var $opus_thumb_id int|string */
            $opus_thumb_id = get_post_thumbnail_id();
            if ( ! is_single() ) {
                echo '<p class="featured-image"><a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ), 'echo' => '0' ) ) . '">';
                the_post_thumbnail( $size );
                echo '</a></p>';
            } else {
                the_post_thumbnail( $size );
            }
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
                if ( ! is_single() ) {
                echo '<p class="featured-image"><a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ), 'echo' => '0' ) ) . '">'
                    . wp_get_attachment_image( $opus_thumb_id, $size )
                    . '</a></p>';
                } else {
                    echo wp_get_attachment_image( $opus_thumb_id, $size );
                }
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
     * @uses    the_title_attribute
     * @uses    wp_get_attachment_image
     * @uses    wp_parse_args
     */
    function secondary_images( $secondary_images_args = '' ) {
        global $opus_thumb_id;

        /** Set defaults */
        $defaults = array(
            'order'     => 'ASC',
            'orderby'   => 'menu_order ID',
            'images'    => 3,
        );
        $secondary_images_args = wp_parse_args( (array) $secondary_images_args, $defaults );


        /** Add empty hook before secondary images */
        do_action( 'opus_before_secondary_images' );

        $images = new WP_Query( array(
            'post_parent'               => get_the_ID(),
            'post_status'               => 'inherit',
            'post_type'                 => 'attachment',
            'post_mime_type'            => 'image',
            'order'                     => $secondary_images_args['order'],
            'orderby'                   => $secondary_images_args['orderby'],
            'posts_per_page'            => $secondary_images_args['images'],
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
         * Display a message indicating if more images are in the gallery than
         * what are displayed in the post stream. If more images are in the
         * gallery the text showing how many more will link to the single post.
         */
        if ( ( $images->found_posts + 1 ) > ( $secondary_images_args['images'] + 1 ) ) {
            printf( '<p class="more-images">%1$s</p>',
                sprintf( _n(
                    __( 'There is %2$sone more image%3$s in addition to these in the gallery.', 'opusprimus' ),
                    __( 'There are %2$s%1$s more images%3$s in addition to these in the gallery.', 'opusprimus' ),
                    ( $images->found_posts + 1 ) - ( $secondary_images_args['images'] + 1 ) ),
                ( $images->found_posts + 1 ) - ( $secondary_images_args['images'] + 1 ),
                '<a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ), 'echo' => '0' ) ) . '">',
                '</a>' ) );
        }

        /** Add empty hook after secondary images */
        do_action( 'opus_after_secondary_images' );

    }


    function image_exif() {
        global $post;

        /** @var $image_meta - EXIF information from image */
        $image_meta = wp_get_attachment_metadata();

        /** Wrap the exif output in its own container */
        echo '<div class="image-exif">';

        /** Link to original image with size displayed */
        if ( $image_meta['width'] && $image_meta['height']  ) {
            echo '<div class="image-exif_dimensions">'
                . sprintf( __( '%1$s (Size: %2$s by %3$s)', 'opusprimus' ),
                    '<a href="' . wp_get_attachment_url( $post->ID ) . '">' . sprintf( __( 'Original image', 'opusprimus' ) ) . '</a>',
                    $image_meta['width'] . 'px',
                    $image_meta['height'] . 'px' )
                . '</div>';
        }

        /** Author Credit with Copyright details */
        if ( $image_meta['image_meta']['credit'] ) {
            echo '<br />' . sprintf( __( 'Credit: %1$s', 'opusprimus' ), $image_meta['image_meta']['credit'] );
        }
        if ( $image_meta['image_meta']['credit'] && $image_meta['image_meta']['copyright'] ) {
            echo ' ';
        }
        if ( $image_meta['image_meta']['copyright'] ) {
            printf( '&copy; %1$s %2$s', get_the_time( 'Y' ), $image_meta['image_meta']['copyright'] );
        }

        /** Creation timestamp in end-user settings format */
        if ( $image_meta['image_meta']['created_timestamp'] ) {
            echo '<br />'
                . sprintf( __( 'Created (timestamp): %1$s @ %2$s', 'opusprimus' ),
                    get_the_time( get_option( 'date_format' ), $image_meta['image_meta']['created_timestamp'] ),
                    get_the_time ( get_option( 'time_format' ), $image_meta['image_meta']['created_timestamp'] )
                );
        }

        /** Camera details */
        if ( $image_meta['image_meta']['camera'] ) {
            echo '<br />' . sprintf( __( 'Camera: %1$s', 'opusprimus' ), $image_meta['image_meta']['camera'] );
        }

        /** Shutter speed */
        if ( $image_meta['image_meta']['shutter_speed'] ) {
            echo ' ';
            echo '<br />'
                . __( 'Shutter speed:', 'opusprimus' )
                . ' ';
            /** Shutter Speed Handler - "sec" is used as the short-form for time measured in seconds */
            if ( ( 1 / $image_meta['image_meta']['shutter_speed'] ) > 1 ) {
                echo "1/";
                if ( number_format( ( 1 / $image_meta['image_meta']['shutter_speed'] ), 1 ) ==  number_format( ( 1 / $image_meta['image_meta']['shutter_speed'] ), 0 ) ) {
                    echo number_format( ( 1 / $image_meta['image_meta']['shutter_speed'] ), 0, '.', '' ) . ' ' . __( 'sec', 'opusprimus' );
                } else {
                    echo number_format( ( 1 / $image_meta['image_meta']['shutter_speed'] ), 1, '.', '' ) . ' ' . __( 'sec', 'opusprimus' );
                }
            } else {
                echo $image_meta['image_meta']['shutter_speed'] . ' ' . __( 'sec', 'opusprimus' );
            }
        }

        /** Aperture Setting */
        if ( $image_meta['image_meta']['aperture'] ) {
            echo '<br />' . sprintf( __( 'Aperture (F-stop): %1$s', 'opusprimus' ), $image_meta['image_meta']['aperture'] );
        }

        /** Image caption from EXIF details */
        if ( $image_meta['image_meta']['caption'] ) {
            echo '<br />' . sprintf( __( 'Caption: %1$s', 'opusprimus' ), $image_meta['image_meta']['caption'] );
        }

        /** Focal Length - "mm" is used as the short-form for millimeters */
        if ( $image_meta['image_meta']['focal_length'] ) {
            echo '<br />' . sprintf( __( 'Focal Length: %1$s', 'opusprimus' ), $image_meta['image_meta']['focal_length'] ) . 'mm';
        }

        /** ISO Speed */
        if ( $image_meta['image_meta']['iso'] ) {
            echo '<br />' . sprintf( __( 'Speed: ISO %1$s', 'opusprimus' ), $image_meta['image_meta']['iso'] );
        }

        /** Title from EXIF details */
        if ( $image_meta['image_meta']['title'] ) {
            echo '<br />' . sprintf( __( 'Title: %1$s', 'opusprimus' ), $image_meta['image_meta']['title'] );
        }

        echo '</div><!-- .image-exif -->';
    }

}
$opus_gallery = new OpusPrimusGallery();