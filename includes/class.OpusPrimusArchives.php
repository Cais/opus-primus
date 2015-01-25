<?php

/**
 * Opus Primus Archives
 *
 * Site archives for categories, tags, pages, etc.
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
 * Re-order methods: action and filter calls by request order, then alphabetical
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 */
class OpusPrimusArchives {
	/**
	 * Construct
	 */
	function __construct() {
	}


	/**
	 * Opus Primus Archive Cloud
	 *
	 * Displays a cloud of links to the "post tag" and "category" taxonomies by
	 * default; standard `wp_tag_cloud` parameters can be passed to change the
	 * output.
	 *
	 * @link     http://codex.wordpress.org/Function_Reference/wp_tag_cloud
	 * @example  archive_cloud( array( 'taxonomy' => 'post_tag', 'number' => 10 ) );
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @param   string $cloud_args
	 *
	 * @uses     do_action
	 * @uses     wp_parse_args
	 * @uses     wp_tag_cloud
	 */
	function archive_cloud( $cloud_args = '' ) {
		/** Add empty hook before archive cloud */
		do_action( 'opus_archive_cloud_before' );

		/** @var $defaults - initial values to be used as parameters */
		$defaults   = array(
			'taxonomy' => array(
				'post_tag',
				'category',
			),
			'format'   => 'list',
			'order'    => 'RAND',
		);
		$cloud_args = wp_parse_args( (array) $cloud_args, $defaults );

		/** @var $cloud_classes - initialize variable to empty in case no conditions are met */
		$cloud_classes = '';

		/** Top 'number' of displayed tags set */
		if ( isset( $cloud_args['number'] ) && ( 'DESC' == $cloud_args['order'] ) ) {
			$cloud_classes .= 'top-' . $cloud_args['number'];
			$cloud_title = sprintf( __( 'The Top %1$s Tags Cloud:', 'opus-primus' ), $cloud_args['number'] );
		}
		/** End if - isset */

		/** If a cloud class has been created then make sure to add a space before so it will be properly added to the class list */
		if ( ! empty( $cloud_classes ) ) {
			$cloud_classes = ' ' . $cloud_classes;
		}
		/** End if not empty */

		/** Default title */
		if ( empty( $cloud_title ) ) {
			$cloud_title = __( 'The Cloud:', 'opus-primus' );
		}
		/** End if empty */

		if ( isset( $cloud_args['format'] ) && ( 'flat' == $cloud_args['format'] ) ) {
			$cloud_title .= '<br />';
		}
		/** End if isset */

		/**
		 * Output the cloud with a title wrapped in an element with dynamic
		 * classes.
		 */
		printf( '<ul class="archive cloud list cf%1$s">', $cloud_classes );
		echo '<li><span class="title">' . $cloud_title . '</span>';
		wp_tag_cloud( $cloud_args );
		echo '</li>';
		echo '</ul><!-- .archive.cloud.list -->';

		/** Add empty hook after archive cloud */
		do_action( 'opus_archive_cloud_after' );

	}

	/** End function archive cloud */


	/**
	 * Opus Primus Category Archive
	 *
	 * Displays all of the categories with links to their respective category
	 * archive page using `wp_list_categories` and all of its parameters.
	 *
	 * @link     http://codex.wordpress.org/Function_Reference/wp_list_categories
	 * @example  categories_archive( array( 'number' => 12 ) );
	 *
	 * @package  OpusPrimus
	 * @since    0.1
	 *
	 * @param   array|string $category_args
	 *
	 * @uses     do_action
	 * @uses     wp_list_categories
	 * @uses     wp_parse_args
	 */
	function categories_archive( $category_args = '' ) {
		/** Add empty hook before category archive */
		do_action( 'opus_category_archive_before' );

		/** @var $defaults - set the default parameters */
		$defaults      = array(
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hierarchical' => 0,
			'title_li'     => __( 'All Categories:', 'opus-primus' ),
		);
		$category_args = wp_parse_args( (array) $category_args, $defaults );

		echo '<ul class="archive category list cf">';
		wp_list_categories( $category_args );
		echo '</ul><!-- .archive.category.list -->';

		/** Add empty hook after category archive */
		do_action( 'opus_category_archive_after' );

	}
	/** End function categories archive */


} /** End Class Opus Primus Archives */