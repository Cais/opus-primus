<?php
/**
 * Opus Primus default loop template
 * Displays the default loop content
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @link        http://opusprimus.com
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
 */

/** Call the Post Structure variable */
global $opus_nav, $opus_structure;

/** Display the post */
$opus_structure->opus_post_title();
$opus_structure->opus_post_meta();
$opus_structure->opus_post_content();
$opus_structure->opus_post_author();
$opus_nav->opus_link_pages();