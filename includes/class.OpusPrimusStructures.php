<?php
/**
 * Opus Primus Post Structures
 * Controls for the organization and layout of the post and its content.
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

class OpusPrimusStructures {
    /** Construct */
    function __construct() {}

    /**
     * Opus Primus Post Title
     * Outputs the post title
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $before
     * @param   string $after
     * @param   bool $echo
     *
     * @uses    apply_filters
     * @uses    the_title
     */
    function post_title( $before = '', $after = '', $echo = true ) {
        /** Add empty hook before the post title */
        do_action( 'opus_before_post_title' );

        /** The Post Title */
        if ( empty( $before ) )
            $before = '<h2 class="post-title">';
        if ( empty( $after ) )
            $after = '</h2>';
        the_title( $before, $after, $echo );

        /** Add empty hook after the post title */
        do_action( 'opus_after_post_title' );

    }

    /**
     * Opus Primus No Title Link
     *
     * This returns a URL to the post using the anchor text 'Posted' in the meta
     * details with the post excerpt as the URL title; or, returns the word
     * 'Posted' if the post title exists
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @param       string $anchor - word or phrase to use as anchor text when no title is present
     *
     * @uses        apply_filters
     * @uses        get_permalink
     * @uses        get_the_excerpt
     * @uses        get_the_title
     *
     * @return      string - URL|text
     */
    function no_title_link( $anchor ) {
        /** Create URL or string text */
        $opus_no_title = get_the_title();
        empty( $opus_no_title )
            ? $opus_no_title = '<span class="no-title"><a href="' . get_permalink() . '" title="' . get_the_excerpt() . '">' . $anchor . '</span></a>'
            : $opus_no_title = $anchor;
        return apply_filters( 'no_title_link', $opus_no_title );
    }

    /**
     * Opus Primus Comments Link
     * Displays amount of approved comments the post or page has
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    comments_popup_link
     * @uses    is_page
     */
    function comments_link() {
        /** Add empty hook before comments link */
        do_action( 'opus_before_comments_link' );

        if ( ! post_password_required() && comments_open() ) {
            if ( is_page() ) {
                comments_popup_link(
                    __( 'There are no comments.', 'opusprimus' ),
                    __( 'There is 1 comment.', 'opusprimus' ),
                    __( 'There are % comments.', 'opusprimus' ),
                    'comments-link',
                    ''
                );
            } else {
                comments_popup_link(
                    __( 'There are no comments.', 'opusprimus' ),
                    __( 'There is 1 comment.', 'opusprimus' ),
                    __( 'There are % comments.', 'opusprimus' ),
                    'comments-link',
                    __( 'Comments are closed.', 'opusprimus' )
                );
            }
        }

        /** Add empty hook after comments link */
        do_action( 'opus_after_comments_link' );

    }

    /**
     * Opus Primus Post By Line
     * Outputs post meta details consisting of a configurable anchor for post
     * link anchor text, the date and time posted, and the post author. The post
     * author is also linked to the author's archive page.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   array|string $byline_args - function controls
     *
     * @internal    @param   string $anchor ( default = Posted )
     * @internal    @param   string $show_mod_author ( default = false )
     * @internal    @param   string $tempus ( default = date ) - date|time
     *
     * @example     post_byline( array( 'anchor' => 'Written', 'tempus' => 'time' ) )
     * @internal    This example will use the word "Written" as the anchor text
     * if there is no title for the post; using 'time' will show the modified
     * post author if there is any difference in time while using the default
     * 'date' will only show if there is a difference of more than one (1) day.
     * Also note, 'show_mod_author' is not needed if 'tempus' is set to 'time'.
     *
     * @uses    do_action
     * @uses    esc_attr
     * @uses    get_author_posts_url
     * @uses    get_option ( date_format, time_format )
     * @uses    get_the_author
     * @uses    get_the_author_meta ( ID )
     * @uses    get_the_date
     * @uses    get_the_time
     * @uses    no_title_link
     * @uses    wp_parse_args
     */
    function post_byline( $byline_args = '' ) {
        /** Set defaults */
        $defaults = array(
            'anchor'            => 'Posted',
            'show_mod_author'   => false,
            'tempus'            => 'date',
        );
        $byline_args = wp_parse_args( (array) $byline_args, $defaults );

        /** Grab the author ID from within the loop and globalize it for later use. */
        global $opus_author_id;
        $opus_author_id = get_the_author_meta( 'ID' );

        /** Add empty hook before post by line */
        do_action( 'opus_before_post_byline' );

        /** @var string $opus_post_byline - create byline details string */
        $opus_post_byline = __( '%1$s on %2$s at %3$s by %4$s', 'opusprimus' );
        /**
         * Output post byline (date, time, and author) and open the CSS wrapper
         */
        echo '<div class="meta-byline">';
        printf( $opus_post_byline,
            $this->no_title_link( $byline_args['anchor'] ),
            get_the_date( get_option( 'date_format' ) ),
            get_the_time( get_option( 'time_format' ) ),
            sprintf( '<span class="author-url"><a class="archive-url" href="%1$s" title="%2$s">%3$s</a></span>',
                get_author_posts_url( $opus_author_id ),
                esc_attr( sprintf( __( 'View all posts by %1$s', 'opusprimus' ), get_the_author() ) ),
                get_the_author()
            )
        );

        /**
         * Show modified post author if set to true or if the time span is
         * measured in hours
         */
        if ( $byline_args['show_mod_author'] || ( 'time' == $byline_args['tempus'] ) ) {
            $this->modified_post( $byline_args['tempus'] );
        }

        /** Close CSS wrapper for the post byline */
        echo '</div>';

        /** Add empty hook after post by line */
        do_action( 'opus_after_post_byline' );

    }

    /**
     * Opus Primus Modified Post
     *
     * If the post time and the last modified time are different display
     * modified date and time and the modifying author
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $tempus - date|time ( default = date )
     *
     * @uses    (global) $post
     * @uses    do_action
     * @uses    get_post_meta
     * @uses    get_the_date
     * @uses    get_the_modified_date
     * @uses    get_the_modified_time
     * @uses    get_the_time
     * @uses    get_userdata
     * @uses    home_url
     */
    function modified_post( $tempus = 'date' ){
        /** Grab the $post object and bring in the original post author ID */
        global $post, $opus_author_id;

        /** @var $last_user - establish the last user */
        $last_user = '';
        if ( $last_id = get_post_meta( $post->ID, '_edit_last', true ) ) {
            $last_user = get_userdata( $last_id );
        }

        /**
         * @var $line_height - set value for use with `get_avatar`
         * @todo Review if this can be set programmatically
         */
        $line_height = 19;

        /** @var string $mod_author_phrase - create the "mod_author_phrase"
         * depending on whether or not the modifying author is the same as the
         * post author or another author.
         */
        $mod_author_phrase = ' ';
        /**
         * Check last_user ID exists in database; and, then compare user IDs.
         * If the last user is not in the database an error will occur, and if
         * the last user is not in the database then the modifications should
         * not be noted ( per developer prerogative ).
         * @todo review as additional use-cases arise
         */
        if ( ( ! empty( $last_user ) ) && ( $opus_author_id !== $last_user->ID ) ) {
            $mod_author_phrase .= __( 'Last modified by %1$s %2$s on %3$s at %4$s.', 'opusprimus' );
            $mod_author_avatar = get_avatar( $last_user->user_email, $line_height );

            /**
             * Add empty hook before modified post author for use when the post
             * author and the last (modified) author are different.
             */
            do_action( 'opus_before_modified_post' );

        } else {
            $mod_author_phrase .= __( 'and modified on %3$s at %4$s.', 'opusprimus' );
            $mod_author_avatar = '';
        }

        /** Check if there is a time difference from the original post date */
        if ( 'time' == $tempus ) {
            if ( get_the_time() <> get_the_modified_time() ) {
                /** @var $mod_author_phrase string */
                printf( '<span class="author-modified-time">' . $mod_author_phrase . '</span>',
                    $mod_author_avatar,
                    '<a href="' . home_url( '?author=' . $last_user->ID ) . '">' . $last_user->display_name . '</a>',
                    get_the_modified_date( get_option( 'date_format' ) ),
                    get_the_modified_time( get_option( 'time_format' ) ) );
            }
        } else {
            if ( get_the_date() <> get_the_modified_date() ) {
                printf( '<span class="author-modified-date">' . $mod_author_phrase . '</span>',
                    $mod_author_avatar,
                    '<a href="' . home_url( '?author=' . $last_user->ID ) . '">' . $last_user->display_name . '</a>',
                    get_the_modified_date( get_option( 'date_format' ) ),
                    get_the_modified_time( get_option( 'time_format' ) ) );
            }
        }

        /** Add empty hook after modified post author */
        do_action( 'opus_after_modified_post' );

    }

    /**
     * Opus Primus Meta Tags
     *
     * Prints HTML with meta information for the current post (category, tags
     * and permalink) - inspired by TwentyTen
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @internal    REQUIRES use within the_Loop
     *
     * @param       string $anchor ( default = Posted )
     *
     * @uses    do_action
     * @uses    get_permalink
     * @uses    get_post_type
     * @uses    get_the_category_list
     * @uses    get_the_tag_list
     * @uses    no_title_link
     * @uses    the_title_attribute
     */
    function meta_tags( $anchor = 'Posted' ) {
        /** Add empty hook before meta tags */
        do_action( 'opus_before_meta_tags' );

        /**
         * Retrieves tag list of current post, separated by commas; if there are
         * tags associated with the post show them, If there are no tags on for
         * the post then do not make any references to tags.
         */
        $opus_tag_list = get_the_tag_list( '', ', ', '' );
        if ( $opus_tag_list ) {
            $opus_posted_in = __( '%1$s in %2$s and tagged %3$s. Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark.', 'opusprimus' );
        } else {
            $opus_posted_in = __( '%1$s in %2$s. Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark.', 'opusprimus' );
        }
        /**
         * Prints the "opus_posted_in" string, replacing the placeholders
         */
        printf( '<p class="meta-tags">' . $opus_posted_in . '</p>',
            $this->no_title_link( $anchor ),
            get_the_category_list( ', ' ),
            $opus_tag_list,
            get_permalink(),
            the_title_attribute( 'echo=0' )
        );

        /** Add empty hook after meta tags */
        do_action( 'opus_after_meta_tags' );

    }

    /**
     * Opus Primus Post Content
     * Outputs `the_content` and allows for the_content parameters to be used
     *
     * @link    http://codex.wordpress.org/Function_Reference/the_content
     * @example post_content( __( 'Read more of ...', 'opusprimus' ), the_title( '', '', false ) )
     * @internal The above example, when the <!--more--> tag is used, will
     * provide a link to the single view of the post with the anchor text of:
     * "Read more of ... <the-post-title>"
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $more_link_text
     * @param   string $stripteaser
     *
     * @uses    do_action
     * @uses    the_content
     */
    function post_content( $more_link_text = '', $stripteaser = '' ) {
        /** Add empty hook before the content */
        do_action( 'opus_before_the_content' );

        /** The post excerpt */
        the_content( $more_link_text, $stripteaser );

        /** Add empty hook after the content */
        do_action( 'opus_after_the_content' );

    }

    /**
     * Opus Primus Post Excerpt
     * Outputs `the_excerpt`
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    the_excerpt
     */
    function post_excerpt() {
        /** Add empty hook before the excerpt */
        do_action( 'opus_before_the_excerpt' );

        /** The post excerpt */
        the_excerpt();

        /** Add empty hook after the excerpt */
        do_action( 'opus_after_the_excerpt' );

    }

    /**
     * Opus Primus Post Author
     * Outputs the author details: web address, email, and biography from the
     * user profile information - not designed for use in the post meta section.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    do_action
     * @uses    get_avatar
     * @uses    get_the_author_meta ( display_name, user_url, user_email, user_description )
     * @uses    user_can
     */
    function post_author() {
        /** Get and set variables */
        global $opus_author_id;
        if ( ! isset( $opus_author_id ) )
            $opus_author_id = '';
        $opus_author_display_name   = get_the_author_meta( 'display_name', $opus_author_id );
        $opus_author_url            = get_the_author_meta( 'user_url', $opus_author_id );
        $opus_author_email          = get_the_author_meta( 'user_email', $opus_author_id );
        $opus_author_desc           = get_the_author_meta( 'user_description', $opus_author_id );

        /** Add empty hook before post author details */
        do_action( 'opus_before_post_author' );

        /** Author details */ ?>
        <div class="author details <?php
            /** Pay homage to the first administrator ... do not forget a trailing space */
            if ( $opus_author_id == '1' ) echo 'administrator-prime ';
            /** Add class as related to the user role (see 'Role:' drop-down in User options) */
            if ( user_can( $opus_author_id, 'administrator' ) ) {
                echo 'administrator';
            } elseif ( user_can( $opus_author_id, 'editor' ) ) {
                echo 'editor';
            } elseif ( user_can( $opus_author_id, 'contributor' ) ) {
                echo 'contributor';
            } elseif ( user_can( $opus_author_id, 'subscriber' ) ) {
                echo 'subscriber';
            } else {
                echo 'guest';
            } ?>">
            <h2>
                <?php
                if ( ! empty( $opus_author_id ) )
                    echo get_avatar( $opus_author_id );
                    printf( __( 'About %1$s', 'opusprimus' ), $opus_author_display_name ); ?>
            </h2>
            <ul>
                <?php
                if ( ! empty( $opus_author_url ) ) { ?>
                    <li>
                        <?php
                        printf( __( 'Visit the web site of %1$s or email %2$s.', 'opusprimus' ),
                            '<a href="' . $opus_author_url . '">' . $opus_author_display_name . '</a>',
                            '<a href="mailto:' .  $opus_author_email . '">' . $opus_author_display_name . '</a>'
                        ); ?>
                    </li>
                <?php }
                if ( ! empty( $opus_author_desc ) ) { ?>
                    <li>
                        <?php printf( __( 'Biography: %1$s', 'opusprimus' ), $opus_author_desc ); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <?php
        /** Add empty hook after post author details */
        do_action( 'opus_after_post_author' );

    }

    /**
     * Opus Primus Search Results
     * Outputs message if no posts are found by 'the_Loop' query
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    $opus_archive ( global )
     * @uses    do_action
     * @uses    esc_html
     * @uses    get_search_form
     * @uses    get_search_query
     * @uses    top_10_categories_archive
     *
     * @todo Add custom searchform.php
     */
    function search_results(){
        /** Add empty hook before no posts results from the_loop query */
        do_action( 'opus_before_search_results' );

        /** No results from the_loop query */ ?>
        <h2 class="post-title">
            <?php printf( __( 'Search Results for: %s', 'opus' ), '<span class="search-results">' . esc_html( get_search_query() ) . '</span>' ); ?>
        </h2>

        <?php
        printf( '<p class="no-results">%1$s</p>', __( 'No results were found. Please feel free to search again.', 'opusprimus' ) );
        get_search_form();

        printf( '<p class="no-results">%1$s</p>', __( '... or try one of the links below.', 'opusprimus' ) );

        /** Get the class variables */
        global $opus_archive, $opus_nav;
        /** Display a list of categories to choose from */
        $opus_archive->categories_archive( array(
            'orderby'       => 'count',
            'order'         => 'desc',
            'show_count'    => 1,
            'hierarchical'  => 0,
            'title_li'      => '<span class="title">' . __( 'Top 10 Categories by Post Count:', 'opusprimus' ) . '</span>',
            'number'        => 10,
        ) );
        /** Display a list of tags to choose from */
        $opus_archive->archive_cloud( array(
            'taxonomy'  => 'post_tag',
            'orderby'   => 'count',
            'order'     => 'DESC',
            'number'    => 10,
        ) );
        /** Display a list of pages to choose from */
        $opus_nav->opus_search_menu();

        /** Add empty hook after no posts results from the_loop query */
        do_action( 'opus_after_search_results' );

    }
}
$opus_structure = new OpusPrimusStructures();