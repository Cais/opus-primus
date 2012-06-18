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
     * Opus Primus EXIF Dimensions
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
    function exif_dimensions() {
        /** Get the post and image meta object */
        global $post, $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF dimension */
        do_action( 'opus_before_exif_dimensions' );

        $dimensions = '';
        $width = $opus_image_meta['width'];
        $height = $opus_image_meta['height'];

        /** Link to original image with size displayed */
        if ( $width && $height ) {
            $dimensions .= '<div class="exif-dimensions">'
                . sprintf( __( '%1$s (Size: %2$s by %3$s)', 'opusprimus' ),
                    '<a href="' . wp_get_attachment_url( $post->ID ) . '">' . sprintf( __( 'Original image', 'opusprimus' ) ) . '</a>',
                    $width . 'px',
                    $height . 'px' )
                . '</div>';
        }

        echo apply_filters( 'exif_dimensions', $dimensions );

        /** Add empty hook after EXIF dimension */
        do_action( 'opus_after_exif_dimensions' );

    }

    /**
     * Opus Primus EXIF Copyright
     * Outputs a string containing the author and copyright text
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
    function exif_copyright() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF copyright */
        do_action( 'opus_before_exif_copyright' );

        /** @var $copyright - initialize the copyright string */
        $copyright = '';

        /** Author Credit with Copyright details */
        if ( $opus_image_meta['image_meta']['credit'] ) {
            $copyright .= $opus_image_meta['image_meta']['credit'];
        }
        if ( $opus_image_meta['image_meta']['credit'] && $opus_image_meta['image_meta']['copyright'] ) {
            $copyright .= ' ';
        }
        if ( $opus_image_meta['image_meta']['copyright'] ) {
            $copyright .= sprintf( __( '&copy; %1$s %2$s', 'opusprimus' ), get_the_time( 'Y' ), $opus_image_meta['image_meta']['copyright'] );
        }

        /** Output copyright string */
        echo $copyright;

        /** Add empty hook after EXIF copyright */
        do_action( 'opus_after_exif_copyright' );

    }

    /**
     * Opus Primus EXIF Timestamp
     * Outputs the timestamp including date and time as found in the image meta
     * data formatted per Settings > General as found in the Administration
     * panels (aka Dashboard)
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_meta
     * @uses    do_action
     * @uses    get_option
     * @uses    get_the_time
     *
     * @return  string
     */
    function exif_timestamp() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF timestamp */
        do_action( 'opus_before_exif_timestamp' );

        /** @var $timestamp - initialize the timestamp string */
        $timestamp = '';

        /** Creation timestamp in end-user settings format */
        if ( $opus_image_meta['image_meta']['created_timestamp'] ) {
            $timestamp .= sprintf( __( '%1$s @ %2$s', 'opusprimus' ),
                get_the_time( get_option( 'date_format' ), $opus_image_meta['image_meta']['created_timestamp'] ),
                get_the_time ( get_option( 'time_format' ), $opus_image_meta['image_meta']['created_timestamp'] )
            );
        }

        /** Output timestamp string */
        echo $timestamp;

        /** Add empty hook after EXIF timestamp */
        do_action( 'opus_after_exif_timestamp' );

    }

    /**
     * Opus Primus EXIF Camera
     * Outputs camera details from EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) #opus_image_meta
     * @uses    do_action
     *
     * @return  string
     */
    function exif_camera() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF camera */
        do_action( 'opus_before_exif_camera' );

        /** @var $camera - initialize camera string */
        $camera = '';

        /** Camera details */
        if ( $opus_image_meta['image_meta']['camera'] ) {
            $camera .= $opus_image_meta['image_meta']['camera'];
        }

        /** Output camera string */
        echo $camera;

        /** Add empty hook after EXIF camera */
        do_action( 'opus_after_exif_camera' );

    }


    /**
     * Opus Primus EXIF Shutter Speed
     * Outputs the Shutter speed from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_meta
     * @uses    do_action
     * @uses    exif_data
     * @uses    number_format
     */
    function exif_shutter() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF shutter */
        do_action( 'opus_before_exif_shutter' );

        /** @var $shutter - initialize shutter string */
        $shutter = '';

        /** Shutter speed */
        if ( $opus_image_meta['image_meta']['shutter_speed'] ) {
            /** Shutter Speed Handler - "sec" is used as the short-form for time measured in seconds */
            if ( ( 1 / $opus_image_meta['image_meta']['shutter_speed'] ) > 1 ) {
                $shutter .= "1/";
                if ( number_format( ( 1 / $opus_image_meta['image_meta']['shutter_speed'] ), 1 ) ==  number_format( ( 1 / $opus_image_meta['image_meta']['shutter_speed'] ), 0 ) ) {
                    $shutter .= number_format( ( 1 / $opus_image_meta['image_meta']['shutter_speed'] ), 0, '.', '' ) . ' ' . __( 'sec', 'opusprimus' );
                } else {
                    $shutter .= number_format( ( 1 / $opus_image_meta['image_meta']['shutter_speed'] ), 1, '.', '' ) . ' ' . __( 'sec', 'opusprimus' );
                }
            } else {
                $shutter .= $opus_image_meta['image_meta']['shutter_speed'] . ' ' . __( 'sec', 'opusprimus' );
            }
        }

        /** Output shutter string */
        echo $shutter;

        /** Add empty hook after EXIF shutter */
        do_action( 'opus_after_exif_shutter' );

    }

    /**
     * Opus Primus EXIF Aperture
     * Outputs the aperture details from the EXIF data
     *
     * @package OpuysPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_meta
     * @uses    do_action
     */
    function exif_aperture() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF aperture */
        do_action( 'opus_before_exif_aperture' );

        /** @var $aperture - initialize aperture string */
        $aperture = '';

        /** Aperture Setting */
        if ( $opus_image_meta['image_meta']['aperture'] ) {
            $aperture .= $opus_image_meta['image_meta']['aperture'];
        }

        /** Output aperture string */
        echo $aperture;

        /** Add empty hook before EXIF aperture */
        do_action( 'opus_before_exif_aperture' );

    }

    /**
     * Opus Primus EXIF Caption
     * Outputs the image caption from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_meta
     * @uses    do_action
     */
    function exif_caption() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF caption */
        do_action( 'opus_before_exif_caption' );

        /** @var $exif_caption - initialize EXIF caption string */
        $exif_caption = '';

        /** Image caption from EXIF details */
        if ( $opus_image_meta['image_meta']['caption'] ) {
            $exif_caption .= $opus_image_meta['image_meta']['caption'];
        }

        echo $exif_caption;

        /** Add empty hook after EXIF caption */
        do_action( 'opus_after_exif_caption' );

    }

    /**
     * Opus Primus EXIF Focal Length
     * Outputs the focal length from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_meta
     * @uses    do_action
     * @uses    exif_data
     *
     * @internal mm = UI for millimeters; no need to translate
     */
    function exif_focal_length() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF focal length */
        do_action( 'opus_before_exif_focal_length' );

        /** @var $focal_length - initialize focal length string */
        $focal_length = '';

        /** Output Focal Length */
        if ( $opus_image_meta['image_meta']['focal_length'] ) {
            $focal_length .= $opus_image_meta['image_meta']['focal_length'] . 'mm';
        }

        echo $focal_length;

        /** Add empty hook after EXIF focal length */
        do_action( 'opus_after_exif_focal_length' );

    }

    /**
     * Opus Primus EXIF ISO Speed
     * Outputs the ISO speed from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_meta
     * @uses    do_action
     * @uses    exif_data
     *
     * @internal mm = UI for millimeters; no need to translate
     */
    function exif_iso_speed() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF ISO speed */
        do_action( 'opus_before_exif_iso_speed' );

        /** @var $iso_speed - initialize ISO Speed string */
        $iso_speed = '';

        /** Output ISO Speed */
        if ( $opus_image_meta['image_meta']['iso'] ) {
            $iso_speed .= $opus_image_meta['image_meta']['iso'];
        }

        echo $iso_speed;

        /** Add empty hook after EXIF ISO Speed */
        do_action( 'opus_after_exif_iso_speed' );

    }

    /**
     * Opus Primus EXIF Title
     * Outputs the image title from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (global) $opus_image_meta
     * @uses    do_action
     */
    function exif_title() {
        /** Get the image meta object */
        global $opus_image_meta;
        $this->exif_data();

        /** Add empty hook before EXIF Title */
        do_action( 'opus_before_exif_title' );

        /** @var $exif_title - initialize EXIF Title string */
        $exif_title = '';

        /** Title from EXIF details */
        if ( $opus_image_meta['image_meta']['title'] ) {
            $exif_title .= $opus_image_meta['image_meta']['title'];
        }

        echo $exif_title;

        /** Add empty hook after EXIF Title */
        do_action( 'opus_after_exif_title' );

    }


    /**
     * Opus Primus Display EXIF Box
     * Outputs the EXIF data using a box-model (read: div container)
     *
     * @internal see display_exif_table for the tabular output
     */
    function display_exif_box() {
        /** Wrap the exif output in its own container */
        echo '<div class="display-exif-box">';

            $this->exif_copyright();
            $this->exif_timestamp();
            $this->exif_camera();
            $this->exif_shutter();
            $this->exif_aperture();
            $this->exif_caption();
            $this->exif_focal_length();
            $this->exif_iso_speed();
            $this->exif_title();

        /** Close exif display wrapper */
        echo '</div><!-- .image-exif -->';

    }

}
$opus_image = new OpusPrimusImages();