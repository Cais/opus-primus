<?php
/**
 * Opus Primus Images
 * Image related functionality
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2013, Opus Primus
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
 *
 * @version 1.0.1
 * @date    February 21, 2013
 * Re-order methods: action and filter calls by request order, then alphabetical
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 *
 * @version 1.2
 * @date    April 9, 2013
 * Removed global `$opus_image_meta`; replaced with call to `exif_data` method
 *
 * @todo Review adding `opus_*_after` hooks; may also require `show_*` functions (1.2)
 */

class OpusPrimusImages {

    /** Construct */
    function __construct() {}


    /**
     * Opus Primus Archive Image Details
     * Outputs details of the attached image, if they exist
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $size - standard WordPress post_thumbnail sizes / or custom defined sizes can be used
     *
     * @uses    apply_filters
     * @uses    get_children
     * @uses    get_permalink
     * @uses    get_the_ID
     * @uses    is_single
     * @uses    the_title_attribute
     * @uses    wp_get_attachment_image
     *
     * @todo Address $archive_image message(s) once `first_linked_image` is sorted out (1.2)
     * @todo Address CSS aesthetics on images not attached ... or find a way to display the post excerpt details (much better choice!) (1.2)
     *
     * @version 1.2
     * @date    April 11, 2013
     * Added `opus_archive_image_title` filter
     * Added `opus_archive_image_excerpt` filter
     * Added `opus_archive_image_content` filter
     */
    function archive_image_details( $size = 'medium' ) {
        $attachments = get_children( array(
            'post_parent'       => get_the_ID(),
            'post_status'       => 'inherit',
            'post_type'         => 'attachment',
            'post_mime_type'    => 'image',
            'order'             => 'ASC',
            'orderby'           => 'menu_order ID',
            'numberposts'       => 1
        ) );

        /** @var $archive_image - initial value (when there is no attachment) */
        $archive_image = '<p class="archive-image">' . __( 'The Image archive looks much better if the image is set as an attachment of the post.', 'opusprimus' ) . '</p>';
        /** @var $archive_image_title, $archive_image_excerpt, $archive_image_content - initialized as an empty string */
        $archive_image_title = $archive_image_excerpt = $archive_image_content = '';

        if ( empty( $attachments ) ) {
            $archive_image = $this->first_linked_image();
        } /** End if - empty attachments */

        foreach ( $attachments as $opus_thumb_id => $attachment ) {
            $archive_image = wp_get_attachment_image( $opus_thumb_id, $size );
            $archive_image_title = $attachment->post_title;
            $archive_image_excerpt = $attachment->post_excerpt;
            $archive_image_content = $attachment->post_content;
        } /** End foreach - attachments */ ?>

        <table>
            <thead>
            <tr><th>
                <?php
                if ( ! empty( $archive_image_title ) ) {
                    printf( '<span class="archive-image-title">%1$s</span>',
                        apply_filters( 'opus_archive_image_title',
                            sprintf( __( 'Image Title: %1$s', 'opusprimus' ), $archive_image_title )
                        )
                    );
                } /** End if - not empty title */ ?>
            </th></tr>
            </thead><!-- End table header -->
            <tbody>
            <tr>
                <td class="archive-image">
                    <?php
                    if ( ! is_single() ) {
                        echo '<span class="archive-image"><a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ), 'echo' => '0' ) ) . '">'
                            . $archive_image
                            . '</a></span>';
                        if ( empty( $attachments ) ) {
                            printf( '<div class="linked-image-message">%1$s</div>',
                                apply_filters( 'opus_linked_image_message',
                                    __( 'This is a linked image.', 'opusprimus' )
                                )
                            );
                        } /** End if - empty attachments */
                    } /** End if - not is single */ ?>
                </td>
            </tr>
            <tr>
                <?php
                if ( ! empty( $archive_image_excerpt ) ) {
                    printf( '<td class="archive-image-excerpt">%1$s</td>',
                        apply_filters( 'opus_archive_image_excerpt',
                            sprintf( __( 'Image Caption: %1$s', 'opusprimus' ), $archive_image_excerpt )
                        )
                    );
                } /** End if - not empty excerpt */ ?>
            </tr>
            <tr>
                <?php
                if ( ! empty( $archive_image_content ) ) {
                    printf( '<td class="archive-image-content">%1$s</td>',
                        apply_filters( 'opus_archive_image_content',
                            sprintf( __( 'Image Description: %1$s', 'opusprimus' ), $archive_image_content )
                        )
                    );
                } /** End if - not empty content */ ?>
            </tr>
            </tbody><!-- End table body -->
        </table><!-- End table -->

    <?php
    } /** End function - archive image details */


    /**
     * Opus Primus Display EXIF Box
     * Outputs the EXIF data using a box-model (read: div container)
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     *
     * @internal see display_exif_table for tabular output
     *
     * @version 1.2
     * @date    April 12, 2013
     * Added `opus_exif_*_label` filters for all details
     */
    function display_exif_box() {
        /** Add empty hook before exif box */
        do_action( 'opus_exif_box_before' );

        /** Wrap the exif output in its own container */
        echo '<div class="display-exif-box">';

            /** If the exif value is set display it */
            if ( $this->exif_dimensions() ) {
                printf( '<p class="exif-dimensions">%1$s</p>', $this->exif_dimensions() );
            } /** End if */
            if ( $this->exif_copyright() ) {
                printf( '<p class="exif-copyright">' . __( '%1$s: %2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_copyright_label', 'Copyright' ),
                    $this->exif_copyright()
                );
            } /** End if */
            if ( $this->exif_timestamp() ) {
                printf( '<p class="exif-timestamp">' . __( '%1$s: %2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_timestamp_label', 'Uploaded' ),
                    $this->exif_timestamp()
                );
            } /** End if */
            if ( $this->exif_camera() ) {
                printf( '<p class="exif-camera">' . __( '%1$s: %2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_camera_label', 'Camera' ),
                    $this->exif_camera() );
            } /** End if */
            if ( $this->exif_shutter() ) {
                printf( '<p class="exif-shutter">' . __( '%1$s: %2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_shutter_label', 'Shutter Speed' ),
                    $this->exif_shutter()
                );
            } /** End if */
            if ( $this->exif_aperture() ) {
                printf( '<p class="exif-aperture">' . __( '%1$s: F%2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_aperture_label', 'Aperture' ),
                    $this->exif_aperture() );
            } /** End if */
            if ( $this->exif_caption() ) {
                printf( '<p class="exif-caption">' . __( '%1$s: %2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_caption_label', 'Caption' ),
                    $this->exif_caption() );
            } /** End if */
            if ( $this->exif_focal_length() ) {
                printf( '<p class="exif-focal-length>"' . __( '%1$s: %2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_focal_length_label', 'Focal Length' ),
                    $this->exif_focal_length() );
            } /** End if */
            if ( $this->exif_iso_speed() ) {
                printf( '<p class="exif-iso-speed">' . __( '%1$s: %2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_iso_speed_label', 'ISO Speed' ),
                    $this->exif_iso_speed() );
            } /** End if */
            if ( $this->exif_title() ) {
                printf( '<p class="exif-title">' . __( '%1$s: %2$s', 'opusprimus' ) . '</p>',
                    apply_filters( 'opus_exif_title_label', 'Title' ),
                    $this->exif_title() );
            } /** End if */

        /** Close display exif box wrapper */
        echo '</div><!-- .display-exif-box -->';

        /** Add empty hook after exif box */
        do_action( 'opus_exif_box_after' );

    } /** End function - exif box */


    /**
     * Opus Primus Display EXIF Table
     * Outputs the EXIF data using a table-model
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    apply_filters
     * @uses    do_action
     *
     * @internal see display_exif_box for box-model output
     *
     * @version 1.2
     * @date    April 12, 2013
     * Added `opus_display_exif_table_header_text` filter
     * Added `opus_exif_*_label` filters for all details
     *
     * @version 1.2.2
     * @date    September 12, 2013
     * Corrected i18n code for EXIF data
     */
    function display_exif_table() {
        /** Add empty hook before exif table */
        do_action( 'opus_exif_table_before' ); ?>

        <!-- Provide a CSS class for the exif output -->
        <table class="display-exif-table">
            <thead>
            <tr>
                <th>
                    <?php printf( '<span class="display-exif-table-header-text">%1$s</span>',
                        apply_filters( 'opus_display_exif_table_header_text', __( 'Image Details', 'opusprimus' ) )
                    ); ?>
                </th>
            </tr>
            </thead><!-- End table header -->
            <tbody>
                <?php
                /** If the exif value is set display it */
                if ( $this->exif_dimensions() ) {
                    echo '<tr><td class="exif-dimensions">' . apply_filters( 'opus_exif_dimensions_label', __( 'Dimensions', 'opusprimus' ) ) . '</td><td>' . $this->exif_dimensions() . '</td></tr>';
                } /** End if */
                if ( $this->exif_copyright() ) {
                    echo '<tr><td class="exif-copyright">' . apply_filters( 'opus_exif_copyright_label', __( 'Copyright', 'opusprimus' ) ) . '</td><td>' . $this->exif_copyright() . '</td></tr>';
                } /** End if */
                if ( $this->exif_timestamp() ) {
                    echo '<tr><td class="exif-timestamp">' . apply_filters( 'opus_exif_timestamp_label', __( 'Uploaded', 'opusprimus' ) ) . '</td><td>' . $this->exif_timestamp() . '</td></tr>';
                } /** End if */
                if ( $this->exif_camera() ) {
                    echo '<tr><td class="exif-camera">' . apply_filters( 'opus_exif_camera_label', __( 'Camera', 'opusprimus' ) ) . '</td><td>' . $this->exif_camera() . '</td></tr>';
                } /** End if */
                if ( $this->exif_shutter() ) {
                    echo '<tr><td class="exif-shutter">' . apply_filters( 'opus_exif_shutter_label', __( 'Shutter Speed', 'opusprimus' ) ) . '</td><td>' . $this->exif_shutter() . '</td></tr>';
                } /** End if */
                if ( $this->exif_aperture() ) {
                    echo '<tr><td class="exif-aperture">' . apply_filters( 'opus_exif_aperture_label', __( 'Aperture', 'opusprimus' ) ) . '</td><td>' . 'F' . $this->exif_aperture() . '</td></tr>';
                } /** End if */
                if ( $this->exif_caption() ) {
                    echo '<tr><td class="exif-caption">' . apply_filters( 'opus_exif_caption_label', __( 'Caption', 'opusprimus' ) ) . '</td><td>' . $this->exif_caption() . '</td></tr>';
                } /** End if */
                if ( $this->exif_focal_length() ) {
                    echo '<tr><td class="exif-focal-length">' . apply_filters( 'opus_exif_focal_length_label', __( 'Focal Length', 'opusprimus' ) ) . '</td><td>' . $this->exif_focal_length() . '</td></tr>';
                } /** End if */
                if ( $this->exif_iso_speed() ) {
                    echo '<tr><td class="exif-iso-speed">' . apply_filters( 'opus_exif_iso_speed_label', __( 'ISO Speed', 'opusprimus' ) ) . '</td><td>' . $this->exif_iso_speed() . '</td></tr>';
                } /** End if */
                if ( $this->exif_title() ) {
                    echo '<tr><td class="exif-title">' . apply_filters( 'opus_exif_title_label', __( 'Title', 'opusprimus' ) ) . '</td><td>' . $this->exif_title() . '</td></tr>';
                } /** End if */ ?>
            </tbody><!-- End table body -->
            <tfoot></tfoot>
        </table><!-- .display-exif-table -->

        <?php
        /** Add empty hook after exif table */
        do_action( 'opus_exif_table_after' );

    } /** End function - exif table */


    /**
     * Opus Primus EXIF Aperture
     * Outputs the aperture details from the EXIF data
     *
     * @package OpuysPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_aperture() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF aperture */
        do_action( 'opus_exif_aperture_before' );

        /** @var $aperture - initialize aperture string */
        $aperture = '';

        /** Aperture Setting */
        if ( $image_data['image_meta']['aperture'] ) {
            $aperture .= $image_data['image_meta']['aperture'];
        } /** End if - aperture */

        /** Return Aperture string */
        return apply_filters( 'opus_exif_aperture', $aperture );

    } /** End function - exif aperture */


    /**
     * Opus Primus EXIF Camera
     * Outputs camera details from EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_camera() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF camera */
        do_action( 'opus_exif_camera_before' );

        /** @var $camera - initialize camera string */
        $camera = '';

        /** Camera details */
        if ( $image_data['image_meta']['camera'] ) {
            $camera .= $image_data['image_meta']['camera'];
        } /** End if - camera */

        /** Return Camera string */
        return apply_filters( 'opus_exif_camera', $camera );

    } /** End function - exif camera */


    /**
     * Opus Primus EXIF Caption
     * Outputs the image caption from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_caption() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF caption */
        do_action( 'opus_exif_caption_before' );

        /** @var $exif_caption - initialize EXIF caption string */
        $exif_caption = '';

        /** Image caption from EXIF details */
        if ( $image_data['image_meta']['caption'] ) {
            $exif_caption .= $image_data['image_meta']['caption'];
        } /** End if - caption */

        /** Return Caption string */
        return apply_filters( 'opus_exif_caption', $exif_caption );

    } /** End function - exif caption */


    /**
     * Opus Primus EXIF Copyright
     * Outputs a string containing the author and copyright text
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     * @uses    get_the_time
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_copyright() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF copyright */
        do_action( 'opus_exif_copyright_before' );

        /** @var $copyright - initialize the copyright string */
        $copyright = '';

        /** Author Credit with Copyright details */
        if ( $image_data['image_meta']['credit'] ) {
            $copyright .= $image_data['image_meta']['credit'];
        } /** End if - credit */
        if ( $image_data['image_meta']['credit'] && $image_data['image_meta']['copyright'] ) {
            $copyright .= ' ';
        } /** End if - credit & copyright */
        if ( $image_data['image_meta']['copyright'] ) {
            $copyright .= sprintf( __( '&copy; %1$s %2$s', 'opusprimus' ), get_the_time( 'Y' ), $image_data['image_meta']['copyright'] );
        } /** End if - copyright */

        /** Return Copyright string */
        return apply_filters( 'opus_exif_copyright', $copyright );

    } /** End function - exif copyright */


    /**
     * Opus Primus EXIF Data
     * Returns an object containing the EXIF data found in an image if it exists
     * otherwise it returns null.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    wp_get_attachment_metadata
     *
     * @return  object|null
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed globalization of `$opus_image_meta`
     */
    function exif_data() {
        /** @var $opus_image_meta - EXIF information from image */
        $opus_image_meta = wp_get_attachment_metadata();

        if ( isset( $opus_image_meta ) ) {
            return $opus_image_meta;
        } else {
            return null;
        } /** End if - isset */

    } /** End function  - exif data */


    /**
     * Opus Primus EXIF Dimensions
     * Outputs the original/full width and height of the image being displayed
     * with a link to the image itself.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    $post (global)
     * @uses    apply_filters
     * @uses    do_action
     * @uses    wp_get_attachment_url
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_dimensions() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF dimension */
        do_action( 'opus_exif_dimensions_before' );

        $dimensions = '';
        $width = $image_data['width'];
        $height = $image_data['height'];

        /** Link to original image with size displayed */
        if ( $width && $height ) {
            global $post;
            $dimensions .= sprintf( __( '%1$s (Size: %2$s by %3$s)', 'opusprimus' ),
                '<a href="' . wp_get_attachment_url( $post->ID ) . '">' . sprintf( __( 'Original image', 'opusprimus' ) ) . '</a>',
                $width . 'px',
                $height . 'px' );
        } /** End if - width & height */

        return apply_filters( 'opus_exif_dimensions', $dimensions );

    } /** End function - exif dimensions */


    /**
     * Opus Primus EXIF Focal Length
     * Outputs the focal length from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     * @uses    exif_data
     *
     * @internal mm = UI for millimeters; no need to translate
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_focal_length() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF focal length */
        do_action( 'opus_exif_focal_length_before' );

        /** @var $focal_length - initialize focal length string */
        $focal_length = '';

        /** Output Focal Length */
        if ( $image_data['image_meta']['focal_length'] ) {
            $focal_length .= $image_data['image_meta']['focal_length'] . 'mm';
        } /** End if - focal length */

        /** Return Focal Length string */
        return apply_filters( 'opus_exif_focal_length', $focal_length );

    } /** End function - exif focal length */


    /**
     * Opus Primus EXIF ISO Speed
     * Outputs the ISO speed from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     * @uses    exif_data
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_iso_speed() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF ISO speed */
        do_action( 'opus_exif_iso_speed_before' );

        /** @var $iso_speed - initialize ISO Speed string */
        $iso_speed = '';

        /** Output ISO Speed */
        if ( $image_data['image_meta']['iso'] ) {
            $iso_speed .= $image_data['image_meta']['iso'];
        } /** End if - iso */

        /** Return ISO Speed */
        return apply_filters( 'opus_exif_iso_speed', $iso_speed );

    } /** End function - exif iso speed */


    /**
     * Opus Primus EXIF Shutter Speed
     * Outputs the Shutter speed from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     * @uses    exif_data
     * @uses    number_format
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_shutter() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF shutter */
        do_action( 'opus_exif_shutter_before' );

        /** @var $shutter - initialize shutter string */
        $shutter = '';

        /** Shutter speed */
        if ( $image_data['image_meta']['shutter_speed'] ) {
            /** Shutter Speed Handler - "sec" is used as the short-form for time measured in seconds */
            if ( ( 1 / $image_data['image_meta']['shutter_speed'] ) > 1 ) {
                $shutter .= "1/";
                if ( number_format( ( 1 / $image_data['image_meta']['shutter_speed'] ), 1 ) ==  number_format( ( 1 / $image_data['image_meta']['shutter_speed'] ), 0 ) ) {
                    $shutter .= number_format( ( 1 / $image_data['image_meta']['shutter_speed'] ), 0, '.', '' ) . ' ' . __( 'sec', 'opusprimus' );
                } else {
                    $shutter .= number_format( ( 1 / $image_data['image_meta']['shutter_speed'] ), 1, '.', '' ) . ' ' . __( 'sec', 'opusprimus' );
                }
            } else {
                $shutter .= $image_data['image_meta']['shutter_speed'] . ' ' . __( 'sec', 'opusprimus' );
            } /** End if - calculated shutter speed */
        } /** End if - shutter speed */

        /** Return Shutter string */
        return apply_filters( 'opus_exif_shutter', $shutter );

    } /** End function - exif shutter */


    /**
     * Opus Primus EXIF Timestamp
     * Outputs the timestamp including date and time as found in the image meta
     * data formatted per Settings > General as found in the Administration
     * panels (aka Dashboard)
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     * @uses    get_option
     * @uses    get_the_time
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_timestamp() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF timestamp */
        do_action( 'opus_exif_timestamp_before' );

        /** @var $timestamp - initialize the timestamp string */
        $timestamp = '';

        /** Creation timestamp in end-user settings format */
        if ( $image_data['image_meta']['created_timestamp'] ) {
            $timestamp .= sprintf( __( '%1$s @ %2$s', 'opusprimus' ),
                get_the_time( get_option( 'date_format' ), $image_data['image_meta']['created_timestamp'] ),
                get_the_time ( get_option( 'time_format' ), $image_data['image_meta']['created_timestamp'] )
            );
        } /** End if - timestamp */

        /** Return Timestamp string */
        return apply_filters( 'opus_exif_timestamp', $timestamp );

    } /** End function - exif timestamp */


    /**
     * Opus Primus EXIF Title
     * Outputs the image title from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    OpusPrimusImages::exif_data
     * @uses    apply_filters
     * @uses    do_action
     *
     * @return  string
     *
     * @version 1.2
     * @date    April 9, 2013
     * Removed global `$opus_image_meta`; call `exif_data` method instead
     */
    function exif_title() {
        /** @var $image_data - image meta data */
        $image_data = $this->exif_data();

        /** Add empty hook before EXIF Title */
        do_action( 'opus_exif_title_before' );

        /** @var $exif_title - initialize EXIF Title string */
        $exif_title = '';

        /** Title from EXIF details */
        if ( $image_data['image_meta']['title'] ) {
            $exif_title .= $image_data['image_meta']['title'];
        } /** ENd if - title */

        /** Return Title string */
        return apply_filters( 'opus_exif_title', $exif_title );

    } /** End function - exif title */


    /**
     * Opus Primus Featured Thumbnail
     * Adds the featured image / post thumbnail to the post if not in the single
     * view
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   $size - default: thumbnail (uses WordPress sizes)
     * @param   $class - default: alignleft (can be any CSS class)
     *
     * @uses    get_post_thumbnail_id
     * @uses    has_post_thumbnail
     * @uses    is_single
     * @uses    the_post_thumbnail
     * @uses    the_title_attribute
     *
     * @version 1.2
     * @date    April 18, 2013
     * Changed `the_post_thumbnail` to use parameters which are set in the call
     * to this method
     * Remove `is_single` conditional in conjunction with displaying full image
     * on single view of standard format posts
     *
     * @todo clean up and have link display attachment archive (1.2)
     */
    function featured_thumbnail( $size = 'thumbnail', $class = 'alignleft' ) {
        if ( has_post_thumbnail() /** && ! is_single() */ ) {

            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );

            echo '<a class="featured-thumbnail" href="' . $large_image_url[0] . '" title="' . the_title_attribute( 'echo=0' ) . '" >';

                the_post_thumbnail( $size, array( 'class' => $class ) );

            echo '</a>';

        } /** End if - has post thumbnail and not is single */

    } /** End function - featured thumbnail */


    /**
     * First Linked Image
     * Finds the first image in the post and returns it
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @internal Inspired by http://css-tricks.com/snippets/wordpress/get-the-first-image-from-a-post/
     *
     * @todo Return the same image "size" used in the "attachment" as found in the Post-Format: Image archive (1.2)
     */
    function first_linked_image() {

        global $post;
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

        $image_url = $matches[1][0];

        $output = '<img class="linked-image" src="' . $image_url . '" alt="" />';

        return $output;

    } /** End function - first linked image */


    /**
     * Opus Primus Image Title
     * Used in the image Attachment template file to output the image title as
     * noted in the media library
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $before
     * @param   string $after
     * @param   bool $echo
     *
     * @uses    do_action
     * @uses    the_permalink
     * @uses    the_title
     * @uses    the_title_attribute
     */
    function image_title( $before = '', $after = '', $echo = true ) {
        /** Add empty hook before the image title */
        do_action( 'opus_image_title_before' );

        /** Set `the_title` parameters */
        if ( empty( $before ) ) {
            $before = '<h2 class="image-title">';
        } /** End if - before */
        if ( empty( $after ) ) {
            $after = '</h2>';
        } /** End if - after */

        /** Wrap the title in an anchor tag and provide a nice tool tip */
        if ( ! is_attachment() ) { ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ) ) ); ?>">
                <?php the_title( $before, $after, $echo ); ?>
            </a>
        <?php } else {
            the_title( $before, $after, $echo );
        } /** End if - not is attachment */

        /** Add empty hook after the image title */
        do_action( 'opus_image_title_after' );

    } /** End function - image title */


    /**
     * Show First Linked Image
     * Displays the output returned by `first_linked_image`
     *
     * @package OpusPrimus
     * @since   0.1
     */
    function show_first_linked_image() {
        echo $this->first_linked_image();
    } /** End function - show first linked image */


} /** End of Opus Primus Images class */

/** @var $opus_images - new instance of class */
$opus_images = new OpusPrimusImages();