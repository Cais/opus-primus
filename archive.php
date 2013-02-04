<?php
/**
 * Archive Template
 * A generic template to show when no other more specific archive template is
 * available to use. See the link below.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2013, Opus Primus
 *
 * @link        http://codex.wordpress.org/Template_Hierarchy - URI reference
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

/** Get the Post Structure and Navigation class variables */
global $opus_structures;
get_header( 'archive' );

/** Add empty hook before content */
do_action( 'opus_before_content' ); ?>

<div class="content-wrapper cf">

    <?php
    /** Add empty hook at top of the content */
    do_action( 'opus_content_top' );

    /** Open the necessary layout CSS classes */
    echo $opus_structures->layout_open();

    /** Add empty action before the_Loop */
    do_action( 'opus_before_the_loop' ); ?>

    <div class="the-loop">

        <?php
        /** Add before loop sidebar */
        if ( is_active_sidebar( 'before-loop' ) ) { dynamic_sidebar( 'before-loop' ); }

        /** the_Loop structure for archives in its most basic form */
        $opus_structures->the_loop_archives();

        /** Add after loop sidebar */
        if ( is_active_sidebar( 'after-loop' ) ) { dynamic_sidebar( 'after-loop' ); } ?>

    </div><!-- #the-loop -->

    <?php
    /** Add empty action after the_Loop */
    do_action( 'opus_after_the_loop' );

    get_sidebar( 'archive' );

    /** Close the classes written by the layout_open call */
    echo $opus_structures->layout_close();

    /** Add empty hook at the bottom of the content */
    do_action( 'opus_content_bottom' ); ?>

</div><!-- #content-wrapper -->

<?php
/** Add empty hook after the content */
do_action( 'opus_after_content' );

get_footer( 'archive' );