<?php
/**
 * Opus Primus Post Structures
 * Controls for the organization and layout of the site and its content.
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

class OpusPrimusPullQuotes {

    /** Constructor */
    function __construct(){
        /** Enqueue Scripts and Styles */
        add_action( 'wp_enqueue_scripts', array( $this, 'scripts_and_styles' ) );

        /** Add Shortcode */
        add_shortcode( 'pullquote', array( $this, 'pull_quotes_shortcode' ) );

    }

    /**
     * Enqueue Scripts and Styles
     * Use to enqueue the extension scripts and stylesheets, if they exists
     *
     * @package OpusPrimus
     * @since   0.1
     *
     * @uses    (constant) OPUS_CSS
     * @uses    (constant) OPUS_JS
     * @uses    wp_enqueue_script
     * @uses    wp_enqueue_style
     *
     * @internal    jQuery is enqueued as a dependency
     */
    function scripts_and_styles() {
        /** Enqueue scripts */
        /** Enqueue Opus Primus JavaScripts which will enqueue jQuery as a dependency */
        wp_enqueue_script( 'opus-primus-pullquote', OPUS_JS . 'opus-primus.pullquote.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );
        /** Enqueue Theme Stylesheets */
        wp_enqueue_style( 'Opus-Primus-PullQuote', OPUS_CSS . 'opus-primus.pullquote.css', array(), wp_get_theme()->get( 'Version' ), 'screen' );
    }

    /**
     * PullQuotes Shortcode
     *
     * @package Opus_Primus
     * @since   0.1
     */
    function pull_quotes_shortcode( $atts, $content = null ) {
        extract(
            shortcode_atts(
                array(
                    'by'    => '',
                    'from'  => '',
                ),
                $atts )
        );

        if ( ! empty( $by ) ) {
            $content .= '<br />' . '<cite>' . $by . '</cite>';
        }

        if ( ! empty( $from ) ) {
            $content .= '<br />' . '<cite>' . $from . '</cite>';
        }

        if ( empty( $content ) ) {
            return null;
        }

        $content = '<span class="pq">' . $content . "</span>";

        return $content;

    }

}
$pull_quotes = new OpusPrimusPullQuotes();