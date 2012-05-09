<?php
/**
 * Opus Primus Archives
 * Site archives for categories, tags, pages, etc.
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

class OpusPrimusArchives {
    /** Construct */
    function __construct() {

    }

    /**
     * Opus Primus Top 10 Categories Archive
     * Displays the top 10 categories by post count as links to the category
     * archive page.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    get_categories
     * @uses    get_category_link
     */
    function opus_primus_top_10_categories_archive() {
        echo '<div class="archive category list top10 cf"><ul>';
            $args = array(
                'orderby'       => 'count',
                'order'         => 'desc',
                'show_count'    => 1,
                'hierarchical'  => 0,
                'title_li'      => '<span class="title">' . __( 'Top 10 Categories by post count:', 'opusprimus' ) . '</span>',
                'number'        => 10,
            );
            wp_list_categories( $args );
        echo '</ul></div>';
    }

    /**
     * Opus Primus Category Archive
     * Displays all of the categories with links to their respective category
     * archive page.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    get_categories
     * @uses    get_category_link
     */
    function opus_primus_categories_archive() {
        echo '<ul class="archive category list cf">';
        $args = array(
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hierarchical'  => 0,
            'title_li'      => __( 'All Categories:', 'opusprimus' ),
        );
        wp_list_categories( $args );
        echo '</ul>';
    }

    /**
     * Opus Primus Archive Cloud
     * Displays a cloud of links to the "post tag" and "category" taxonomies by
     * default; standard `wp_tag_cloud` parameters can be passed to change the
     * output.
     *
     * @link    http://codex.wordpress.org/Function_Reference/wp_tag_cloud
     * @example opus_primus_archive_cloud( array( 'taxonomy' => 'post_tag', 'number' => 10 ) ); - shows only the top 10 post tags.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $cloud_args
     * @internal defaults = show post tags and categories, formatted as a list, in a random order
     *
     * @uses    wp_parse_args
     * @uses    wp_tag_cloud
     *
     * @todo Review output if format is set to flat
     */
    function opus_primus_archive_cloud( $cloud_args = '' ) {
        /** @var $defaults - initial values to be used as parameters */
        $defaults = array(
            'taxonomy'  => array(
                'post_tag',
                'category',
            ),
            'format'    => 'list',
            'order'     => 'RAND',
        );
        $cloud_args = wp_parse_args( (array) $cloud_args, $defaults );

        /** @var $cloud_classes - initialize variable to empty in case no conditions are met */
        $cloud_classes = '';

        /** Top 'number' of displayed tags set */
        if ( isset( $cloud_args['number'] ) && ( 'DESC' == $cloud_args['order'] ) ) {
            $cloud_classes .= 'top' . $cloud_args['number'];
            $cloud_title = sprintf( __( 'The Top %1$s Tags Cloud.', 'opusprimus' ), $cloud_args['number'] );
        }

        /** If a cloud class has been created then make sure to add a space before so it will be properly added to the class list */
        if ( ! empty( $cloud_classes ) ) {
            $cloud_classes = ' ' . $cloud_classes;
        }

        if ( empty( $cloud_title ) )
            $cloud_title = __( 'The Cloud', 'opusprimus' );

        /**
         * Output the cloud with a title wrapped in an element with dynamic
         * classes.
         */
        printf( '<div class="archive cloud list cf%1$s">', $cloud_classes );
            echo '<ul><li><span class="title">' . $cloud_title . '</span>';
                wp_tag_cloud( $cloud_args );
            echo '</li></ul>';
        echo '</div>';
    }

}
$opus_archive = new OpusPrimusArchives();