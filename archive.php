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
 * @copyright   Copyright (c) 2012, Opus Primus
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
global $opus_nav, $opus_structure;
get_header( get_post_format() ); ?>

<div class="content-wrapper">

    <?php echo $opus_structure->layout_open(); ?>

    <div class="the-loop">

        <?php
        $opus_nav->opus_post_link();
        if ( have_posts() ):
            while ( have_posts() ):
                the_post();
                get_template_part( 'archives/archive', get_post_format() );
            endwhile;
        else:
            $opus_structure->search_results();
        endif;
        $opus_nav->opus_posts_link(); ?>

    </div><!-- #the-loop -->

    <?php
    get_sidebar( get_post_format() );

    echo $opus_structure->layout_close(); ?>

</div><!-- #content-wrapper -->

<?php
get_footer( get_post_format() );