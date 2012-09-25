<?php
/**
 * Opus Primus Post-Format: Gallery Template
 * Displays the post-format: gallery loop
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

/** Call the Post Structure and Navigation class variables */
global $opus_nav, $opus_structure, $opus_gallery;

if ( ! is_single() ) {
    add_filter('post_gallery', 'opus_primus_return_blank' );
}

/** Display the post */ ?>
<div <?php post_class(); ?>>

    <?php
    $opus_structure->post_byline( array(
        'show_mod_author'   => true,
        'anchor'            => 'Displayed',
        'sticky_flag'       => 'Exhibition'
    ) );
    $opus_structure->post_title();
    if ( ! is_single() ) {
        $opus_structure->comments_link();
    } ?>

    <div class="gallery-featured-image">
        <?php $opus_gallery->featured_image(); ?>
    </div>

    <?php if ( ! is_single() ) : ?>
    <div class="gallery-secondary-images">
        <?php $opus_gallery->secondary_images(); ?>
    </div>

    <?php
    endif;

    $opus_structure->post_content();
    $opus_nav->link_pages( array(), $preface = __( 'Pages:', 'opusprimus' ) );
    $opus_structure->meta_tags();
    $opus_structure->post_coda();
    if ( is_single() ) {
        $opus_structure->post_author();
    } ?>

</div><!-- .post -->
<?php
comments_template( '/comments.php', true );