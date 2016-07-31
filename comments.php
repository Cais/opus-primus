<?php
/**
 * Comments Template
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
 * @version     1.1
 * @date        March 18, 2013
 * Added additional list wrapper around each comment type
 * Added Comment Tabs for each type (Comment, Pingback, and Trackback)
 * Fixed comments (only) count output
 *
 * @version     1.2
 * @date        July 21, 2013
 * Added conditional check if not post password required when displaying
 * Changed comments count to be display via a Comments class method
 * Moved `comments only tab`, `pingbacks only tab` and `trackbacks only tab`
 * functionality into Comments class methods
 * Moved `comments only panel`, `pingbacks only panel` and
 * `trackbacks only panel` functionality into Comments class methods
 * Moved global variables call inside conditional statement as they are not
 * needed if we do not have comments.
 */

/** Create Opus_Primus_Comments class object */
$opus_comments = Opus_Primus_Comments::create_instance(); ?>

<!-- Show the comments -->
<!-- Inspired by http://digwp.com/2010/02/separate-comments-pingbacks-trackbacks/ -->
<div class="comments-wrapper">
	<?php if ( ! post_password_required() && have_comments() ) { ?>

		<h2 id="all-comments">
			<?php $opus_comments->show_all_comments_count(); ?>
		</h2><!-- #all-comments -->

		<div id="comment-tabs">

			<ul id="comment-tabs-header">

				<?php
				$opus_comments->comments_only_tab();
				$opus_comments->pingbacks_only_tab();
				$opus_comments->trackbacks_only_tab(); ?>

			</ul>

			<?php
			$opus_comments->comments_only_panel();
			$opus_comments->pingbacks_only_panel();
			$opus_comments->trackbacks_only_panel(); ?>

		</div><!-- #comment-tabs -->

		<?php
	}
	/** End if - have comments */

	comment_form(); ?>

</div><!-- .comments-wrapper -->