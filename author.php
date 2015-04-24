<?php
/**
 * Author Template
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
 * @version     1.0.1
 * @date        February 21, 2013
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 */

/** Create OpusPrimusStructures class object */
$opus_structures = OpusPrimusStructures::create_instance();

/** @var $current_author - current author data an as object */
$current_author = ( get_query_var( 'author_name ' ) ) ? get_user_by( 'id', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
/** @var $current_author_id - the author ID */
$current_author_id = $current_author->ID;

get_header( 'author' );

/** Add empty hook before content */
do_action( 'opus_content_before' ); ?>

	<div class="content-wrapper cf">

		<?php
		/** Add empty hook at top of the content */
		do_action( 'opus_content_top' );

		/** Open the necessary layout CSS classes */
		echo $opus_structures->layout_open();

		/** Add empty action before the_Loop */
		do_action( 'opus_the_loop_before' ); ?>

		<div class="the-loop">

			<!-- The Author Details block - inserted above the content -->
			<div class="opus-author-header">
				<?php
				/** Create OpusPrimusAuthors class object */
				$opus_authors = OpusPrimusAuthors::create_instance();
				$opus_authors->author_details( $current_author_id, true, true, true );
				$opus_authors->share_the_author_wealth( true ); ?>
			</div>
			<!-- opus-author-header -->

			<?php
			/** Add before loop sidebar */
			if ( is_active_sidebar( 'before-loop' ) ) {
				dynamic_sidebar( 'before-loop' );
			}

			/** the_Loop structure in its most basic form */
			$opus_structures->the_loop();

			/** Add after loop sidebar */
			if ( is_active_sidebar( 'after-loop' ) ) {
				dynamic_sidebar( 'after-loop' );
			} ?>

		</div>
		<!-- #the-loop -->

		<?php
		/** Add empty action after the_Loop */
		do_action( 'opus_the_loop_after' );

		get_sidebar( 'author' );

		/** Close the classes written by the layout_open call */
		echo $opus_structures->layout_close();

		/** Add empty hook at the bottom of the content */
		do_action( 'opus_content_bottom' ); ?>

	</div><!-- #content-wrapper -->

<?php
/** Add empty hook after the content */
do_action( 'opus_content_after' );

get_footer( 'author' );