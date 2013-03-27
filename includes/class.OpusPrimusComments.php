<?php
/**
 * Opus Primus Comments
 * Comments related functions
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2013, Opus Primus
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
 * @version 1.0.1
 * @date    February 21, 2013
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 *
 * @version 1.1.1
 * @date    March 22, 2013
 * Added `comments only tab`, `pingbacks only tab`, `trackbacks only tab`,
 * `comments only panel`, `pingbacks only panel` and `trackbacks only panel`
 * functionality class methods from 'comments.php' template
 * Added `all_comments_count` and `show_all_comments_count` to be used in the
 * 'comments.php' template to display total comments
 *
 * @version 1.2
 * @date    March 26, 2013
 * Added filtered $required glyph variable for comment fields
 * Change comment fields into an unordered list
 */

class OpusPrimusComments {
    /** Constructor */
    function __construct(){
        /** Add comment actions */
        add_action( 'comment_form_before', array( $this, 'enqueue_comment_reply' ) );
        add_action( 'comment_form_before', array( $this, 'before_comment_form' ) );
        add_action( 'comment_form_comments_closed', array( $this ,'comments_form_closed' ) );

        /** Add comment actions - wrap comment fields in unordered list */
        add_action( 'comment_form_before_fields', array( $this, 'comment_fields_wrapper_start' ) );
        add_action( 'comment_form_after_fields', array( $this, 'comment_fields_wrapper_end' ) );

        /** Add comment filters */
        add_filter( 'comment_class', array( $this, 'comment_author_class' ) );

        /** Add comment filters - change fields to list items from paragraphs */
        add_filter( 'comment_form_default_fields', array( $this, 'comment_fields_as_list_items' ) );

    } /** End function - construct */


    /** ---- Action and Filter Methods ---- */


    /**
     * Enqueue Comment Reply
     * If the page being viewed is a single post/page; and, comments are open;
     * and, threaded comments are turned on then enqueue the built-in
     * comment-reply script.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    is_singular
     * @uses    comments_open
     * @uses    get_option
     * @uses    wp_enqueue_script
     */
    function enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        } /** End if - is singular */

    } /** End function - enqueue comment reply */


    /**
     * Before Comment Form
     * Text to be shown before form
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    _e
     * @uses    apply_filters
     * @uses    have_comments
     * @uses    post_password_required
     *
     * @internal used with comment_form_before hook
     * @internal NB: hook is only accessible if comments are open
     *
     * @version 1.0.1
     * @date    February 19, 2013
     * Fixed no comments message
     */
    function before_comment_form() {
        /** Conditional check for password protected posts ... no comments for you! */
        if ( post_password_required() ) {
            printf(
                '<span class="comments-password-message">' .
                    apply_filters( 'opus_comments_password_required', __( 'This post is password protected. Enter the password to view comments.', 'opusprimus' ) ) .
                '</span>' );
            return;
        } /** End if - post password required */

        /** If comments are open, but there are no comments. */
        if ( ! have_comments() ) {
            printf(
                '<span class="no-comments-message">' .
                    apply_filters( 'opus_no_comments_message', __( 'Start a discussion ...', 'opusprimus' ) ) .
                '</span>' );
        } /** End if - not have comments */

    } /** End function - before comment form */


    /**
     * Comments Form Closed
     * Test to be displayed if comments are closed
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    _e
     * @uses    apply_filters
     * @uses    is_page
     *
     * @internal used with comment_form_comments_closed hook
     */
    function comments_form_closed() {
        if ( ! is_page() ) {
            printf(
                '<span class="comments-closed-message">' .
                    apply_filters( 'opus_comments_form_closed' , __( 'New comments are not being accepted at this time, please feel free to contact the post author directly.', 'opusprimus' ) ) .
                '</span>'
            );
        } /** End if - not is page */

    } /** End function - comments form closed */


    /**
     * Comment Author Class
     * Add additional classes to the comment based on the author
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $comment (global)
     * @uses    user_can
     *
     * @param   array $classes
     *
     * @return  array $classes - original array plus additional role and user-id
     */
    function comment_author_class( $classes ) {
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
        } /** End if - user can */

        /** Add user ID based classes */
        if ( $comment->user_id == 1 ) {
            /** Administrator 'Prime' => first registered user ID */
            $userid = "administrator-prime user-id-1";
        } else {
            /** All other users - NB: user-id-0 -> non-registered user */
            $userid = "user-id-" . ( $comment->user_id );
        } /** End if - user id */
        $classes[] = $userid;

        return $classes;

    } /** End function - comment author class */


    /**
     * Comments Notes Before
     *
     * @package OpusPrimus
     * @since   1.2
     *
     * @uses    apply_filters
     * @uses    get_option
     *
     * @internal ... not used at this time (March 27, 2013)
     *
     * @return  string
     */
    function comments_notes_before() {
        $req = get_option( 'require_name_email' );
        $required_glyph = apply_filters( 'opus_comment_required_glyph', '*' );
        $required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">' . $required_glyph . '</span>' );

        return '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>';
    }


    /**
     * Comment Fields as List Items
     *
     * @package OpusPrimus
     * @since   1.2
     *
     * @uses    esc_attr
     * @uses    get_option
     * @uses    wp_get_current_commenter
     *
     * @return  array
     */
    function comment_fields_as_list_items() {
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $required_glyph = apply_filters( 'opus_comment_required_glyph', '*' );

        $fields =  array(
            'author' => '<li class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">' . $required_glyph . '</span>' : '' ) . '</label> ' .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></li>',
            'email'  => '<li class="comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">' . $required_glyph . '</span>' : '' ) . '</label> ' .
                '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></li>',
            'url'    => '<li class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
                '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></li>',
        );

        return $fields;
    } /** End function - comment fields as list items */


    /**
     * Comment Fields Wrapper Start
     * Echoes an opening `ul` tag
     *
     * @package OpusPrimus
     * @since   1.2
     *
     * @internal Works in conjunction with `comment_fields_as_list_items`
     */
    function comment_fields_wrapper_start() {
        echo '<ul id="comment-fields-listed-wrapper">';
    } /** End function - comment fields wrapper start */


    /**
     * Comment Fields Wrapper End
     * Echoes a closing `ul` tag
     *
     * @package OpusPrimus
     * @since   1.2
     *
     * @internal Works in conjunction with `comment_fields_as_list_items`
     */
    function comment_fields_wrapper_end() {
        echo '</ul><!-- #comment-fields-listed-wrapper -->';
    } /** End function - comment fields wrapper end */


    /** ---- Additional Methods ---- */


    /**
     * Comments Link
     * Displays amount of approved comments the post or page has
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    comments_open
     * @uses    comments_popup_link
     * @uses    is_page
     * @uses    post_password_required
     */
    function comments_link() {
        /** Add empty hook before comments link */
        do_action( 'opus_comments_link_before' );

        echo '<h5 class="comments-link">';
        if ( ! post_password_required() && comments_open() ) {
            if ( is_page() ) {
                comments_popup_link(
                    __( 'There are no comments for this page.', 'opusprimus' ),
                    __( 'There is 1 comment.', 'opusprimus' ),
                    __( 'There are % comments.', 'opusprimus' ),
                    'comments-link',
                    ''
                );
            } else {
                comments_popup_link(
                    __( 'There are no comments for this post.', 'opusprimus' ),
                    __( 'There is 1 comment.', 'opusprimus' ),
                    __( 'There are % comments.', 'opusprimus' ),
                    'comments-link',
                    __( 'Comments are closed.', 'opusprimus' )
                );
            } /** End if - is page */
        } /** End if - not post password required */
        echo '</h5><!-- .comments-link -->';

        /** Add empty hook after comments link */
        do_action( 'opus_comments_link_after' );

    } /** End function - comments link */


    /**
     * Wrapped Comments Template
     * Wraps the comments_template call in action hooks
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    comments_template
     */
    function wrapped_comments_template() {
        /** Add empty hook before comments */
        do_action( 'opus_comments_before' );

        comments_template( '/comments.php', true );

        /** Add empty hook after comments */
        do_action( 'opus_comments_after' );

    } /** End function - wrapped comments template */


    /**
     * Comments Only Tab
     * Displays number of comments for the type:comment tab
     *
     * @package OpusPrimus
     * @since   1.1.1
     *
     * @uses    WP_Query::comments_by_type
     * @uses    __
     * @uses    _n
     */
    function comments_only_tab() {
        global $wp_query;
        $comments_only = $wp_query->comments_by_type['comment'];
        if ( ! empty( $comments_only ) ) { ?>

            <li id="comments-only-tab">
                <a href="#comments-only">
                    <h3 id="comments">
                        <?php
                        printf(
                            _n(
                                __( '%1$s Comment', 'opusprimus' ),
                                __( '%1$s Comments', 'opusprimus' ),
                                count( $comments_only ) ),
                            count( $comments_only )
                        ); ?>
                    </h3><!-- #comments -->
                </a>
            </li><!-- #comments-only-tab -->

        <?php } /** End if - comments by type - comment */
    } /** End function - comments only tab */


    /**
     * Pingbacks Only Tab
     * Displays number of comments for the type:pingback tab
     *
     * @package OpusPrimus
     * @since   1.1.1
     *
     * @uses    WP_Query::comments_by_type
     * @uses    __
     * @uses    _n
     */
    function pingbacks_only_tab() {
        global $wp_query;
        $pingbacks_only = $wp_query->comments_by_type['pingback'];
        if ( ! empty( $pingbacks_only ) ) { ?>

            <li id="pingbacks-only-tab">
                <a href="#pingbacks-only">
                    <h3 id="pingbacks">
                        <?php
                        printf(
                            _n(
                                __( '%1$s Pingback', 'opusprimus' ),
                                __( '%1$s Pingbacks', 'opusprimus' ),
                                count( $pingbacks_only ) ),
                            count( $pingbacks_only )
                        ); ?>
                    </h3><!-- #pingbacks -->
                </a>
            </li><!-- #pingbacks-only-tab -->

        <?php } /** End if - pingbacks only */
    } /** End function - pingbacks only tab */


    /**
     * Trackbacks Only Tab
     * Displays number of comments for the type:trackback tab
     *
     * @package OpusPrimus
     * @since   1.1.1
     *
     * @uses    WP_Query::comments_by_type
     * @uses    __
     * @uses    _n
     */
    function trackbacks_only_tab() {
        global $wp_query;
        $trackbacks_only = $wp_query->comments_by_type['trackback'];
        if ( ! empty( $trackbacks_only ) ) { ?>

            <li id="trackbacks-only-tab">
                <a href="#trackbacks-only">
                    <h3 id="trackbacks">
                        <?php
                        printf(
                            _n(
                                __( '%1$s Trackback', 'opusprimus' ),
                                __( '%1$s Trackbacks', 'opusprimus' ),
                                count( $trackbacks_only ) ),
                            count( $trackbacks_only )
                        ); ?>
                    </h3><!-- #trackbacks -->
                </a>
            </li><!-- #trackbacks-only-tab -->

        <?php } /** End if - trackbacks only */
    } /** End function - trackbacks only tab */


    /**
     * Comments Only Panel
     * Displays only those comments of type: comment
     *
     * @package OpusPrimus
     * @since   1.1.1
     *
     * @uses    OpusPrimusNavigation::comments_navigation
     * @uses    WP_Query::comments_by_type
     * @uses    get_option
     * @uses    wp_list_comments
     */
    function comments_only_panel() {
        global $wp_query;
        $comments_only = $wp_query->comments_by_type['comment'];
        if ( ! empty( $comments_only ) ) { ?>

            <div id="comments-only">
                <ul class="comments-list">
                    <?php wp_list_comments( 'type=comment' ); ?>
                </ul><!-- comments-list -->
                <?php
                if ( get_option( 'comments_per_page' ) < count( $comments_only ) ) {
                    global $opus_navigation; $opus_navigation->comments_navigation();
                } /** End if - comments count */ ?>
            </div><!-- #comments-only -->

        <?php } /** End if - not empty - comments */
    } /** End function - comments only panel */


    /**
     * Pingbacks Only Panel
     * Displays only those comments of type: pingback
     *
     * @package OpusPrimus
     * @since   1.1.1
     *
     * @uses    OpusPrimusNavigation::comments_navigation
     * @uses    WP_Query::comments_by_type
     * @uses    get_option
     * @uses    wp_list_comments
     */
    function pingbacks_only_panel() {
        global $wp_query;
        $pingbacks_only = $wp_query->comments_by_type['pingback'];
        if ( ! empty( $pingbacks_only ) ) { ?>

            <div id="pingbacks-only">
                <ul class="pingbacks-list">
                    <?php wp_list_comments( 'type=pingback' ); ?>
                </ul><!-- pingbacks-list -->
                <?php
                if ( get_option( 'comments_per_page' ) < count( $pingbacks_only ) ) {
                    global $opus_navigation; $opus_navigation->comments_navigation();
                } /** End if - comments count */ ?>
            </div><!-- #pingbacks-only -->

        <?php } /** End if - not empty - pingbacks */
    } /** End function - pingbacks only panel */


    /**
     * Trackbacks Only Panel
     * Displays only those comments of type: trackback
     *
     * @package OpusPrimus
     * @since   1.1.1
     *
     * @uses    OpusPrimusNavigation::comments_navigation
     * @uses    WP_Query::comments_by_type
     * @uses    get_option
     * @uses    wp_list_comments
     */
    function trackbacks_only_panel() {
        global $wp_query;
        $trackbacks_only = $wp_query->comments_by_type['trackback'];
        if ( ! empty( $trackbacks_only ) ) { ?>

            <div id="trackbacks-only">
                <ul class="trackbacks-list">
                    <?php wp_list_comments( 'type=trackback' ); ?>
                </ul><!-- trackbacks-list -->
                <?php
                if ( get_option( 'comments_per_page' ) < count( $trackbacks_only ) ) {
                    global $opus_navigation; $opus_navigation->comments_navigation();
                } /** End if - comments count */ ?>
            </div><!-- #trackbacks-only -->

        <?php } /** End if - not empty - trackbacks */
    } /** End function - trackbacks only panel */


    /**
     * All Comments Count
     * Calculates total comments by adding the totals of each of the comment
     * types: comment, pingback, and trackback
     *
     * @package OpusPrimus
     * @since   1.1.1
     *
     * @uses    WP_Query::comments_by_type
     *
     * @return  string
     */
    function all_comments_count() {
        global $wp_query;

        $comments_only = intval( count( $wp_query->comments_by_type['comment'] ) );
        $pingbacks_only = intval( count( $wp_query->comments_by_type['pingback'] ) );
        $trackbacks_only = intval( count( $wp_query->comments_by_type['trackback'] ) );

        /** @var $all_comments - initialize comments counter */
        $all_comments = 0;
        /**
         * To remove a comment type count simply comment out or remove the
         * appropriate line. This will affect the value passed to the method
         * used to display the value.
         * NB: This would be best done via a Child-Theme.
         */
        $all_comments = $all_comments + $comments_only;
        $all_comments = $all_comments + $pingbacks_only;
        $all_comments = $all_comments + $trackbacks_only;

        return $all_comments;

    } /** End function - all comments count */


    /**
     * Show All Comments Count
     * Displays the `all_comments_count` value
     *
     * @package OpusPrimus
     * @since   1.1.1
     *
     * @uses    OpusPrimusComments::all_comments_count
     * @USES    __
     * @uses    _n
     * @uses    do_action
     */
    function show_all_comments_count() {
        /** Add empty hook before all comments count */
        do_action( 'opus_all_comments_count_before' );

        /** Get the total from `all_comments_count` */
        $total_comments = $this->all_comments_count();

        /** Check if there are any comments */
        if ( $total_comments > 0 ) {
            $show_all_comments_count = sprintf( _n( '%s Response', '%s Responses', $total_comments ), $total_comments );
        } else {
            $show_all_comments_count = __( 'No Responses', 'opusprimus' );
        } /** End if - total comments greater than zero */

        /** Display the total comments message */
        echo $show_all_comments_count;

        /** Add empty hook after all comments count */
        do_action( 'opus_all_comments_count_after' );

    } /** End function - show all comments count */


} /** End class Opus Primus Comments */


/** @var $opus_comments - new instance of class */
$opus_comments = new OpusPrimusComments();