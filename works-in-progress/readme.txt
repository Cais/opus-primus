README.TXT
==========
A free-form scratchpad for ideas and other notes related to the project. Feel
free to review / criticize / recommend ... or even laugh out loud at; but, if
you find a good way to implement one of these ideas by all means make a pull
request at GitHub or send me an email with details and I will be happy to have
a look at it. Credit will be given for code used.

* Comments Toggle JavaScript / jQuery
- see comments-toggle.js
- use with (in functions or Comments class?):
    /** Enqueue Comments Toggle JavaScript which will enqueue jQuery as a dependency */
    wp_enqueue_script( 'opus-primus-comments-toggle', OPUS_JS . 'comments-toggle.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), 'true' );