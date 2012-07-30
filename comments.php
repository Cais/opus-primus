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

/**
 * Comment Authors
 * Add classes to the comments based on the author
 *
 * @package OpusPrimus
 * @since   0.1
 *
 * @param   array $classes
 * @return  array $classes - original array plus additional role and user-id
 */
function opus_primus_comment_authors( $classes ) {
    global $comment;
    /** Add classes based on user role */
    if ( user_can( $comment->user_id, 'administrator' ) ) {
        $classes[] = 'administrator';
    } elseif ( user_can( $comment->user_id, 'editor' ) ) {
        $classes[] = 'editor';
    } elseif ( user_can( $comment->user_id, 'contributor' ) ) {
        $classes[] = 'contributor';
    } elseif ( user_can( $comment->user_id, 'subscriber' ) ) {
        $classes[] = 'subscriber';
    } else {
        $classes[] = 'guest';
    }
    /** Add user ID based classes */
    if ( $comment->user_id == 1 ) {
        /** Administrator 'Prime' => first registered user ID */
        $userid = "administrator-prime user-id-1";
    } else {
        /** All other users - NB: user-id-0 -> non-registered user */
        $userid = "user-id-" . ( $comment->user_id );
    }
    $classes[] = $userid;

    return $classes;
}

/**
 * Form Before
 * Text to be shown before form
 *
 * @package OpusPrimus
 * @since   0.1
 *
 * @uses    _e
 * @uses    have_comments
 * @uses    post_password_required
 *
 * @internal used with comment_form_before hook
 * @internal NB: hook is only accessible if comments are open
 */
function opus_primus_form_before() {
    /** Conditional check for password protected posts ... no comments for you! */
    if ( post_password_required() ) {
        _e( 'This post is password protected. Enter the password to view comments.', 'opusprimus' );
        return;
    }
    /** If comments are open, but there are no comments. */
    if ( ! have_comments() ) :
        _e( 'Start a discussion ...', 'opusprimus' );
    endif;
}

/**
 * Form Comments Closed
 * Test to be displayed if comments are closed
 *
 * @package OpusPrimus
 * @since   0.1
 *
 * @uses    _e
 * @uses    is_page
 *
 * @internal used with comment_form_comments_closed hook
 */
function opus_primus_form_comments_closed() {
    if ( ! is_page() ) {
        _e( 'New comments are not being accepted at this time, please feel free to contact the post author directly.', 'opusprimus' );
    }
}

/** Apply filters and actions */
add_filter( 'comment_class', 'opus_primus_comment_authors' );
add_action( 'comment_form_before', 'opus_primus_form_before' );
add_action( 'comment_form_comments_closed', 'opus_primus_form_comments_closed' ); ?>

<!-- Show the comments -->
<!-- Inspired by http://digwp.com/2010/02/separate-comments-pingbacks-trackbacks/ -->
<div class="comments-wrapper">
    <?php if ( have_comments() ) : global $wp_query, $opus_nav; ?>

        <h2 id="all-comments"><?php comments_number( __( 'No Responses', 'opusprimus' ), __( 'One Response', 'opusprimus' ), __( '% Responses', 'opusprimus' ) ); ?></h2>

        <?php if ( ! empty( $comments_by_type['comment'] ) ) { ?>
            <h3 id="comments">
                <?php printf( __( '%1$s Comments', 'opusprimus' ), count( $wp_query->comments_by_type['comment'] ) ); ?>
            </h3>
            <ul class="comments-list">
                <?php wp_list_comments( 'type=comment' ); ?>
            </ul>
            <?php $opus_nav->comments_navigation();
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
            <ol class="pingbacks-list">
                <?php wp_list_comments( 'type=pingback' ); ?>
            </ol>
            <?php $opus_nav->comments_navigation();
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
            <ol class="trackbacks-list">
                <?php wp_list_comments( 'type=trackback' ); ?>
            </ol>
            <?php $opus_nav->comments_navigation();
        }

    endif;
    comment_form(); ?>
</div><!-- .comments-wrapper -->