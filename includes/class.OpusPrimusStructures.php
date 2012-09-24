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
     * Opus Primus Layout - Open
     * Adds appropriate CSS containers depending on the layout structure.
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @uses        is_active_sidebar
     * @internal    works in conjunction with layout_close
     * @internal    $content_width is set based on the amount of columns being displayed and a display using the common 1024px x 768px resolution
     *
     * @return      string
     */
    function layout_open() {
        global $content_width;
        $layout = '';
        /** Test if all widget areas are inactive for one-column layout */
        if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '<div class="column-mask full-page">';
            $content_width = 990;
        }
        /** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '<div class="column-mask right-sidebar"><div class="column-left">';
            $content_width = 700;
        } elseif( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '<div class="column-mask right-sidebar"><div class="column-left">';
            $content_width = 700;
        }
        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '<div class="column-mask blog-style"><div class="column-middle"><div class="column-left">';
            $content_width = 450;
        }

        return $layout;

    }

    /**
     * Opus Primus Layout - Close
     * Closes appropriate CSS containers depending on the layout structure.
     *
     * @package     OpusPrimus
     * @since       0.1
     *
     * @uses        (global) $content_width
     * @uses        is_active_sidebar
     * @internal    works in conjunction with layout_open
     *
     * @return      string
     *
     * @todo Review $content_width settings
     */
    function layout_close() {
        $layout = '';
        /** Test if all widget areas are inactive for one-column layout */
        if ( ! ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) || is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '</div><!-- .column-mask .full-page -->';
        }
        /** Test if the first-sidebar or second-sidebar is active by testing their component widget areas for a two column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '</div><!-- .column-mask .right-sidebar --></div><!--.column-left -->';
        } elseif( ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) )
            && ! ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) )
                && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) ) {
            $layout = '</div><!-- .column-mask .right-sidebar --></div><!--.column-left -->';
        }
        /** Test if at least one widget area in each sidebar area is active for a three-column layout */
        if ( ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) && ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) ) {
            $layout = '</div><!-- .column-mask .blog-style --></div><!-- .column-middle --></div><!-- .column-left -->';
        }

        return $layout;

    }

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
     * @uses    do_action
     * @uses    the_permalink
     * @uses    the_title
     * @uses    the_title_attribute
     */
    function post_title( $before = '', $after = '', $echo = true ) {
        /** Add empty hook before the post title */
        do_action( 'opus_before_post_title' );

        /** Set `the_title` parameters */
        if ( empty( $before ) )
            $before = '<h2 class="post-title">';
        if ( empty( $after ) )
            $after = '</h2>';

        /** Wrap the title in an anchor tag and provide a nice tool tip */ ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ) ) ); ?>">
            <?php the_title( $before, $after, $echo ); ?>
        </a>

        <?php
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

        echo '<h5 class="comments-link">';
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
        echo '</h5><!-- .comments-link -->';

        /** Add empty hook after comments link */
        do_action( 'opus_after_comments_link' );

    }

    /**
     * Opus Primus Post Format Flag
     * Returns a string with the post-format type; optionally can not display a
     * flag for the standard post-format (default).
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    get_post_format
     * @uses    get_post_format_link
     * @uses    get_post_format_string
     *
     * @return  string - link to the post-format specific archive
     */
    function post_format_flag() {

        /** @var $flag_text - post-format */
        $flag_text = get_post_format_string( get_post_format() );
        $title_text = $flag_text;
        if ( 'Standard' == $flag_text ) {
            return null;
        } else {
            $flag_text = '<button><span class="post-format-flag">' . $flag_text . '</span></button>';
        }

        $output = '<a href="' . get_post_format_link( get_post_format() ) . '" title="' . sprintf( __( 'View the %1$s archive.' ), $title_text ) . '">' . $flag_text . '</a>';

        return $output;
    }

    /**
     * Opus Primus Sticky Flag
     * Returns a text string as a button that links to the post, used with the
     * "sticky" post functionality of WordPress
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $sticky_text
     *
     * @uses    apply_filters
     * @uses    is_sticky
     * @uses    get_permalink
     *
     * @return  string
     */
    function sticky_flag( $sticky_text = '' ) {

        if ( '' == $sticky_text ) {
            $sticky_text = __( 'Featured', 'opusprimus' );
            $sticky_text = apply_filters( 'sticky_flag', $sticky_text );
        }
        if ( is_sticky() ) {
            $output = '<a href="' . get_permalink() . '" title="' . sprintf( __( 'Go to %1$s post', 'opusprimus' ), strtolower( $sticky_text ) ) . '">'
                . '<button><span class="sticky-flag-text">'
                . $sticky_text
                . '</span></button>'
                . '</a>';
        } else {
            $output = '';
        }

        return $output;

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
     * @uses    post_format_flag
     * @uses    sticky_flag
     * @uses    wp_parse_args
     */
    function post_byline( $byline_args = '' ) {
        /** Set defaults */
        $defaults = array(
            'anchor'            => 'Posted',
            'show_mod_author'   => false,
            'sticky_flag'       => '',
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

        /** Add a sticky note flag to the byline */
        echo $this->sticky_flag( $byline_args['sticky_flag'] );
        /** Add a post-format flag to the byline */
        echo $this->post_format_flag();

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
        $line_height = 18;

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
     * @example post_content( __( 'Read more of ... ', 'opusprimus' ) . the_title( '', '', false ) )
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

        if ( empty( $more_link_text ) ) {
            $more_link_text = __( 'Continue reading ... ', 'opusprimus' ) . the_title( '', '', false );
        }
        if ( empty( $stripteaser ) ) {
            $stripteaser = '';
        }

        echo '<div class="post-content">';
            /** The post excerpt */
            the_content( $more_link_text, $stripteaser );
        echo '</div>';

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
     * Opus Primus Post Coda
     * Adds text art after post content to signify the end of the post
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    apply_filters
     * @uses    do_action
     */
    function post_coda(){
        /** Add empty hook before post coda */
        do_action( 'opus_before_post_coda' );

        /** Create the text art */
        $post_coda = '* * * * *';
        printf( '<div class="post-coda">%1$s</div>', apply_filters( 'post_coda', $post_coda )  );
        echo '<hr />';

        /** Add empty hook after the post coda */
        do_action( 'opus_after_post_coda' );

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
        $opus_nav->opus_primus_search_menu();

        /** Add empty hook after no posts results from the_loop query */
        do_action( 'opus_after_search_results' );

    }

    /**
     * Opus Primus Status Update
     * Displays the human time difference based on how long ago the post was
     * updated
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $update_text
     * @param   int $time_ago - measured in seconds, default equals one week
     *
     * @uses    do_action
     * @uses    get_the_modified_time
     * @uses    get_the_time
     * @uses    human_time_diff
     *
     * @internal Used with Post-Format: Status
     */
    function status_update( $update_text = 'Updated', $time_ago = 604800 ){
        /** Add empty hook before status update output */
        do_action( 'opus_before_status_update' );

        /** @var int $time_diff - initialize as zero  */
        $time_diff = 0;
        /** Check if the post has been modified and get how long ago that was */
        if ( get_the_modified_time( 'U' ) != get_the_time( 'U' ) ) {
            $time_diff = get_the_modified_time( 'U' ) - get_the_time( 'U' );
        }

        /** Compare time difference between modification and actual post */
        if ( ( $time_diff > $time_ago ) && ( $time_diff < 31449600 ) ) {
            printf( __( '<div class="opus-status-update">%1$s %2$s ago.</div>', 'opusprimus' ), $update_text, human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) );
        } elseif ( $time_diff >= 31449600 ) {
            _e( '<div class="opus-status-update">Updated over a year ago.</div>', 'opusprimus' );
        }

        /** Add empty hook after status update output */
        do_action( 'opus_after_status_update' );

    }

    /**
     * Opus Primus Credits
     * Displays the current theme name and its parent if one exists. Provides
     * links to the Parent-Theme (Opus Primus), to the Child-Theme (if it
     * exists) and to WordPress.org.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    esc_attr__
     * @uses    esc_attr
     * @uses    esc_url
     * @uses    is_child_theme
     * @uses    parent
     * @uses    wp_get_theme
     *
     * @param   bool $show - true|false - default show credits|return null
     *
     * @return  mixed|void - theme credits with links|filtered credits
     */
    function credits( $show = true ) {
        if ( false == $show ) {
            return null;
        }
        $active_theme_data = wp_get_theme();
        if ( is_child_theme() ) {
            $parent_theme_data = $active_theme_data->parent();
            $credits = sprintf(
                '<div class="generator"><span class="credit-phrase">'
                    . __( 'Played on %1$s; tuned to %2$s; and, conducted by %3$s.', 'opusprimus' )
                    . '</span></div>',
                '<span id="parent-theme"><a href="' . esc_url( $parent_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $parent_theme_data->get( 'Description' ) ) . '">' . $parent_theme_data->get( 'Name' ) . '</a></span>',
                '<span id="child-theme"><a href="' . esc_url( $active_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $active_theme_data->get( 'Description' ) ) . '">' . $active_theme_data->get( 'Name' ) . '</a></span>',
                '<span id="wordpress-link"><a href="http://wordpress.org/" title="' . esc_attr__( 'Semantic Personal Publishing Platform', 'opusprimus' ) . '" rel="generator">WordPress</a></span>'
            );
        } else {
            $credits = sprintf(
                '<div class="generator"><span class="credit-phrase">'
                    . __( 'Played on %1$s; and, conducted by %2$s.', 'opusprimus' )
                    . '</span></div>',
                '<span id="parent-theme"><a href="' . esc_url( $active_theme_data->get( 'ThemeURI' ) ) . '" title="' . esc_attr( $active_theme_data->get( 'Description' ) ) . '">' . $active_theme_data->get( 'Name' ) . '</a></span>',
                '<span id="wordpress-link"><a href="http://wordpress.org/" title="' . esc_attr__( 'Semantic Personal Publishing Platform', 'opusprimus' ) . '" rel="generator">WordPress</a></span>'
            );
        }

        return apply_filters( 'opus_primus_credits', $credits );

    }


    /**
     * Opus Primus Copyright
     * Returns copyright year(s) as defined by the dates found in published
     * posts. Recognized the site (via its title) as the copyright holder and
     * notes the terms of the copyright.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @internal $output can be filtered via the `opus_primus_copyright` hook
     *
     * @uses    apply_filters
     * @uses    get_bloginfo
     * @uses    get_posts
     * @uses    home_url
     * @uses    post_date_gmt
     *
     * @param   bool $show
     * @param   bool $by_author
     * @return  mixed|null|void
     *
     * @todo set param as options
     */
    function copyright( $show = true, $by_author = true ){
        if ( false == $show ) {
            return null;
        }

        /** @var $output - initialize output variable to empty */
        $output = '';

        /** @var $all_posts - retrieve all published posts in ascending order */
        $all_posts = get_posts( 'post_status=publish&order=ASC' );
        /** @var $first_post - get the first post */
        $first_post = $all_posts[0];
        /** @var $first_post_date - get the date in a standardized format */
        $first_post_date = $first_post->post_date_gmt;

        /** First post year versus current year */
        $first_post_year = substr( $first_post_date, 0, 4 );
        if ( $first_post_year == '' ) {
            $first_post_year = date( 'Y' );
        }

        /** Add to output string */
        if ( $first_post_year == date( 'Y' ) ) {
            /** Only use current year if no published posts in previous years */
            $output .= sprintf( __( 'Copyright &copy; %1$s', 'opusprimus' ), date( 'Y' ) );
        } else {
            $output .= sprintf( __( 'Copyright &copy; %1$s-%2$s', 'opusprimus' ), $first_post_year, date( 'Y' ) );
        }

        /**
         * Append content owner.
         * Default settings will show post author as the copyright holder in
         * single and page views.
         */
        if ( ( is_single() || is_page() ) && $by_author ) {
            global $post;
            $author = get_the_author_meta( 'display_name', $post->post_author );
            $author_url = get_the_author_meta( 'user_url', $post->post_author );
            $output .= ' <a href="' . $author_url . '" title="' . esc_attr( sprintf( __( 'To the web site of %1$s', 'opusprimus' ), $author ) ) . '" rel="author">' . $author .'</a>';
        } else {
            $output .= ' <a href="' . home_url( '/' ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' . get_bloginfo( 'name', 'display' ) .'</a>';
        }
        /** Append usage terms */
        $output .= ' ' . __( 'All Rights Reserved.', 'opusprimus' );

        return apply_filters( 'opus_primus_copyright', $output );

    }

}
$opus_structure = new OpusPrimusStructures();

/** Testing ... testing ... testing ... */
function opus_test() {
    echo 'BACON Test!!! PS: This works, too!<br />';
}
// add_action( 'opus_after_exif_dimensions', 'opus_test' );
// add_filter( 'opus_primus_credits', 'opus_test' );
