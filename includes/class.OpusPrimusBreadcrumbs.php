<?php
/**
 * Opus Primus Breadcrumbs
 * Creates and display a breadcrumb trail for pages
 *
 * @package     OpusPrimus
 * @since       1.0.4
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2013, Opus Primus
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

class OpusPrimusBreadcrumbs {

    function __construct() {}

    /**
     * Breadcrumbs
     * Collect the post ID of each post in the lineage from the top level
     * "parent" to the current "child" for single view templates
     *
     * @package     OpusPrimus
     * @subpackage  Structures
     * @since       1.0.3-alpha
     *
     * @uses        is_singular
     * @uses        get_post
     *
     * @version     1.0.4
     * @date        March 1, 2013
     * Added 'Breadcrumbs' for pages completed
     *
     * @internal Considered new feature for release at version 1.1.0
     */
    function breadcrumbs() {

        /** Sanity check - are we on a single view template but not single */
        if ( is_singular() && ! is_single() ) {

            /** @var $breadcrumb - empty array to hold the breadcrumb */
            $breadcrumb = array();
            /** @var $x - array index */
            $x = 0;

            /** Get the current post (from outside the_Loop) */
            global $post;

            /** Set initial array element as current post ID */
            $breadcrumb[$x] = $post->ID;

            /** Walk back to the parent getting each post ID  */
            while ( get_post( $breadcrumb[$x] )->post_parent !== 0 ) {
                /** @var $parent_post - current index parent post ID */
                $parent_post = get_post( $breadcrumb[$x] )->post_parent;
                /** Add ID to breadcrumb array */
                $breadcrumb[] = $parent_post;
                /** Increment the index to check the next post */
                $x++;
            }

            /** @var $breadcrumb - reverse the array for parent-child ordering */
            $breadcrumb = array_reverse( $breadcrumb );

            return $breadcrumb;

        } /** End if - is singular */

        return null;

    } /** End function - breadcrumbs */


    /**
     * Post Breadcrumb
     *
     * @package OpusPrimus
     * @since   1.1
     *
     * @return  null|string
     *
     * @todo link category to its archive
     * @todo link Post-Format to its archive
     */
    function post_breadcrumbs() {

        /** Sanity check - are we on a single view template and single */
        if ( is_singular() && is_single() ) {

            /** Get the global post object */
            global $post;

            /** @var $post_ID - the post ID, since its outside the_Loop */
            $post_ID = $post->ID;

            /** @var $post_trail - variable holding the output */
            $post_trail = '<div id="breadcrumbs">';

                $post_trail .= '<ul class="breadcrumb">';
    
                    $post_trail .= '<li>'
                        . '<a href="' . home_url( '/' ) . '">' . __( 'Home', 'opusprimus' ) . '</a>'
                        . '</li>';
    
                    $post_trail .= '<li><ul class="blog-trail-categories">';
    
                    $post_categories = get_the_category( $post_ID );
                    foreach ( $post_categories as $category ) {
    
                        $post_trail .= '<li>';
                        $post_trail .= '<a href="' . home_url( '/?cat=' ) . $category->cat_ID . '">' . $category->name . '</a>';
                        $post_trail .= '</li>';
    
                    }
                    $post_trail .= '</ul></li>';
    
                    $flag_text = get_post_format_string( get_post_format( $post_ID ) );
                    $post_format_output = '<a href="' . get_post_format_link( get_post_format( $post_ID ) ) . '" title="' . sprintf( __( 'View the %1$s archive.', 'opusprimus' ), $post->post_title ) . '">' . $flag_text . '</a>';
    
                    $post_trail .= '<li>' . $post_format_output . '</li>';
    
                    $post_trail .= '<li><a href="#">' . $post->post_title . '</li>';
    
                $post_trail .= '</ul><!-- breadcrumb -->';

            $post_trail .= '</div><!-- #breadcrumbs -->';

            return $post_trail;

        } /** End if - is singular */

        return null;

    } /** End function - post_breadcrumbs */


    /**
     * The Trail
     * Create the trail of breadcrumbs
     *
     * @package     OpusPrimus
     * @subpackage  Breadcrumbs
     * @since       1.0.4
     *
     * @uses        OpusPrimusBreadcrumbs::breadcrumbs
     * @uses        get_post
     * @uses        home_url
     *
     * @todo Address pages without titles ... use Post ID?
     */
    function the_trail() {

        /**
         * Hansel and Gretel did not need breadcrumbs until they left home, no
         * reason we need to have them if we are at home, too.
         */
        if ( null !== $this->breadcrumbs() ) {

            $trail = '<div id="breadcrumbs">';
                $trail .= '<ul class="breadcrumb">';

                    $trail .= '<li>'
                        . '<a href="' . home_url( '/' ) . '">' . __( 'Home', 'opusprimus' ) . '</a>'
                        . '</li>';

                    foreach ( $this->breadcrumbs() as $steps ) {

                        $trail .= '<li>'
                            . '<a title="' . get_post( $steps )->post_title . '" href="' . home_url( '/?page_id=' ) . get_post( $steps )->ID . '">' . get_post( $steps )->post_title . '</a>'
                            . '</li>';

                    } /** End foreach - steps */

                $trail .= '</ul><!-- breadcrumb -->';
            $trail .= '</div><!-- #breadcrumbs -->';

            return $trail;

        } /** End if - no breadcrumbs */

        return null;

    } /** End function - the trail */


    /**
     * Show The Trail
     * Shows the trail of breadcrumbs
     *
     * @package     OpusPrimus
     * @subpackage  Breadcrumbs
     * @since       1.0.4
     *
     * @uses        OpusPrimusBreadcrumbs::the_trail
     */
    function show_the_trail() {
        /** Used on pages */
        echo $this->the_trail();
        /** Used on posts */
        echo $this->post_breadcrumbs();
    } /** End function - show the trail */


} /** End class - opus primus breadcrumbs */


/** @var $opus_breadcrumbs - new instance of class */
$opus_breadcrumbs = new OpusPrimusBreadcrumbs();