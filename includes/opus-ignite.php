<?php
/**
 * Opus Ignite
 * Initialization file for the theme
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @link        http://opusprimus.com
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
 */

/** Set CONSTANTS */
define( 'OPUS_INCLUDES', get_template_directory() . '/includes/' );

/** Add Post Layout */
require_once( OPUS_INCLUDES . 'class.OpusPrimusPostLayout.php' );