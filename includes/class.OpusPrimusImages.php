<?php
/**
 * Opus Primus Images
 * Image related functionality
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

class OpusPrimusImages {

    /** Construct */
    function __construct(){

    }

    /**
     * Opus Primus EXIF Data
     * Returns an object containing the EXIF data found in an image if it exists
     * otherwise it returns null.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_data
     * @uses    wp_get_attachment_metadata
     *
     * @return object|null
     */
    function exif_data() {
        global $opus_image_meta;

        /** @var $opus_image_meta - EXIF information from image */
        $opus_image_meta = wp_get_attachment_metadata();

        if ( isset( $opus_image_meta ) ) {
            return $opus_image_meta;
        } else {
            return null;
        }
    }

    /**
     * Opus Primus Image Dimensions
     * Outputs the original/full width and height of the image being displayed
     * with a link to the image itself.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_meta
     * @uses    (global) $post
     * @uses    do_action
     * @uses    wp_get_attachment_url
     */
    function dimensions() {
        /** Get the post and image meta object */
        global $post, $opus_image_meta;

        /** Add empty hook before dimension */
        do_action( 'opus_before_dimensions' );

        $width = $opus_image_meta['width'];
        $height = $opus_image_meta['height'];

        /** Link to original image with size displayed */
        if ( $width && $height ) {
            echo '<div class="image-dimensions">'
                . sprintf( __( '%1$s (Size: %2$s by %3$s)', 'opusprimus' ),
                    '<a href="' . wp_get_attachment_url( $post->ID ) . '">' . sprintf( __( 'Original image', 'opusprimus' ) ) . '</a>',
                    $width . 'px',
                    $height . 'px' )
                . '</div>';
        }

        /** Add empty hook after dimension */
        do_action( 'opus_after_dimensions' );

    }

    /**
     * Opus Primus Image Copyright
     * Returns a string containing the owner and copyright text
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) #opus_image_meta
     * @uses    do_action
     * @uses    get_the_time
     *
     * @return string
     */
    function image_copyright() {
        /** Get the image meta object */
        global $opus_image_meta;

        /** Add empty hook before image copyright */
        do_action( 'opus_before_image_copyright' );

        /** @var $copyright - initialize the copyright string */
        $copyright = '';
        /** Author Credit with Copyright details */
        if ( $opus_image_meta['image_meta']['credit'] ) {
            $copyright .= sprintf( __( 'Credit: %1$s', 'opusprimus' ), $opus_image_meta['image_meta']['credit'] );
        }
        if ( $opus_image_meta['image_meta']['credit'] && $opus_image_meta['image_meta']['copyright'] ) {
            $copyright .= ' ';
        }
        if ( $opus_image_meta['image_meta']['copyright'] ) {
            $copyright .= sprintf( __( '&copy; %1$s %2$s', 'opusprimus' ), get_the_time( 'Y' ), $opus_image_meta['image_meta']['copyright'] );
        }

        /** Add empty hook after image copyright */
        do_action( 'opus_after_image_copyright' );

        return $copyright;
    }


    /**
     * @todo re-factor the image_exif into separate functions
     */
    function image_exif() {
        global $post;

        /** @var $image_meta - EXIF information from image */
        $image_meta = wp_get_attachment_metadata();

        /** Wrap the exif output in its own container */
        echo '<div class="image-exif">';

        /** Link to original image with size displayed */
        if ( $image_meta['width'] && $image_meta['height']  ) {
            echo '<div class="image-dimensions">'
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
$ops_image = new OpusPrimusImages();