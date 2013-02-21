<?php
/**
 * Header Template
 * Default document header including primary navigation.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2013, Opus Primus
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
 * @version 1.0.1
 * @date    February 21, 13
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 */ ?>

<!DOCTYPE html>
<?php do_action( 'opus_html_before' ); ?>
<html <?php language_attributes(); ?>>
<head>
    <?php do_action( 'opus_head_top' ); ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php
    do_action( 'opus_head_bottom' );
    wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'opus_body_top' ); ?>
<div id="opus-primus"><!-- Unique theme identifier -->
    <?php
    /** Add empty hook before header */
    do_action( 'opus_header_before' );

    /** Call header template with reference to post format */
    if ( is_singular() ) {
        get_template_part( 'opus-primus-header', get_post_format() );
    } else {
        get_template_part( 'opus-primus-header' );
    } /** End if - have posts */

    /** Add empty hook after header */
    do_action( 'opus_header_after' );