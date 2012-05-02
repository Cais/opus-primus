<?php
/**
 * Opus Primus Social
 * Controls for the social extensions, buttons, shares, etc.
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

class OpusPrimusSocial {
    /** Construct */
    function __construct() {}

    /**
     * Google+ Share
     * @todo Look at using wp_enqueue on this
     */
    function opus_primus_google_plus_share() {
        echo '
            <script src="https://apis.google.com/js/plusone.js"></script>
            <g:plus action="share" annotation="bubble"></g:plus>
            ';
    }
}
$opus_shares = new OpusPrimusSocial;
