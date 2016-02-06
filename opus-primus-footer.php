<?php
/**
 * Footer Template
 *
 * A generic footer template to show when no other more specific post format
 * footer template is available.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2016, Opus Primus
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

/** Get OpusPrimusStructures class object */
$opus_structures = OpusPrimusStructures::create_instance(); ?>

<footer>

	<?php do_action( 'opus_footer_top' ); ?>

	<div id="footer-widgets">
		<?php get_sidebar( 'footer' ); ?>
	</div>
	<!-- #footer-widgets -->

	<h6 id="site-generator">
		<?php echo $opus_structures->credits(); ?>
	</h6><!-- #site-generator -->

	<h6 id="site-copyright">
		<?php echo $opus_structures->copyright(); ?>
	</h6><!-- #site-copyright -->

	<?php do_action( 'opus_footer_bottom' ); ?>

</footer><!-- End footer section -->