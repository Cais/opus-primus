<?php
/**
 * Opus Primus Post-Format: Audio loop template
 *
 * Displays the post-format: audio loop content
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
 * @version     1.2
 * @date        April 20, 2013
 * Adjusted conditional displaying the `featured_image`
 *
 * @version     1.2.4
 * @date        May 11, 2014
 * Use `show_featured_thumbnail` method
 */

/** Create class objects */
$opus_posts      = new OpusPrimusPosts();
$opus_comments   = OpusPrimusComments::create_instance();
$opus_images     = new OpusPrimusImages();
$opus_navigation = new OpusPrimusNavigation();

/** Display the post */
?>
	<div <?php post_class(); ?>>

		<?php
		/** @var $anchor - set value for use in post_byline and meta_tags */
		$anchor = __( 'Played', 'opus-primus' );
		$opus_posts->post_byline(
			array(
				'display_mod_author' => OPUS_DISPLAY_MOD_AUTHOR,
				'anchor'             => $anchor,
				'sticky_flag'        => __( 'Listen', 'opus-primus' )
			)
		);
		$opus_posts->post_title();
		$opus_comments->comments_link();
		$opus_images->show_featured_thumbnail();
		$opus_posts->post_content();
		$opus_navigation->multiple_pages_link( array(), $preface = __( 'Pages:', 'opus-primus' ) );
		$opus_posts->meta_tags( $anchor );
		$opus_posts->post_coda();
		if ( is_single() ) {
			/** Create OpusPrimusAuthors class object */
			$opus_authors = new OpusPrimusAuthors();
			$opus_authors->post_author(
				array(
					'display_mod_author'   => OPUS_DISPLAY_MOD_AUTHOR,
					'display_author_url'   => OPUS_DISPLAY_AUTHOR_URL,
					'display_author_email' => OPUS_DISPLAY_AUTHOR_EMAIL,
					'display_author_desc'  => OPUS_DISPLAY_AUTHOR_DESCRIPTION,
				)
			);
		} /** End if - is single */
		?>

	</div><!-- post classes -->

<?php
$opus_comments->wrapped_comments_template();