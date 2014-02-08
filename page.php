<?php
/**
 * Page Template
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2014, Opus Primus
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
 *
 * @version     1.2
 * @date        July 24, 2013
 * Added conditional for showing the page byline details
 */

/** Call the class variables */
global $opus_structures, $opus_posts, $opus_defaults, $opus_images, $opus_authors;
get_header( 'page' );

/** Add empty hook before content */
do_action( 'opus_content_before' ); ?>

	<div class="content-wrapper cf">

		<?php
		/** Add empty hook at top of the content */
		do_action( 'opus_content_top' );

		/** Open the necessary layout CSS classes */
		echo $opus_structures->layout_open();

		/** Add empty hook before the_Loop */
		do_action( 'opus_the_loop_before' ); ?>

		<div class="the-loop">

			<?php
			/** Add before loop sidebar */
			if ( is_active_sidebar( 'before-loop' ) ) {
				dynamic_sidebar( 'before-loop' );
			}

			/** the_Loop - Starts */
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post(); ?>

					<div <?php post_class(); ?>>

						<?php
						$opus_posts->post_title();
						$opus_images->featured_thumbnail( $size = 'full', $class = 'aligncenter' );
						$opus_posts->post_content();

						/** Show page byline details */
						if ( $opus_defaults->display_page_byline() ) {
							$opus_posts->post_byline( array( 'display_mod_author' => true ) );
						} else {
							$opus_posts->post_byline(
									   array(
										   'display_mod_author' => true,
										   'echo'               => false
									   )
							);
						}
						/** End if - show page byline */

						$opus_authors->post_author(
									 array(
										 'display_mod_author' => true,
										 'display_author_url' => true,
										 'display_author_email' => true,
										 'display_author_desc' => true,
									 )
						); ?>

					</div><!-- post classes -->

				<?php
				}
				/** End while - have posts */
			} else {
				$opus_structures->no_search_results();
			}
			/** End if - have posts */
			/** the_Loop - Ends */

			/** Add after loop sidebar */
			if ( is_active_sidebar( 'after-loop' ) ) {
				dynamic_sidebar( 'after-loop' );
			}

			/** Start comments section */
			comments_template( '/comments.php', true ); ?>

		</div>
		<!-- #the-loop -->

		<?php
		/** Add empty hook after the_loop */
		do_action( 'opus_the_loop_after' );

		get_sidebar( 'page' );

		/** Close the classes written by the layout_open call */
		echo $opus_structures->layout_close();

		/** Add empty hook at the bottom of the content */
		do_action( 'opus_content_bottom' ); ?>

	</div><!-- #content-wrapper -->

<?php
/** Add empty hook after the content */
do_action( 'opus_content_after' );

get_footer( 'page' );