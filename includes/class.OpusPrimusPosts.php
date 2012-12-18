<?php
/**
 * Opus Primus Posts
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

class OpusPrimusPosts {
    /** Constructor */
    function __construct() {
        /** Add classes to post tag */
        add_filter( 'post_class', array( $this, 'post_classes' ) );
    }

    /**
     * Post Classes
     * A collection of classes added to the post_class for various purposes
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   $classes - existing post classes
     *
     * @uses    get_the_author_meta
     * @uses    get_the_date
     * @uses    get_the_modified_date
     * @uses    ($this->)replace_spaces
     *
     * @return  string - specific class based on active columns
     */
    function post_classes( $classes ) {
        /** Call the structure class to use replace spaces */
        global $opus_structure;
        /** Original Post Classes */
        /** Year */
        $post_year = get_the_date( 'Y' );
        $classes[] = 'year-' . $post_year;
        $post_leap_year = get_the_date( 'L' );
        if ( '1' == $post_leap_year ) {
            $classes[] = 'leap-year';
        }
        /** Month */
        $post_month_numeric = get_the_date( 'm' );
        $classes[] = 'month-' . $post_month_numeric;
        $post_month_short = get_the_date( 'M' );
        $classes[] = 'month-' . strtolower( $post_month_short );
        $post_month_long = get_the_date( 'F' );
        $classes[] = 'month-' . strtolower( $post_month_long );
        /** Day */
        $post_day_of_month = get_the_date( 'd' );
        $classes[] = 'day-' . $post_day_of_month;
        $post_day_of_week_short = get_the_date( 'D' );
        $classes[] = 'day-' . strtolower( $post_day_of_week_short );
        $post_day_of_week_long = get_the_date( 'l' );
        $classes[] = 'day-' . strtolower( $post_day_of_week_long );
        /** Time: Hour */
        $post_24_hour = get_the_date( 'H' );
        $classes[] = 'hour-' . $post_24_hour;
        $post_12_hour = get_the_date( 'ha' );
        $classes[] = 'hour-' . $post_12_hour;
        /** Author */
        $opus_author_id = get_the_author_meta( 'ID' );
        $classes[] = 'author-' . $opus_author_id;
        $display_name = $opus_structure->replace_spaces( strtolower( get_the_author_meta( 'display_name', $opus_author_id ) ) );
        $classes[] = 'author-' . $display_name;

        /** Modified Post Classes */
        if ( get_the_date() <> get_the_modified_date() ) {
            $classes[] = 'modified-post';
            /** Year - Modified */
            $post_year = get_the_modified_date( 'Y' );
            $classes[] = 'modified-year-' . $post_year;
            $post_leap_year = get_the_modified_date( 'L' );
            if ( '1' == $post_leap_year ) {
                $classes[] = 'modified-leap-year';
            }
            /** Month - Modified */
            $post_month_numeric = get_the_modified_date( 'm' );
            $classes[] = 'modified-month-' . $post_month_numeric;
            $post_month_short = get_the_modified_date( 'M' );
            $classes[] = 'modified-month-' . strtolower( $post_month_short );
            $post_month_long = get_the_modified_date( 'F' );
            $classes[] = 'modified-month-' . strtolower( $post_month_long );
            /** Day - Modified */
            $post_day_of_month = get_the_modified_date( 'd' );
            $classes[] = 'modified-day-' . $post_day_of_month;
            $post_day_of_week_short = get_the_modified_date( 'D' );
            $classes[] = 'modified-day-' . strtolower( $post_day_of_week_short );
            $post_day_of_week_long = get_the_modified_date( 'l' );
            $classes[] = 'modified-day-' . strtolower( $post_day_of_week_long );
            /** Time: Hour - Modified */
            $post_24_hour = get_the_modified_date( 'H' );
            $classes[] = 'modified-hour-' . $post_24_hour;
            $post_12_hour = get_the_modified_date( 'ha' );
            $classes[] = 'modified-hour-' . $post_12_hour;

            /** @var $last_user - establish the last user */
            global $post;
            $last_user = '';
            if ( $last_id = get_post_meta( $post->ID, '_edit_last', true ) ) {
                $last_user = get_userdata( $last_id );
            }
            $mod_author_id = $last_user->ID;
            $classes[] = 'modified-author-' . $mod_author_id;
            $mod_author_display_name = $opus_structure->replace_spaces( $last_user->display_name );
            $classes[] = 'modified-author-' . $mod_author_display_name;
        }

        /** Return the classes for use with the `post_class` hook */
        return $classes;

    }

    /**
     * Post Title
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
        if ( empty( $before ) ) {
            $before = '<h2 class="post-title">';
        }
        if ( empty( $after ) ) {
            $after = '</h2>';
        }

        /** Wrap the title in an anchor tag and provide a nice tool tip */ ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'View', 'opusprimus' ) . ' ', 'after' => ' ' . __( 'only', 'opusprimus' ) ) ); ?>">
            <?php the_title( $before, $after, $echo ); ?>
        </a>

        <?php
        /** Add empty hook after the post title */
        do_action( 'opus_after_post_title' );

    }

    /**
     * No Title Link
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
        return apply_filters( 'opus_no_title_link', $opus_no_title );
    }

    /**
     * Post Format Flag
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

        return apply_filters( 'opus_post_format_flag', $output );
    }

    /**
     * Sticky Flag
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
            $sticky_text = apply_filters( 'opus_default_sticky_flag', $sticky_text );
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

        return apply_filters( 'opus_sticky_flag', $output );

    }

    /**
     * Post Byline
     * Outputs post meta details consisting of a configurable anchor for post
     * link anchor text, the date and time posted, and the post author. The post
     * author is also linked to the author's archive page.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   array|string $byline_args - function controls
     *
     * @internal    @param string $anchor ( default = Posted )
     * @internal    @param string $show_mod_author ( default = false )
     * @internal    @param string $sticky_flag ( default = '' )
     * @internal    @param string $tempus ( default = date ) - date|time
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
     *
     * @todo Review for additional filter options
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
        $opus_post_byline = apply_filters( 'opus_post_byline_details', __( '%1$s on %2$s at %3$s by %4$s', 'opusprimus' ) );
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
     * Modified Post
     * If the post time and the last modified time are different display
     * modified date and time and the modifying author
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @param   string $tempus - date|time ( default = date )
     *
     * @uses    (global) $opus_author_id
     * @uses    (global) $post
     * @uses    apply_filters
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
         */
        if ( ( ! empty( $last_user ) ) && ( $opus_author_id <> $last_id ) ) {
            $mod_author_phrase .= apply_filters( 'opus_mod_different_author_phrase', __( 'Last modified by %1$s %2$s on %3$s at %4$s.', 'opusprimus' ) );
            $mod_author_avatar = get_avatar( $last_user->user_email, $line_height );

            /**
             * Add empty hook before modified post author for use when the post
             * author and the last (modified) author are different.
             */
            do_action( 'opus_before_modified_post' );

        } else {
            $mod_author_phrase .= apply_filters( 'opus_mod_same_author_phrase', __( 'and modified on %3$s at %4$s.', 'opusprimus' ) );
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
     * Uncategorized
     * Returns true if there is only one category assigned to the post and it is
     * the WordPress default "Uncategorized". Renaming the default category will
     * avoid this function being used.
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @internal Must be called inside the_Loop
     *
     * @uses    get_the_category
     * @uses    get_the_category_by_ID
     *
     * @return bool
     */
    function uncategorized() {
        if ( 'uncategorized' == strtolower( get_the_category_by_ID( 1 ) ) ) {
            /** @var $all_categories - create array object of all post categories */
            $all_categories = get_the_category();
            /**
             * Conditional check for a single category found at index 0
             * Check if second array element is empty found at index 1
             */
            if ( empty ( $all_categories[1] ) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Meta Tags
     * Prints HTML with meta information for the current post (category, tags
     * and permalink) - inspired by TwentyTen
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @internal REQUIRES use within the_Loop
     *
     * @param   string $anchor ( default = Posted ) - passed from the loops
     *
     * @uses    do_action
     * @uses    get_permalink
     * @uses    get_post_type
     * @uses    get_the_category_list
     * @uses    get_the_tag_list
     * @uses    no_title_link
     * @uses    the_title_attribute
     */
    function meta_tags( $anchor ) {
        /** Add empty hook before meta tags */
        do_action( 'opus_before_meta_tags' );

        /**
         * Retrieves tag list of current post, separated by commas; if there are
         * tags associated with the post show them, If there are no tags for the
         * post do not make any references to tags.
         */
        $opus_tag_list = get_the_tag_list( '', ', ', '' );
        if ( ( $opus_tag_list ) && ( ! $this->uncategorized() ) ) {
            $opus_posted_in = __( '%1$s in %2$s and tagged %3$s. Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark.', 'opusprimus' );
        } elseif ( ( $opus_tag_list ) && ( $this->uncategorized() ) ) {
            $opus_posted_in = __( '%1$s and tagged %3$s. Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark.', 'opusprimus' );
        } elseif ( ( ! $opus_tag_list ) && ( ! $this->uncategorized() ) ) {
            $opus_posted_in = __( '%1$s in %2$s. Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark.', 'opusprimus' );
        } else {
            $opus_posted_in = __( 'Use this <a href="%4$s" title="Permalink to %5$s" rel="bookmark">permalink</a> for a bookmark.', 'opusprimus' );
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
     * Status Update
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
     * Post Content
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

        /** Check if there the more_link_text parameter has been set */
        if ( empty( $more_link_text ) ) {
            $more_link_text = __( 'Continue reading ... ', 'opusprimus' ) . the_title( '', '', false );
        }
        /** Check if there the stripteaser parameter has been set */
        if ( empty( $stripteaser ) ) {
            $stripteaser = '';
        }

        /** Wrap the post content in its own container */
        echo '<div class="post-content">';
        the_content( $more_link_text, $stripteaser );
        echo '</div>';

        /** Add empty hook after the content */
        do_action( 'opus_after_the_content' );

    }

    /**
     * Post Excerpt
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

        /** Wrap the post excerpt in its own CSS container */
        echo '<div class="post-excerpt">';
        the_excerpt();
        echo '</div>';

        /** Add empty hook after the excerpt */
        do_action( 'opus_after_the_excerpt' );

    }

    /**
     * Post Coda
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
        printf( '<div class="post-coda">%1$s</div>', apply_filters( 'opus_post_coda', $post_coda )  );

        /** Add empty hook after the post coda */
        do_action( 'opus_after_post_coda' );

    }

}
$opus_post = new OpusPrimusPosts();