<?php
/**
 * Footer Template
 *
 * Default document footer.
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012-2016, Opus Primus
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
 * Modified action hooks to more semantic naming convention:
 * `opus_<section>_<placement>`
 * Added 'opus_footer_after' action hook
 * Moved 'opus_body_bottom' action hook to immediately before closing body tag
 */

/** Add empty hook at beginning of footer */
do_action( 'opus_footer_before' );

/** Call footer template based on post format */
if ( is_singular() ) {
	get_template_part( 'opus-primus-footer', get_post_format() );
} else {
	get_template_part( 'opus-primus-footer' );
}
/** End if - is singular */

/** Add empty hook after footer */
do_action( 'opus_footer_after' );

/** Add empty hook at end of footer - same as `opus_footer_after` */
do_action( 'opus_wp_footer_before' );

/**
 * `wp_footer` is placed inside the #opus-primus element to provide a container
 * for styling content displayed in the footer by other code constructs such as
 * plugins and scripts.
 */
wp_footer(); ?>

<!-- The following tags are opened in header.php -->
</div><!-- #opus-primus -->

<?php
/** Add empty (Mallory-Everest?) hook at bottom of body */
do_action( 'opus_body_bottom' ); ?>

</body>
</html>