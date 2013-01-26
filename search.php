<?php
/**
 * Search Template
 * Displays for search results
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

global $opus_navigation, $opus_structures;
get_header( 'search' ); ?>

<div class="content-wrapper cf">

    <?php
    /** Open the necessary layout CSS classes */
    echo $opus_structures->layout_open();

    /** Add empty action before the_Loop */
    do_action( 'opus_before_the_loop' ); ?>

    <div class="the-loop">

        <?php
        /** Add before loop sidebar */
        if ( is_active_sidebar( 'before-loop' ) ) { dynamic_sidebar( 'before-loop' ); }

        /** the_Loop - Starts */
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                get_template_part( 'loops/opus-primus', get_post_format() );
            } /** End while - have posts */
        } else {
            $opus_structures->no_search_results();
        } /** End if - have posts */
        $opus_navigation->posts_link();
        /** the_Loop - Ends */

        /** Add after loop sidebar */
        if ( is_active_sidebar( 'after-loop' ) ) { dynamic_sidebar( 'after-loop' ); } ?>

    </div><!-- #the-loop -->

    <?php
    /** Add empty action after the_Loop */
    do_action( 'opus_after_the_loop' );

    get_sidebar( 'search' );

    /** Close the classes written by the layout_open call */
    echo $opus_structures->layout_close(); ?>

</div><!-- #content-wrapper -->

<?php
get_footer( 'search' );