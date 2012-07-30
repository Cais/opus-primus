<?php
/**
 * Comments Template
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
 * @todo Review general commentary look and feel ... make more unique to OP
 */

/** Add Comments Class */
require_once( OPUS_INC . 'class.OpusPrimusComments.php' );

/** Apply filters and actions */
add_filter( 'comment_class', 'OpusPrimusComments::comment_authors' );
add_action( 'comment_form_before', 'OpusPrimusComments::form_before' );
add_action( 'comment_form_comments_closed', 'OpusPrimusComments::form_comments_closed' ); ?>

<!-- Show the comments -->
<div class="comments">
<?php if ( have_comments() ) : ?>
    <div class="comments-number"><?php comments_number(); ?></div>
    <ul class="comments-list">
        <?php wp_list_comments(); ?>
    </ul>
    <?php
    global $opus_nav;
    $opus_nav->comments_navigation();
endif;
comment_form(); ?>
</div><!-- .comments -->