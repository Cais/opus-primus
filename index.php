<?php
/**
 * Opus Primus
 * A WordPress Framework Theme.
 *
 * @package     OpusPrimus
 * @version     1.0
 *
 * @internal    RECOMMENDED HTML5
 * @internal    RECOMMENDED CSS3
 * @internal    REQUIRED    WordPress 3.4
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
 * Replace `the_loop` method and surrounding code with `the_loop_wrapped`
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 */

global $opus_structures;
get_header();

/** Add empty hook before content */
do_action( 'opus_content_before' ); ?>

<div class="content-wrapper cf">

    <?php
    /** Add empty hook at top of the content */
    do_action( 'opus_content_top' );

    /** Open the necessary layout CSS classes */
    echo $opus_structures->layout_open();

    /** The complete loop section */
    $opus_structures->the_loop_wrapped();

    /** Call the sidebar */
    get_sidebar();

    /** Close the classes written by the layout_open call */
    echo $opus_structures->layout_close();

    /** Add empty hook at the bottom of the content */
    do_action( 'opus_content_bottom' ); ?>

</div><!-- #content-wrapper -->

<?php
/** Add empty hook after the content */
do_action( 'opus_content_after' );

get_footer();