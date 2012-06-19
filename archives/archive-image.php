<?php
/**
 * Image Archive Loop
 * This loop shows the image post-format archives loop template.
 * The default is to show the featured image in a small size and the post
 * excerpt.
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

/** Get the Post Structure, Navigation, and Gallery class variables */

global $opus_structure, $opus_nav, $opus_gallery, $opus_image;?>

<div <?php post_class(); ?>>

    <?php
    $opus_structure->post_byline( array( 'tempus' => 'time' ) );
    $opus_structure->post_title();
    $opus_structure->comments_link();
    $opus_image->image_media_details();
    $opus_gallery->featured_image( $size = 'medium' );
    $opus_structure->post_excerpt();
    $opus_nav->opus_link_pages( array(), $preface = __( 'Pages:', 'opusprimus' ) );
    $opus_structure->meta_tags();
    $opus_structure->post_coda(); ?>

</div><!-- .post -->