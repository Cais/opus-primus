<?php
/**
 * Sidebar Template
 *
 * @package     OpusPrimus
 * @since       0.1
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
 *
 * @package     Opus_Primus
 * @since       0.1
 *
 * @uses        do_action
 * @uses        dynamic_sidebar
 * @uses        is_active_sidebar
 *
 * @version     1.0.1
 * @date        February 21, 2013
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 *
 * @version     1.2.5
 * @date        June 8, 2014
 * Added sanity checks to ensure widgets are active before rendering sidebars
 */

/** Add empty hook before sidebars */
do_action( 'opus_sidebars_before' );

/** Sanity check - do we have any active widgets in "Sidebar Area One" */
if ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) {

	/** Add empty hook before first sidebar */
	do_action( 'opus_first_sidebar_before' ); ?>

	<div class="first-sidebar">

		<ul id="sidebar-one">
			<?php if ( is_active_sidebar( 'first-widget' ) ) {
				dynamic_sidebar( 'first-widget' );
			} ?>
		</ul>
		<!-- #sidebar-one -->

		<ul id="sidebar-two">
			<?php if ( is_active_sidebar( 'second-widget' ) ) {
				dynamic_sidebar( 'second-widget' );
			} ?>
		</ul>
		<!-- #sidebar-two -->

	</div><!-- #first-sidebar -->

	<?php
	/** Add empty hook after first sidebar */
	do_action( 'opus_first_sidebar_after' );

}
/** End if - active check in Sidebar Area One */

/** Sanity check - do we have any active widgets in "Sidebar Area Two" */
if ( is_active_sidebar( 'third-widget' ) || is_active_sidebar( 'fourth-widget' ) ) {

	/** Add empty hook before second sidebar */
	do_action( 'opus_second_sidebar_before' ); ?>

	<div class="second-sidebar">

		<ul id="sidebar-three">
			<?php if ( is_active_sidebar( 'third-widget' ) ) {
				dynamic_sidebar( 'third-widget' );
			} ?>
		</ul>
		<!-- #sidebar-three -->

		<ul id="sidebar-four">
			<?php if ( is_active_sidebar( 'fourth-widget' ) ) {
				dynamic_sidebar( 'fourth-widget' );
			} ?>
		</ul>
		<!-- #sidebar-four -->

	</div><!-- #second-sidebar -->

	<?php
	/** Add empty hook after second sidebar */
	do_action( 'opus_second_sidebar_after' );

}
/** End if - active check in Sidebar Area Two */

/** Add empty hook after sidebars */
do_action( 'opus_sidebars_after' );