<?php
/**
 * Search Template
 *
 * Displays for search results
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
 *
 * @version     1.0.1
 * @date        February 21, 2013
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 *
 * @version     1.4
 * @date        May 17, 2015
 * Improved i18n implementation in search found results string
 */

/** Create Opus_Primus_Structures class object */
$opus_structures = Opus_Primus_Structures::create_instance();

get_header( 'search' );

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

			<?php
			/** Add before loop sidebar */
			if ( is_active_sidebar( 'before-loop' ) ) {
				dynamic_sidebar( 'before-loop' );
			}

			/** Starts the_Loop */
			if ( have_posts() ) {

				/** Create text string for output */
				$opus_search_found_pre_text = __( 'We found it!', 'opus-primus' );
				$opus_search_found_pre_text .= '<br />';
				$opus_search_found_pre_text .= __( 'It looks like you searched for ...', 'opus-primus' );

				printf(
					sprintf(
						'<h2 class="search-found-pre-text">%1$s <span class="search-query">%2$s</span></h2>',
						esc_html( apply_filters( 'opus_search_found_pre_text', $opus_search_found_pre_text ) ),
						get_search_query()
					)
				);

				esc_html_e(
					apply_filters(
						'opus_search_found_post_text',
						'<div class="opus-search-found-post-text">' . __( 'Here are the results:', 'opus-primus' ) . '</div>'
					)
				);

				while ( have_posts() ) {

					the_post();
					/** Since we're in the_Loop we need to check the post type */
					if ( 'page' === get_post_type() ) {
						?>

						<div <?php post_class(); ?>>

							<?php
							/** Create Opus_Primus_Posts class object */
							$opus_posts = Opus_Primus_Posts::create_instance();

							$opus_posts->post_byline( array( 'display_mod_author' => true ) );
							$opus_posts->post_title();
							$opus_posts->post_excerpt(); ?>

						</div><!-- post classes --> <?php } else {

						get_template_part( 'opus-primus', get_post_format() );}
				}
			} else {

				$opus_structures->no_search_results();

			}

			/** Create Opus_Primus_Navigation class object */
			$opus_navigation = Opus_Primus_Navigation::create_instance();
			$opus_navigation->posts_link();

			/** Ends the_Loop */

			/** Add after loop sidebar */
			if ( is_active_sidebar( 'after-loop' ) ) {
				dynamic_sidebar( 'after-loop' );
			} ?>

		</div>
		<!-- #the-loop -->

		<?php
		/** Add empty action after the_Loop */
		do_action( 'opus_the_loop_after' );

		get_sidebar( 'search' );

		/** Close the classes written by the layout_open call */
		echo $opus_structures->layout_close();

		/** Add empty hook at the bottom of the content */
		do_action( 'opus_content_bottom' ); ?>

	</div><!-- #content-wrapper -->

<?php
/** Add empty hook after the content */
do_action( 'opus_content_after' );

get_footer( 'search' );
