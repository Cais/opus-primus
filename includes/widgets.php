<?php
/**
 * Widgets
 * Definitions for all of the widget areas used in the theme
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2013-2014, Opus Primus
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

/**
 * Opus Primus Widgets
 * Register widget area definitions
 * - Three (3) in the "Header"
 * - One (1) above the "Content"
 * - One (1) below the "Content"
 * - Three (3) in the "Footer"
 * - Four (4) in the "Sidebar"
 *
 * @package  OpusPrimus
 * @since    0.1
 *
 * @uses     __
 * @uses     register_sidebar
 *
 * @internal Widget areas appear in the same order they are defined in the
 * WordPress Appearance > Widgets Administration Panel
 * @internal Relies on the default widget structure
 *
 * @example  'name' => sprintf( __('Sidebar %d'), $i ),
 * @example  'id' => "sidebar-$i",
 * @example  'description' => '',
 * @example  'class' => '',
 * @example  'before_widget' => '<li id="%1$s" class="widget %2$s">',
 * @example  'after_widget' => "</li>\n",
 * @example  'before_title' => '<h2 class="widgettitle">',
 * @example  'after_title' => "</h2>\n",
 *
 * @version  1.0.1
 * @date     February 14, 2013
 * Modify the widget descriptions in the First, Second, Third, and Fourth Widget
 * Areas to better explain their relative position and when to expect them to be
 * displayed.
 */
function opus_primus_widgets() {
	/**
	 * To override this function in a Child-Theme:
	 * - remove action hook (see functions.php call to `widget_init` action)
	 * - write your widget definition function
	 * - add your function to a new call on the `widget_init` action hook
	 */

	register_sidebar(
		array(
			'name'        => __( 'First Widget Area', 'opus-primus' ),
			'id'          => 'first-widget',
			'description' => __( 'This widget area is in "Sidebar Area One". If no sidebar widget areas are active, the web site will be one column. If the Third Widget Area and/or Fourth Widget Area is active in addition to this First Widget Area, the web site will display three columns with this area on the left side of the sidebar.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Second Widget Area', 'opus-primus' ),
			'id'          => 'second-widget',
			'description' => __( 'This widget area is in "Sidebar Area One". If no sidebar widget areas are active, the web site will be one column. If the Third Widget Area and/or Fourth Widget Area is active in addition to this Second Widget Area, the web site will display three columns with this area on the left side of the sidebar.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Third Widget Area', 'opus-primus' ),
			'id'          => 'third-widget',
			'description' => __( 'This widget area is in "Sidebar Area Two". If no sidebar widget areas are active, the web site will be one column. If the First Widget Area and/or Second Widget Area is active in addition to this Third Widget Area, the web site will display three columns with this area on the right side of the sidebar.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Fourth Widget Area', 'opus-primus' ),
			'id'          => 'fourth-widget',
			'description' => __( 'This widget area is in "Sidebar Area Two". If no sidebar widget areas are active, the web site will be one column. If the First Widget Area and/or Second Widget Area is active in addition to this Fourth Widget Area, the web site will display three columns with this area on the right side of the sidebar.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Before Loop Widget Area', 'opus-primus' ),
			'id'          => 'before-loop',
			'description' => __( 'This widget area displays just before the_Loop begins on all templates (index, archive, author, image, page, search, and single).', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'After Loop Widget Area', 'opus-primus' ),
			'id'          => 'after-loop',
			'description' => __( 'This widget area displays just after the_Loop ends on all templates (index, archive, author, image, page, search, and single).', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'First Header Widget Area', 'opus-primus' ),
			'id'          => 'header-left',
			'description' => __( 'This widget area appears in the header above the menu on the left side of the theme.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Second Header Widget Area', 'opus-primus' ),
			'id'          => 'header-middle',
			'description' => __( 'This widget area appears in the header above the menu in the middle of the theme.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Third Header Widget Area', 'opus-primus' ),
			'id'          => 'header-right',
			'description' => __( 'This widget area appears in the header above the menu on the right side of the theme.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'First Footer Widget Area', 'opus-primus' ),
			'id'          => 'footer-left',
			'description' => __( 'This widget area appears in the footer on the left side of the theme.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Second Footer Widget Area', 'opus-primus' ),
			'id'          => 'footer-middle',
			'description' => __( 'This widget area appears in the footer in the middle of the theme.', 'opus-primus' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Third Footer Widget Area', 'opus-primus' ),
			'id'          => 'footer-right',
			'description' => __( 'This widget area appears in the footer on the right side of the theme.', 'opus-primus' ),
		)
	);

}

/** End function - opus primus widgets */

add_action( 'widgets_init', 'opus_primus_widgets' );