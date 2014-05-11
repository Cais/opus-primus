<?php
/**
 * Opus Primus Post-Format: Image Template
 * Displays the post-format: image loop
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
 */

/** Get the classes variables */
global $opus_defaults, $opus_posts, $opus_comments, $opus_navigation, $opus_authors;

/** Display the post */
?>
	<div <?php post_class(); ?>>

		<?php
		/** @var $anchor - set value for use in post_byline and meta_tags */
		$anchor = __( 'Displayed', 'opus-primus' );
		$opus_posts->post_byline(
				   array(
					   'display_mod_author' => $opus_defaults->display_mod_author(),
					   'anchor'             => $anchor,
					   'sticky_flag'        => __( 'Framed', 'opus-primus' )
				   )
		);
		$opus_posts->post_title();
		$opus_comments->comments_link();
		$opus_posts->post_content();
		$opus_navigation->multiple_pages_link( array(), $preface = __( 'Pages:', 'opus-primus' ) );
		$opus_posts->meta_tags( $anchor );
		$opus_posts->post_coda();
		if ( is_single() ) {
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