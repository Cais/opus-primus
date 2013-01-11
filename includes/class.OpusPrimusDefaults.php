<?php
/**
 * Opus Primus Defaults
 * Set global defaults for boolean options used in theme
 *
 * @package     OpusPrimus
 * @since       0.1
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

if ( ! class_exists( 'OpusPrimusDefaults' ) ) {
    /**
     * The easiest method to use this in a Child-Theme would be to copy the
     * entire OpusPrimusDefaults class then change the defaults as needed.
     *
     * Also to note, each default can be "toggled" by adding an exclamation mark
     * (programmatic not) in front of the instance of the method call.
     */
    class OpusPrimusDefaults {
        /** Constructor */
        function __construct() {}

        /** Post Byline and Post Author parameters */
        function show_mod_author() { return true; }
        function show_author_url() { return true; }
        function show_author_email() { return true; }
        function show_author_desc() { return true; }

    }
    $opus_defaults = new OpusPrimusDefaults();
}