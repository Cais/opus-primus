<?php
/**
 * Sidebar Template
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
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
 * @todo Remove / comment out test code
 * @todo Review potential of additional widget area(s)
 */ ?>

<div id="first-sidebar">

    <ul id="sidebar-one">
        <?php
        if ( is_active_sidebar( 'first-widget' ) ) :
            dynamic_sidebar( 'first-widget' );
        else :
            echo 'Test: First Widget Area<br />';
        endif; ?>
    </ul><!-- #sidebar-one -->

    <ul id="sidebar-two">
        <?php
        if ( is_active_sidebar( 'second-widget' ) ) :
            dynamic_sidebar( 'second-widget' );
        else :
            echo 'Test: Second Widget Area<br />';
        endif; ?>
    </ul><!-- .sidebar-two -->

</div><!-- #first-sidebar -->

<div id="second-sidebar">

    <ul id="sidebar-three">
        <?php
        if ( is_active_sidebar( 'third-widget' ) ) :
            dynamic_sidebar( 'third-widget' );
        else :
            echo 'Test: Third Widget Area<br />';
        endif; ?>
    </ul><!-- #sidebar-three -->

    <ul id="sidebar-four">
        <?php
        if ( is_active_sidebar( 'fourth-widget' ) ) :
            dynamic_sidebar( 'fourth-widget' );
        else :
            echo 'Test: Fourth Widget Area<br />';
        endif; ?>
    </ul><!-- .sidebar-four -->

</div><!-- #second-sidebar -->