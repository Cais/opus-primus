<?php
/**
 * Sidebar Header Template
 * Located between the site description and the site top menu
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
 */

/** Add empty hook before Sidebar-Header */
do_action( 'opus_primus_before_sidebar_header' );

/** Only resolve public facing space if there is an active header widget area. */
if ( is_active_sidebar( 'header-middle' ) || is_active_sidebar( 'header-left' ) || is_active_sidebar( 'header-right' ) ) : ?>

    <div id="header-sidebar">
        <div class="header-widget-area three-columns-header">
            <div class="column-middle">
                <div class="column-left">

                    <ul id="header-sidebar-two">
                        <?php
                        if ( is_active_sidebar( 'header-middle' ) ) {
                            dynamic_sidebar( 'header-middle' );
                        } ?>
                    </ul><!-- #header-sidebar-two -->

                    <ul id="header-sidebar-one">
                        <?php
                        if ( is_active_sidebar( 'header-left' ) ) {
                            dynamic_sidebar( 'header-left' );
                        } ?>
                    </ul><!-- #header-sidebar-one -->

                    <ul id="header-sidebar-three">
                        <?php
                        if ( is_active_sidebar( 'header-right' ) ) {
                            dynamic_sidebar( 'header-right' );
                        } ?>
                    </ul><!-- #header-sidebar-three -->

                </div><!-- .column-left -->
            </div><!-- .column-middle -->
        </div><!-- .header-widget-area.three-columns-header -->
    </div><!-- #header-sidebar -->

<?php
endif;

/** Add empty hook after Sidebar-Header */
do_action( 'opus_primus_after_sidebar_header' );