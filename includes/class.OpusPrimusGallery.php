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

    /**
     * Opus Primus Gallery Single Only
     * Function used to filter the gallery shortcode output to only be displayed
     * on single pages.
     *
     * @internal see ../wp-includes/media.php The Gallery shortcode.
     * @internal This implements the functionality of the Gallery Shortcode for
     * displaying WordPress images on a post.
     *
     *
     * @param   array $attr Attributes of the shortcode.
     * @param   $filtered
     *
     * @return  string HTML content to display gallery.
     */
    static public function gallery_single_only( $filtered, $attr = null ) {
        global $post;

        static $instance = 0;
        $instance++;

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        }

        extract( shortcode_atts( array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post->ID,
            'itemtag'    => 'dl',
            'icontag'    => 'dt',
            'captiontag' => 'dd',
            'columns'    => 3,
            'size'       => 'thumbnail',
            'include'    => '',
            'exclude'    => ''
        ), $attr ) );

        $id = intval( $id );
        if ( 'RAND' == $order )
            $orderby = 'none';

        if ( ! empty( $include ) ) {
            $include = preg_replace( '/[^0-9,]+/', '', $include );
            $_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( ! empty( $exclude ) ) {
            $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
            $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
        } else {
            $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
        }

        if ( empty( $attachments ) )
            return '';

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment )
                $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
            return $output;
        }

        $itemtag = tag_escape( $itemtag );
        $captiontag = tag_escape( $captiontag );
        $columns = intval( $columns );
        $itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
        $float = is_rtl() ? 'right' : 'left';

        $selector = "gallery-{$instance}";

        $gallery_style = $gallery_div = '';
        if ( apply_filters( 'use_default_gallery_style', true ) )
            $gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->";
        $size_class = sanitize_html_class( $size );
        $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
        $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

        $i = 0;
        foreach ( $attachments as $id => $attachment ) {
            $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false );

            $output .= "<{$itemtag} class='gallery-item'>";
            $output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
            if ( $captiontag && trim( $attachment->post_excerpt ) ) {
                $output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize( $attachment->post_excerpt ) . "
				</{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
            if ( $columns > 0 && ++$i % $columns == 0 )
                $output .= '<br style="clear: both" />';
        }

        $output .= "
			<br style='clear: both;' />
		</div>\n";

        /**
         * Only display output on single view otherwise return a space as an
         * empty string / array will not work.
         */
        if ( is_single() || ! has_post_format( 'gallery' ) ) {
            return $output;
        } else {
            return ' ';
        }
    }

}
$opus_gallery = new OpusPrimusGallery();