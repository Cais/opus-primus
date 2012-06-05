<?php
/**
 * Opus Primus
 * A WordPress Framework Theme.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @internal    RECOMMENDED HTML5
 * @internal    RECOMMENDED CSS3
 * @internal    REQUIRED    WordPress 3.4
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
 *
 * @todo Templates: attachment, image, video, audio, category, tag, author, date, etc.
 * @todo Post-Format Loops
 */

get_header();
global $opus_nav, $opus_structure;

?>
<div class="opus-uno"><div class="opus-duo"><div class="opus-tre">
    <div id="content-wrapper">
        <div id="the-loop">
            <?php
            if ( have_posts() ):
                while ( have_posts() ):
                    the_post();
                    get_template_part( 'loops/opus-primus', get_post_format() );
                endwhile;
            else:
                $opus_structure->search_results();
            endif;
            $opus_nav->opus_posts_link(); ?>
        </div><!-- #the-loop -->
    </div><!-- #content-wrapper -->
    <?php get_sidebar(); ?>
</div></div></div>
<?php
get_footer();