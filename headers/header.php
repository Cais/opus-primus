<?php
/**
 * Header Template
 * A generic header template to show when no other more specific post-format
 * header template is available.
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
 */
?>
<header>

    <hgroup>

        <?php
        /** Add empty hook before site title */
        do_action( 'opus_primus_before_site_title' ); ?>

        <h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

        <?php
        /**
         * Add empty hooks between the site title and description ... now we're
         * really writing Mallory-Everest code but someone might want this.
         */
        do_action( 'opus_primus_after_site_title' );
        do_action( 'opus_primus_before_site_description' ); ?>

        <h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>

        <?php
        /** Add empty hook after site description */
        do_action( 'opus_primus_after_site_description' );
        ?>

    </hgroup>

    <?php
    /** Add empty hook before primary navigation */
    do_action( 'opus_primus_before_nav' ); ?>

    <nav>
        <?php global $opus_navigation; $opus_navigation->primary_menu(); ?>
    </nav>

    <?php
    /** Add empty hook after primary navigation */
    do_action( 'opus_primus_after_nav' ); ?>

</header>