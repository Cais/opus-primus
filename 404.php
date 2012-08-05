<?php
/**
 * 404 Template
 * Displays when a 404 error is produced, such as when a page does not exist.
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

global $opus_archive, $opus_structure;
get_header( '404' ); ?>

<section>
    <div class="content-wrapper">

        <?php echo $opus_structure->layout_open(); ?>
        <div class="the-loop">

            <?php
            echo '<h1>This is the 404 page!</h1>';

            /** Display links to archives */
            /** Display a list of categories to choose from */
            $opus_archive->categories_archive( array(
                'orderby'       => 'count',
                'order'         => 'desc',
                'show_count'    => 1,
                'hierarchical'  => 0,
                'title_li'      => '<span class="title">' . __( 'Top 10 Categories by Post Count:', 'opusprimus' ) . '</span>',
                'number'        => 10,
            ) );
            /** Display a list of tags to choose from */
            $opus_archive->archive_cloud( array(
                'taxonomy'  => 'post_tag',
                'orderby'   => 'count',
                'order'     => 'DESC',
                'number'    => 10,
            ) ); ?>

        </div><!-- #the-loop -->

        <?php
        get_sidebar( '404' );
        echo $opus_structure->layout_close(); ?>

    </div><!-- #content-wrapper -->
</section>

<?php
get_footer( '404' );