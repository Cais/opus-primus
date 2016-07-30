<?php
/**
 * Standard Archive Loop
 *
 * This loop shows the standard posts, or any other archive without a specific
 * loop template. The default is to show the post archive.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2016, Opus Primus
 *
 * @link        http://codex.wordpress.org/Template_Hierarchy - URI reference
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
 * @version     1.2.3
 * @date        December 30, 2013
 * Added Featured Image thumbnail to standard post-format archive views
 *
 * @version     1.2.4
 * @date        May 11, 2014
 * Use `show_featured_thumbnail` method
 */

/** Create class objects */
$opus_structures = Opus_Primus_Structures::create_instance();
$opus_posts      = Opus_Primus_Posts::create_instance();
$opus_comments   = OpusPrimusComments::create_instance();
$opus_images     = Opus_Primus_Images::create_instance();
$opus_navigation = Opus_Primus_Navigation::create_instance(); ?>

<div <?php post_class(); ?>>

	<?php
	/** @var $anchor - set value for use in meta_tags (post_byline default) */
	$anchor = __( 'Posted', 'opus-primus' );
	$opus_posts->post_byline( array( 'tempus' => 'time' ) );
	$opus_posts->post_title();
	$opus_comments->comments_link();
	$opus_images->show_featured_thumbnail();
	$opus_posts->post_excerpt();
	$opus_navigation->multiple_pages_link( array(), $preface = __( 'Pages:', 'opus-primus' ) );
	$opus_posts->meta_tags( $anchor );
	$opus_posts->post_coda(); ?>

</div><!-- .post -->