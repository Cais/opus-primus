<?php
/**
 * Opus Primus Post-Format: Chat loop template
 * Displays the post-format: chat loop content
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

/** Call the class variables */
global $opus_post, $opus_comments, $opus_nav, $opus_image, $opus_authors;

/** Display the post */ ?>
<div <?php post_class(); ?>>

    <?php
    /** @var $anchor - set value for use in post_byline and meta_tags */
    $anchor = __( 'Said', 'opusprimus' );
    $opus_post->post_byline( array(
        'show_mod_author'   => true,
        'anchor'            => $anchor,
        'sticky_flag'       => __( 'Exclaimed', 'opusprimus' )
    ) );
    $opus_post->post_title();
    if ( ! is_single() ) {
        $opus_comments->comments_link();
    }
    $opus_image->featured_thumbnail();
    $opus_post->post_content();
    $opus_nav->link_pages( array(), $preface = __( 'Pages:', 'opusprimus' ) );
    $opus_post->meta_tags( $anchor );
    $opus_post->post_coda();
    if ( is_single() ) {
        $opus_authors->post_author( array(
            'show_mod_author'   => true,
            'show_author_url'   => true,
            'show_author_email' => true,
            'show_author_desc'  => true,
        ) );
    } ?>

</div><!-- .post -->
<?php
comments_template( '/comments.php', true );