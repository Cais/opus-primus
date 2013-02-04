README.TXT
==========
A free-form scratchpad for ideas and other notes related to the project.

* Comments Toggle JavaScript / jQuery
- see comments-toggle.js
- use with (in functions or Comments class?):
    /** Enqueue Comments Toggle JavaScript which will enqueue jQuery as a dependency */
    wp_enqueue_script( 'opus-primus-comments-toggle', OPUS_JS . 'comments-toggle.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );

* Pages Without Title Leave Blanks
- see no-title.js
    /** Enqueue Opus Primus No Title which will enqueue jQuery as a dependency - only works with default permalinks */
    wp_enqueue_script( 'opus-primus-no-title', OPUS_JS . 'no-title.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );
