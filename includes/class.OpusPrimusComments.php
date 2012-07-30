<?php
/**
 * Opus Primus Comments
 * Controls for the organization and layout of comments and related content.
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

class OpusPrimusComments {
    /** Construct */
    function __construct() {}

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
    function comment_authors( $classes ) {
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
    function form_before() {
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
    function form_comments_closed() {
        if ( ! is_page() ) {
            _e( 'New comments are not being accepted at this time, please feel free to contact the post author directly.', 'opusprimus' );
        }
    }

}
$opus_comments = new OpusPrimusComments();