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
 */

/** Add Comments Class */
require_once( OPUS_INC . 'class.OpusPrimusComments.php' );

/** Apply filters and actions */
add_filter( 'comment_class', 'OpusPrimusComments::comment_authors' );
add_action( 'comment_form_before', 'OpusPrimusComments::form_before' );
add_action( 'comment_form_comments_closed', 'OpusPrimusComments::form_comments_closed' ); ?>

<!-- Show the comments -->
<!-- Inspired by http://digwp.com/2010/02/separate-comments-pingbacks-trackbacks/ -->
<div class="comments">
    <?php if ( have_comments() ) : global $wp_query, $opus_nav; ?>

        <h2 id="comments"><?php comments_number( 'No Responses', 'One Response', '% Responses' ); ?></h2>

        <?php if ( ! empty( $comments_by_type['comment'] ) ) { ?>

            <h3 id="comments">
                <?php printf( __( '%1$s Comments', 'opusprimus' ), count( $wp_query->comments_by_type['comment'] ) );?>
            </h3>
            <ul class="comments-list">
                <?php wp_list_comments( 'type=comment' ); ?>
            </ul>

            <?php $opus_nav->comments_navigation(); ?>

        <?php } ?>

        <?php if ( ! empty( $comments_by_type['pingback'] ) ) { ?>

            <h3 id="pingbacks">
                <?php printf( __( '%1$s Pingbacks', 'opusprimus' ), count( $wp_query->comments_by_type['pingback'] ) );?>
            </h3>
            <ol class="pingbacks-list">
                <?php wp_list_comments( 'type=pingback' ); ?>
            </ol>

            <?php $opus_nav->comments_navigation(); ?>

        <?php } ?>

        <?php if ( ! empty( $comments_by_type['trackback'] ) ) { ?>

            <h3 id="trackbacks">
                <?php printf( __( '%1$s Trackbacks', 'opusprimus' ), count( $wp_query->comments_by_type['trackback'] ) );?>
            </h3>
            <ol class="trackbacks-list">
                <?php wp_list_comments( 'type=trackback' ); ?>
            </ol>

            <?php $opus_nav->comments_navigation(); ?>

        <?php } ?>

    <?php endif; ?>
    <?php comment_form(); ?>
</div><!-- .comments -->