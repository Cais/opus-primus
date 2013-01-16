<?php
/**
 * Opus Primus Gallery
 * Gallery and other related image functionality
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
 * @todo Fix output position ... return vs. echo issue?
 */

class OpusPrimusGallery {

    /** Construct */
    function __construct() {
        /** Testing ... */
        // add_action( 'opus_after_post_byline', array( $this, 'get_gallery_sec_attr_ids' ));
    }

    /**
     * Get Gallery Shortcode Attribute ids
     * Using the shortcode regex find the attributes for the gallery shortcode
     * and identify the values used in the ids parameter. If the ids parameter
     * is used then store the values in an array ... and carry on ...
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    get_shortcode_regex
     * @uses    get_the_content
     * @uses    shortcode_parse_atts
     *
     * @return  null|int - array index value
     */
    function get_gallery_attr_ids() {

        /** @var $pattern - holds the regex pattern used to check shortcode */
        $pattern = get_shortcode_regex();

        /** Find any shortcode being used in post */
        preg_match( "/$pattern/s", get_the_content(), $match );
        /** Find the gallery shortcode usages */
        if ( 'gallery' == $match[2] ) {

            /** @var $attrs - holds the gallery shortcode parameters used */
            $attrs = shortcode_parse_atts( $match[3] );

            /** @var $images - array of image ids used */
            $images = isset( $attrs['ids'] ) ? explode( ',', $attrs['ids'] ) : false;

            /**
             * If there are no images carry on; otherwise, if this is for the
             * Featured Image return the first image index [0] as this is what
             * the end-user would have chosen first as well.
             */
            if ( $images ) {
                return $images[0];
            }

        }

        /**
         * Not likely to ever see this line but lets make the return Gods happy.
         */
        return null;
    }

    function get_gallery_sec_attr_ids() {

        /** @var $pattern - holds the regex pattern used to check shortcode */
        $pattern = get_shortcode_regex();

        /** Find any shortcode being used in post */
        preg_match( "/$pattern/s", get_the_content(), $match );
        /** Find the gallery shortcode usages */
        if ( 'gallery' == $match[2] ) {

            /** @var $attrs - holds the gallery shortcode parameters used */
            $attrs = shortcode_parse_atts( $match[3] );

            /** @var $images - array of image ids used */
            $images = isset( $attrs['ids'] ) ? explode( ',', $attrs['ids'] ) : false;

            if ( $images ) {
                // var_dump($images);
                $string = '';
                foreach ($images as $image) {
                    $string .= intval($image) . ',';
                }
                $string = substr( $string, 0, strlen( $string ) - 1 );
                // echo 'The string is: ' . $string;
                $cleaned = explode( ',', $string );
                return $cleaned;
            }

        }

        /**
         * Not likely to ever see this line but lets make the return Gods happy.
         */
        return null;
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
     * @uses    $opus_thumb_id (global)
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

            foreach ( $attachments as $opus_thumb_id => $attachment ) {
                if ( ! is_single() ) {
                    echo '<p class="featured-image"><a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ), 'echo' => '0' ) ) . '">'
                        . wp_get_attachment_image( $opus_thumb_id, $size )
                        . '</a></p>';
                } else {
                    echo wp_get_attachment_image( $opus_thumb_id, $size );
                }
            }

            /** If there are no attachments then use a random image from the gallery */
            if ( empty( $attachments ) ) {
                $opus_thumb_id = intval( $this->get_gallery_attr_ids() );
                if ( ! is_single() ) {
                    echo '<p class="featured-image"><a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ), 'echo' => '0' ) ) . '">'
                        . wp_get_attachment_image( $opus_thumb_id, $size )
                        . '</a></p>';
                } else {
                    echo wp_get_attachment_image( $opus_thumb_id, $size );
                }
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

        if ( 0 == $images->found_posts ) {
            $images = new WP_Query( array(
                // 'post__in'                  => array( 946, 880, 619, 611, 544, 543 ), // ECE
                // 'post__in'                  => array( 911, 896, 867, 534, 866, 543 ), // mCais
                'post__in'                  => $this->get_gallery_sec_attr_ids(),
                'post_status'               => 'inherit',
                'post_type'                 => 'attachment',
                'post_mime_type'            => 'image',
                'order'                     => $secondary_images_args['order'],
                'orderby'                   => $secondary_images_args['orderby'],
                'posts_per_page'            => $secondary_images_args['images'],
                'post__not_in'              => array( $opus_thumb_id ),
                'update_post_term_cache'    => false,
            ) );

            /** Testing */
            // var_dump( $this->get_gallery_sec_attr_ids() );
            // var_dump($images);

        }

        /**
         * Do not display default gallery if not in single view and when there
         * are secondary images found (from attachments)
         */
        if ( ! is_single() && ( $images->found_posts > 0 ) ) {
            add_filter('post_gallery', 'opus_primus_return_blank' );
        }

        /**
         * @var $size - standard WordPress image size; thumbnail in this case
         * as the intent is to use these images as additional from gallery
         */
        $size = 'thumbnail';

        /** Only display when not in single view */
        if ( ! is_single() ) {
            /**
             * Cycle through images and display them linked to their permalink
             */
            foreach ( $images->posts as $image ) {
                echo '<a href="' . get_permalink( $image->ID ) . '">' . wp_get_attachment_image( $image->ID, $size ) . '</a>';
            }

            /**
             * Display a message indicating if more images are in the gallery
             * than what are displayed in the post stream. If more images are
             * in the gallery the text showing how many more will link to the
             * single post.
             */
            if ( ( $images->found_posts + 1 ) > ( $secondary_images_args['images'] + 1 ) ) {
                printf( '<p class="more-images">%1$s</p>',
                    apply_filters( 'opus_more_images_text',
                        sprintf( _n(
                            __( 'There is %2$sone more image%3$s in addition to these in the gallery.', 'opusprimus' ),
                            __( 'There are %2$s%1$s more images%3$s in addition to these in the gallery.', 'opusprimus' ),
                            ( $images->found_posts + 1 ) - ( $secondary_images_args['images'] + 1 ) ),
                        ( $images->found_posts + 1 ) - ( $secondary_images_args['images'] + 1 ),
                        '<a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ), 'echo' => '0' ) ) . '">',
                        '</a>' )
                    )
                );
            }
        }

        /** Add empty hook after secondary images */
        do_action( 'opus_after_secondary_images' );

    }

}
$opus_gallery = new OpusPrimusGallery();