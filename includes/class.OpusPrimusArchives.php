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
        echo '<div class="archive category list"><ul>';
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
        echo '<ul class="archive category list">';
        $args = array(
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hierarchical'  => 0,
            'title_li'      => __( 'All Categories:', 'opusprimus' ),
        );
        wp_list_categories( $args );
        echo '</ul>';
    }

}
$opus_archive = new OpusPrimusArchives();