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
 */

/** Do not delete these lines */
if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
    die ( __( 'Please do not load this page directly. Thanks!', 'opusprimus' ) );
if ( post_password_required() ) { ?>
    <p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'opusprimus' ); ?></p>
<?php
    return;
}

/**
 * Opus Primus Comment Author
 * Add classes to the comments based on the author
 *
 * @package OpusPrimus
 * @since   0.1
 *
 * @param   array $classes
 * @return  array $classes - original array plus additional role and user-id
 */
function opus_primus_comment_author( $classes ) {
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
add_filter( 'comment_class', 'opus_primus_comment_author' );

/** Show the comments */
if ( have_comments() ) : ?>
    <h4 id="comments"><?php comments_number( __( 'No Comments', 'shades' ), __( 'One Comment', 'shades' ), __( '% Comments', 'shades' ) );?></h4>
    <ul class="commentlist" id="singlecomments">
        <?php wp_list_comments( array( 'avatar_size' => 60, 'reply_text' => __( '&raquo; Reply to this Comment &laquo;', 'shades' ) ) ); ?>
    </ul>
    <?php
    global $opus_nav;
    $opus_nav->opus_comments_navigation();
else :
    /** This is displayed if there are no comments so far*/
    if ( 'open' == $post->comment_status ) :
        /** If comments are open, but there are no comments. */
    else :
        /** Comments are closed */
    endif;
endif;
comment_form();