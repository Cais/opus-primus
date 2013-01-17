<?php
/**
 * Author Template
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

/** Call the class variables */
global $opus_structures, $opus_authors;
/** @var $current_author - current author data an as object */
$current_author = ( get_query_var( 'author_name ' ) ) ? get_user_by( 'id', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
/** @var $current_author_id - the author ID */
$current_author_id = $current_author->ID;

get_header( get_post_format() ); ?>

<div class="content-wrapper cf">

    <?php echo $opus_structures->layout_open(); ?>

    <div class="the-loop">
        <!-- The Author Details block - inserted above the content -->
        <div class="opus-author-header">
            <?php $opus_authors->author_details( $current_author_id, true, true, true ); ?>
        </div><!-- opus-author-header -->

        <?php
        /** Add before loop sidebar */
        if ( is_active_sidebar( 'before-loop' ) ) { dynamic_sidebar( 'before-loop' ); }

        /** the_Loop structure in its most basic form */
        $opus_structures->the_loop();

        /** Add after loop sidebar */
        if ( is_active_sidebar( 'after-loop' ) ) { dynamic_sidebar( 'after-loop' ); } ?>

    </div><!-- #the-loop -->

    <?php
    get_sidebar();

    echo $opus_structures->layout_close(); ?>

</div><!-- #content-wrapper -->

<?php
get_footer( get_post_format() );