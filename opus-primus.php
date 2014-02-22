<?php
/**
 * Opus Primus default loop template
 * Displays the default loop content
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
 * @internal    general usage notes for all loops can be found in this file
 *
 * @version     1.2
 * @date        April 18, 2013
 * Adjusted conditional displaying the `featured_image`
 */

/** Call the class variables */
global $opus_defaults, $opus_posts, $opus_comments, $opus_navigation, $opus_images, $opus_authors;

/** Display the post */
?>
	<div <?php post_class(); ?>>

		<?php
		/** @var $anchor - set value for use in meta_tags (post_byline default) */
		$anchor = __( 'Posted', 'opus-primus' );
		$opus_posts->post_byline( array( 'display_mod_author' => $opus_defaults->display_mod_author() ) );
		$opus_posts->post_title();

		if ( ! is_single() ) {
			$opus_comments->comments_link();
			$opus_images->featured_thumbnail();
		} else {
			$opus_images->featured_thumbnail( $size = 'full', $class = 'aligncenter' );
		}
		/** End if - not is single */

		$opus_posts->post_content();
		$opus_navigation->multiple_pages_link( array(), $preface = __( 'Pages:', 'opus-primus' ) );
		$opus_posts->meta_tags( $anchor );
		$opus_posts->post_coda();

		if ( is_single() ) {
			/**
			 * @internal using $opus_authors->post_author( $args ) works but is
			 * not as easily read and used as an example when modifying the code
			 */
			$opus_authors->post_author(
						 array(
							 'display_mod_author'   => $opus_defaults->display_mod_author(),
							 'display_author_url'   => $opus_defaults->display_author_url(),
							 'display_author_email' => $opus_defaults->display_author_email(),
							 'display_author_desc'  => $opus_defaults->display_author_desc(),
						 )
			);
		} /** End if - is single */
		?>

	</div><!-- post classes -->

<?php
$opus_comments->wrapped_comments_template();