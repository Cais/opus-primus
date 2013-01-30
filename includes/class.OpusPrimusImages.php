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
 */

class OpusPrimusImages {

    /** Construct */
    function __construct(){}


    /**
     * Opus Primus Featured Thumbnail
     * Adds the featured image / post thumbnail to the post if not in the single
     * view
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    get_post_thumbnail_id
     * @uses    has_post_thumbnail
     * @uses    is_single
     * @uses    the_post_thumbnail
     * @uses    the_title_attribute
     *
     * @todo clean up and have link display attachment archive
     */
    function featured_thumbnail() {
        if ( has_post_thumbnail() && ! is_single() ) {
            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
            echo '<a class="featured-thumbnail" href="' . $large_image_url[0] . '" title="' . the_title_attribute( 'echo=0' ) . '" >';
            the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) );
            echo '</a>';
        } /** End if - has post thumbnail and not is single */
    } /** End function - featured thumbnail */


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
     */
    function display_exif_box() {
        /** Add empty hook before exif box */
        do_action( 'opus_before_exif_box' );

        /** Wrap the exif output in its own container */
        echo '<div class="display-exif-box">';

        /** If the exif value is set display it */
        if ( $this->exif_dimensions() ) {
            printf( '<p class="exif-dimensions">%1$s</p>', $this->exif_dimensions() );
        } /** End if */
        if ( $this->exif_copyright() ) {
            printf( '<p class="exif-copyright">' . __( 'Copyright: %1$s', 'opusprimus' ) . '</p>', $this->exif_copyright() );
        } /** End if */
        if ( $this->exif_timestamp() ) {
            printf( '<p class="exif-timestamp">' . __( 'Uploaded: %1$s', 'opusprimus' ) . '</p>', $this->exif_timestamp() );
        } /** End if */
        if ( $this->exif_camera() ) {
            printf( '<p class="exif-camera">' . __( 'Camera: %1$s', 'opusprimus' ) . '</p>', $this->exif_camera() );
        } /** End if */
        if ( $this->exif_shutter() ) {
            printf( '<p class="exif-shutter">' . __( 'Shutter Speed: %1$s', 'opusprimus' ) . '</p>', $this->exif_shutter() );
        } /** End if */
        if ( $this->exif_aperture() ) {
            printf( '<p class="exif-aperture">' . __( 'Aperture: F%1$s', 'opusprimus' ) . '</p>', $this->exif_aperture() );
        } /** End if */
        if ( $this->exif_caption() ) {
            printf( '<p class="exif-caption">' . __( 'Caption: %1$s', 'opusprimus' ) . '</p>', $this->exif_caption() );
        } /** End if */
        if ( $this->exif_focal_length() ) {
            printf( '<p class="exif-focal-length>"' . __( 'Focal Length: %1$s', 'opusprimus' ) . '</p>', $this->exif_focal_length() );
        } /** End if */
        if ( $this->exif_iso_speed() ) {
            printf( '<p class="exif-iso-speed">' . __( 'ISO Speed: %1$s', 'opusprimus' ) . '</p>', $this->exif_iso_speed() );
        } /** End if */
        if ( $this->exif_title() ) {
            printf( '<p class="exif-title">' . __( 'Title: %1$s', 'opusprimus' ) . '</p>', $this->exif_title() );
        } /** End if */

        /** Close display exif box wrapper */
        echo '</div><!-- .display-exif-box -->';

        /** Add empty hook after exif box */
        do_action( 'opus_after_exif_box' );

    } /** End function - exif box */


    /**
     * Opus Primus Display EXIF Table
     * Outputs the EXIF data using a table-model
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     *
     * @internal see display_exif_box for box-model output
     */
    function display_exif_table() {
        /** Add empty hook before exif table */
        do_action( 'opus_before_exif_table' ); ?>

    <!-- Provide a CSS class for the exif output -->
    <table class="display-exif-table">
        <thead>
        <tr>
            <th><?php _e( 'Image Details', 'opusprimus' ); ?></th>
        </tr>
        </thead><!-- End table header -->
        <tbody>
            <?php
            /** If the exif value is set display it */
            if ( $this->exif_dimensions() ) {
                echo '<tr><td class="exif-dimensions">' . __( 'Dimensions', 'opusprimus' ) . '</td><td>' . $this->exif_dimensions() . '</td></tr>';
            } /** End if */
            if ( $this->exif_copyright() ) {
                echo '<tr><td class="exif-copyright">' . __( 'Copyright', 'opusprimus' ) . '</td><td>' . $this->exif_copyright() . '</td></tr>';
            } /** End if */
            if ( $this->exif_timestamp() ) {
                echo '<tr><td class="exif-timestamp">' . __( 'Uploaded', 'opusprimus' ) . '</td><td>' . $this->exif_timestamp() . '</td></tr>';
            } /** End if */
            if ( $this->exif_camera() ) {
                echo '<tr><td class="exif-camera">' . __( 'Camera', 'opusprimus' ) . '</td><td>' . $this->exif_camera() . '</td></tr>';
            } /** End if */
            if ( $this->exif_shutter() ) {
                echo '<tr><td class="exif-shutter">' . __( 'Shutter Speed', 'opusprimus' ) . '</td><td>' . $this->exif_shutter() . '</td></tr>';
            } /** End if */
            if ( $this->exif_aperture() ) {
                echo '<tr><td class="exif-aperture">' . __( 'Aperture', 'opusprimus' ) . '</td><td>' . 'F' . $this->exif_aperture() . '</td></tr>';
            } /** End if */
            if ( $this->exif_caption() ) {
                echo '<tr><td class="exif-caption">' . __( 'Caption', 'opusprimus' ) . '</td><td>' . $this->exif_caption() . '</td></tr>';
            } /** End if */
            if ( $this->exif_focal_length() ) {
                echo '<tr><td class="exif-focal-length">' . __( 'Focal Length', 'opusprimus' ) . '</td><td>' . $this->exif_focal_length() . '</td></tr>';
            } /** End if */
            if ( $this->exif_iso_speed() ) {
                echo '<tr><td class="exif-iso-speed">' . __( 'ISO Speed', 'opusprimus' ) . '</td><td>' . $this->exif_iso_speed() . '</td></tr>';
            } /** End if */
            if ( $this->exif_title() ) {
                echo '<tr><td class="exif-title">' . __( 'Title', 'opusprimus' ) . '</td><td>' . $this->exif_title() . '</td></tr>';
            } /** End if */ ?>
        </tbody><!-- End table body -->
        <tfoot></tfoot>
    </table><!-- .display-exif-table -->

    <?php
        /** Add empty hook after exif table */
        do_action( 'opus_after_exif_table' );

    } /** End function - exif table */


    /**
     * Opus Primus EXIF Data
     * Returns an object containing the EXIF data found in an image if it exists
     * otherwise it returns null.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_image_data (global)
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
     * @uses    $opus_image_meta (global)
     * @uses    $post (global)
     * @uses    apply_filters
     * @uses    do_action
     * @uses    wp_get_attachment_url
     *
     * @return  string
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
            $dimensions .= sprintf( __( '%1$s (Size: %2$s by %3$s)', 'opusprimus' ),
                '<a href="' . wp_get_attachment_url( $post->ID ) . '">' . sprintf( __( 'Original image', 'opusprimus' ) ) . '</a>',
                $width . 'px',
                $height . 'px' );
        } /** End if - width & height */

        return apply_filters( 'opus_exif_dimensions', $dimensions );

    } /** End function - exif dimensions */


    /**
     * Opus Primus EXIF Copyright
     * Outputs a string containing the author and copyright text
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
     * @uses    do_action
     * @uses    get_the_time
     *
     * @return  string
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
        } /** End if - credit */
        if ( $opus_image_meta['image_meta']['credit'] && $opus_image_meta['image_meta']['copyright'] ) {
            $copyright .= ' ';
        } /** End if - credit & copyright */
        if ( $opus_image_meta['image_meta']['copyright'] ) {
            $copyright .= sprintf( __( '&copy; %1$s %2$s', 'opusprimus' ), get_the_time( 'Y' ), $opus_image_meta['image_meta']['copyright'] );
        } /** End if - copyright */

        /** Return Copyright string */
        return apply_filters( 'opus_exif_copyright', $copyright );

    } /** End function - exif copyright */


    /**
     * Opus Primus EXIF Timestamp
     * Outputs the timestamp including date and time as found in the image meta
     * data formatted per Settings > General as found in the Administration
     * panels (aka Dashboard)
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
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
        } /** End if - timestamp */

        /** Return Timestamp string */
        return apply_filters( 'opus_exif_timestamp', $timestamp );

    } /** End function - exif timestamp */


    /**
     * Opus Primus EXIF Camera
     * Outputs camera details from EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
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
        } /** End if - camera */

        /** Return Camera string */
        return apply_filters( 'opus_exif_camera', $camera );

    } /** End function - exif camera */


    /**
     * Opus Primus EXIF Shutter Speed
     * Outputs the Shutter speed from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
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
            } /** End if - calculated shutter speed */
        } /** End if - shutter speed */

        /** Return Shutter string */
        return apply_filters( 'opus_exif_shutter', $shutter );

    } /** End function - exif shutter */


    /**
     * Opus Primus EXIF Aperture
     * Outputs the aperture details from the EXIF data
     *
     * @package OpuysPrimus
     * @since   0.1
     *
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
     * @uses    do_action
     *
     * @return  string
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
        } /** End if - aperture */

        /** Return Aperture string */
        return apply_filters( 'opus_exif_aperture', $aperture );

    } /** End function - exif aperture */


    /**
     * Opus Primus EXIF Caption
     * Outputs the image caption from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
     * @uses    do_action
     *
     * @return  string
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
        } /** End if - caption */

        /** Return Caption string */
        return apply_filters( 'opus_exif_caption', $exif_caption );

    } /** End function - exif caption */


    /**
     * Opus Primus EXIF Focal Length
     * Outputs the focal length from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
     * @uses    do_action
     * @uses    exif_data
     *
     * @internal mm = UI for millimeters; no need to translate
     *
     * @return  string
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
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
     * @uses    do_action
     * @uses    exif_data
     *
     * @return  string
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
        } /** End if - iso */

        /** Return ISO Speed */
        return apply_filters( 'opus_exif_iso_speed', $iso_speed );

    } /** End function - exif iso speed */


    /**
     * Opus Primus EXIF Title
     * Outputs the image title from the EXIF data
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_image_meta (global)
     * @uses    apply_filters
     * @uses    do_action
     *
     * @return  string
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
        } /** ENd if - title */

        /** Return Title string */
        return apply_filters( 'opus_exif_title', $exif_title );

    } /** End function - exif title */


    /** -- To be reordered below this line ---------------------------------- */


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
        do_action( 'opus_before_image_title' );

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
        do_action( 'opus_after_image_title' );

    } /** End function - image title */


    /**
     * Opus Primus Archive Image Details
     * Outputs details of the attached image, if they exist
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $size - standard WordPress post_thumbnail sizes / or custom defined sizes can be used
     *
     * @uses    get_children
     * @uses    get_permalink
     * @uses    get_the_ID
     * @uses    is_single
     * @uses    the_title_attribute
     * @uses    wp_get_attachment_image
     *
     * @todo Add filters to output messages
     * @todo Review output when using image that is not attached to post (or linked)
     * @todo Address $archive_image message(s) once `first_linked_image` is sorted out
     * @todo Address CSS aesthetics on images not attached ... or find a way to display the post excerpt details (much better choice!)
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
                        printf( '<span class="archive-image-title">' . __( 'Image Title: %1$s', 'opusprimus' )  . '</span>', $archive_image_title );
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
                        } /** End if - not is single */ ?>
                    </td>
                </tr>
                <tr>
                    <?php
                    if ( ! empty( $archive_image_excerpt ) ) {
                        printf( '<td class="archive-image-excerpt">' . __( 'Image Caption: %1$s', 'opusprimus' )  . '</td>', $archive_image_excerpt );
                    } /** End if - not empty excerpt */ ?>
                </tr>
                <tr>
                    <?php
                    if ( ! empty( $archive_image_content ) ) {
                        printf( '<td class="archive-image-content">' . __( 'Image Description: %1$s', 'opusprimus' )  . '</td>', $archive_image_content );
                    } /** End if - not empty content */ ?>
                </tr>
            </tbody><!-- End table body -->
        </table><!-- End table -->

    <?php
    } /** End function - archive image details */


    /**
     * First Linked Image
     * Finds the first image in the post and returns it
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @internal Inspired by http://css-tricks.com/snippets/wordpress/get-the-first-image-from-a-post/
     *
     * @todo Return the same image "size" used in the "attachment" as found in the Post-Format: Image archive
     */
    function first_linked_image() {

        global $post;
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

        $output = '<img src="' . $matches[1][0] . '" alt="" />';

        return $output;

    } /** End function - first linked image */


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