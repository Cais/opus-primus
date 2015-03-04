<?php
/**
 * Opus Primus
 *
 * A WordPress Framework Theme.
 *
 * @package     OpusPrimus
 * @version     1.3.3
 * @date        March 3, 2015
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2015, Opus Primus
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

$opus_structures = new OpusPrimusStructures();

get_header();

do_action( 'opus_content_before' ); ?>

	<div class="content-wrapper cf">

		<?php
		do_action( 'opus_content_top' );

		/** Open the necessary layout CSS classes */
		echo $opus_structures->layout_open();

		/** The complete loop section */
		$opus_structures->the_loop_wrapped();

		get_sidebar();

		/** Close the classes written by the layout_open method */
		echo $opus_structures->layout_close();

		do_action( 'opus_content_bottom' ); ?>

	</div><!-- #content-wrapper -->

<?php
do_action( 'opus_content_after' );

get_footer();