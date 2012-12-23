<?php
/**
 * Comments Template
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
 *
 * @todo Review general commentary look and feel ... make more unique to OP
 */ ?>

<!-- Show the comments -->
<!-- Inspired by http://digwp.com/2010/02/separate-comments-pingbacks-trackbacks/ -->
<div class="comments-wrapper">
    <?php if ( have_comments() ) : global $wp_query, $opus_navigation; ?>

    <h2 id="all-comments"><?php comments_number( __( 'No Responses', 'opusprimus' ), __( 'One Response', 'opusprimus' ), __( '% Responses', 'opusprimus' ) ); ?></h2>

    <?php if ( ! empty( $comments_by_type['comment'] ) ) { ?>
        <h3 id="comments">
            <?php printf( __( '%1$s Comments', 'opusprimus' ), count( $wp_query->comments_by_type['comment'] ) ); ?>
        </h3>
        <ul class="comments-list">
            <?php wp_list_comments( 'type=comment' ); ?>
        </ul>
        <?php $opus_navigation->comments_navigation();
    }

    if ( ! empty( $comments_by_type['pingback'] ) ) { ?>
        <h3 id="pingbacks">
            <?php printf(
            _n(
                __( '%1$s Pingback', 'opusprimus' ),
                __( '%1$s Pingbacks', 'opusprimus' ),
                count( $wp_query->comments_by_type['pingback'] ) ),
            count( $wp_query->comments_by_type['pingback'] )
        ); ?>
        </h3>
        <ul class="pingbacks-list">
            <?php wp_list_comments( 'type=pingback' ); ?>
        </ul>
        <?php $opus_navigation->comments_navigation();
    }

    if ( ! empty( $comments_by_type['trackback'] ) ) { ?>
        <h3 id="trackbacks">
            <?php printf(
            _n(
                __( '%1$s Trackback', 'opusprimus' ),
                __( '%1$s Trackbacks', 'opusprimus' ),
                count( $wp_query->comments_by_type['trackback'] ) ),
            count( $wp_query->comments_by_type['trackback'] )
        ); ?>
        </h3>
        <ul class="trackbacks-list">
            <?php wp_list_comments( 'type=trackback' ); ?>
        </ul>
        <?php $opus_navigation->comments_navigation();
    }

endif;
    comment_form(); ?>
</div><!-- .comments-wrapper -->