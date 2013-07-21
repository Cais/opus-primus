<?php
/**
 * Opus Primus PullQuotes Stanza
 * This provides pull quote functionality to the Opus Primus theme as a feature
 * to display highlighted or emphasized content.
 *
 * @package     OpusPrimus
 * @subpackage  PullQuotes
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2013, Opus Primus
 *
 * This file is part of Opus Primus PullQuotes, a part of Opus Primus.
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
 * @version 1.2
 * @date    March 25, 2012
 * Added block termination comments
 */

class OpusPrimusPullQuotes {

    /**
     * Constructor
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    add_action
     * @uses    add_shortcode
     */
    function __construct(){
        /** Enqueue Scripts and Styles */
        add_action( 'wp_enqueue_scripts', array( $this, 'scripts_and_styles' ) );

        /** Add Shortcode */
        add_shortcode( 'pullquote', array( $this, 'pull_quotes_shortcode' ) );

    } /** End function - constructor */


    /**
     * Enqueue Scripts and Styles
     * Use to enqueue the extension scripts and stylesheets, if they exists
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    wp_enqueue_script
     * @uses    wp_enqueue_style
     *
     * @internal    jQuery is enqueued as a dependency
     */
    function scripts_and_styles() {
        /** Enqueue Scripts */
        /** Enqueue Opus Primus PullQuotes JavaScripts which will enqueue jQuery as a dependency */
        wp_enqueue_script( 'opus-primus-pullquote', OPUS_STANZAS_URI .'pullquotes/opus-primus.pullquote.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );

        /** Enqueue Styles */
        /** Enqueue PullQuotes Stanza Stylesheets */
        wp_enqueue_style( 'Opus-Primus-PullQuote', OPUS_STANZAS_URI . 'pullquotes/opus-primus.pullquote.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );

    } /** End function - scripts and styles */


    /**
     * PullQuotes Shortcode
     *
     * @package Opus_Primus
     * @since   0.1
     *
     * @uses    shortcode_atts
     *
     * @version 1.2
     * @date    March 25, 2013
     * Added `to` attribute to allow for left-side or right-side (default)
     * pull quote placements
     */
    function pull_quotes_shortcode( $atts, $content = null ) {
        extract(
            shortcode_atts(
                array(
                    'to'    => 'right',
                    'by'    => '',
                    'from'  => '',
                ),
                $atts )
        );

        if ( ! empty( $by ) ) {
            $content .= '<br />' . '<cite>' . $by . '</cite>';
        } /** End if - not empty - by */

        if ( ! empty( $from ) ) {
            $content .= '<br />' . '<cite>' . $from . '</cite>';
        } /** End if - not empty - from */

        if ( empty( $content ) ) {
            return null;
        } /** End if - empty content */

        if ( ! empty( $to ) && ( 'left' == $to ) ) {
            $content = '<span class="pql">' . $content . "</span>";
        } else {
            $content = '<span class="pq">' . $content . "</span>";
        } /** End if - not empty - to left|right(default) */

        return $content;

    } /** End function - pull quotes shortcode */


} /** End class - pull quotes */


/** @var $pull_quotes - initialize class */
$pull_quotes = new OpusPrimusPullQuotes();