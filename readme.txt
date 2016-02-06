=== Opus Primus readme.txt ===

== Contents ==
* Copyright
* Changelog
* Licenses
* Screenshots
* Basic FAQ
* Notes
* Review Tickets

== Copyright ==
Copyright (c) 2012-2016, Opus Primus

This file is part of Opus Primus.

Opus Primus is free software; you can redistribute it and/or modify it under the
terms of the GNU General Public License version 2, as published by the Free
Software Foundation.

You may NOT assume that you can use any other version of the GPL.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to:

    Free Software Foundation, Inc.
    51 Franklin St, Fifth Floor
    Boston, MA  02110-1301  USA

The license for this software can also likely be found here:
http://www.gnu.org/licenses/gpl-2.0.html

Note: All Opus Primus file Copyright years start with the first year of use and
are amended with subsequent years based on theme publication regardless of any
change or modification to the actual file.

== Changelog ==
Recent changelog as of February 6, 2016
= Version 1.4.1 =
* Released ...

= Code =
* Updated copyright year to 2016
* Minor code reformatting

= Miscellaneous =
* Re-arranged changelog entries in `readme.txt` and `changelog.txt` files

/** ------------------------------------------------------------------------- */
= Version 1.4 =
* Released June 2015

= Code =
* Added `widgets` to the HTML5 theme supported items
* Added `number_format_i18n` to better accommodate locale based values
* Added two classes for use in rendering the comments link text displayed ... or not
* Added `Share the Author Wealth` method, not implemented as a display element, yet
* Added context (`_x`) for complete byline phrase translation string
* Change all classes to a singleton style
* Ensure `$pagination` has been initialized in `OpusPrimusNavigation::pagination` method
* Improved i18n implementation in search found results string
* Moved the `support_comment` method back into the `OpusPrimusStructures` class
* Moved the `before_comment_form` and `comments_form_closed` methods back into the `OpusPrimusComments` class
* Refactored `OpusPrimusComments::comments_link` to use the WordPress core more effectively
* Removed `$screen` parameter as not necessary in Taglines Stanza
* Renamed file `class.OpusPrimusHeaders.php` to `class.OpusPrimusHeader.php` for consistency
* Removed "TagLines" Stanza and made available as separate plugin - see https://github.com/Cais/opus-primus-taglines-stanza
* Removed "THA" Stanza and made available as separate plugin - see https://github.com/Cais/opus-primus-tha-stanza

= CSS =
* Added class definition to hide comment link text when comments are closed and there are no comments
* Adjusted CSS to not reference `li` elements in default widget styles
* Adjust breadcrumb font-size (reduced by 1px) to correct wrapping effect

= Miscellaneous =
* i18n: Added base `opus-primus.pot` file as well as English (Canadian) files
* i18n: `null` does not need to be translated
* i18n: Symbolic characters do not need to be translated
* Added `opus_authors_list` filter hook
* Continue removal of extraneous end of structure comments ...

/** ------------------------------------------------------------------------- */
= Version 1.3.4 =
* Released March 2015

= Code =
* Used a more specific element identifier for the SlickNav `prependTo` parameter

= Miscellaneous =
* Continue removal of extraneous end of structure comments ...

/** ------------------------------------------------------------------------- */
= Version 1.3.3 =
* Released March 2015
* Added sanity checks to ensure there is actually an image in use when returning the featured image view.

/** ------------------------------------------------------------------------- */
= Version 1.3.2 =
* Released March 2015
* Added support for the `title` tag via `add_theme_support` function

/** ------------------------------------------------------------------------- */
= Version 1.3.1 =
* Released March 2015

= Code =
* Added `get_the_posts_pagination` for navigation between pages of posts
* Added `hide_category_widget_list_items` method and related hook
* Added some escaping sanitization and linked Featured Image to post via the post ID
* Changed method to return the Featured Thumbnail versus outputting it
* Changed from using `get_the_time` to `date_i18n` for `OpusPrimusImages::exif_timestamp` method
* Extracted code from `featured_thumbnail` method to create `featured_thumbnail_single_view` method
* Improved look of navigation links in `OpusPrimusNavigation::multiple_pages_link` method

= CSS =
* Added `=== Screen Reader Text ===` section
* Added `h5.comments-link` definition to provide a better aesthetic location
* Added styling to navigation for moving within a single post's pages
* Incorporated WordPress recommended styles for `.screen-reader-text` class

= Miscellaneous =
* Added `opus_featured_thumbnail_single_view_portrait` filter hook and updated `hooks-filters.txt`
* Begin removal of extraneous end of structure comments ...
* Inline documentation clean-up and re-organization
* Updated `hooks-filters.txt` file

/** ------------------------------------------------------------------------- */
== Version 1.3 ==
* Released November 2014

= Code =
* Added `post-title-link` wrapper class to better manage Post Title output
* Added WordPress HTML5 markup support for search form, comment form, comment list, and caption
* Added sanity checks to ensure constants are not already defined
* Added `OpusPrimusRouter` class to replace path and URL CONSTANTS
* Added Child-Theme "slug" for easier customizations
* Added empty hooks before and after showing the breadcrumbs
* Added OpusPrimusComments class methods to `functions.php` to work-around duplicate output issue
* Added checks for Child-Theme and relevant references to `opus_primus_support_comment`
* Better code organization to only load classes when needed
* Changed post breadcrumb link to the WordPress shortlink
* Create `/lib/` folder to store bundled libraries and ancillary files
* Enqueue JavaScripts and CSS for SlickNav JavaScript plugin integration to handle mobile menus
* Extracted the Opus Primus PullQuotes Stanza (see https://github.com/Cais/opus-primus-pullquotes)
* Moved `support_comment` method to `functions.php` to eliminate duplicate output
* Replaced the majority of `require_once` calls with `locate_template` calls
* Replaced `global` variable calls with `new` class instances
* Update to use `preg_match_all` in OpusPrimusGallery featured and secondary id methods

= CSS =
* Added new typography styles for better reading
* Added styles for the "BNS Login" plugin
* Added `clear: both` to `footer`
* Added `width: auto;` for `th` and `td` elements
* Added `#header-widgets` to the "Clearance" section of `opus-primus.css`
* Added minor `attachment` related styles
* Added better search form aesthetics in the sidebar
* Change default `ul` list-style property to `none inside`
* Hide the post/page breadcrumbs in mobile displays
* Hide "Search" button for search form
* Removed duplicate definitions from media queries stylesheet
* Removed unused `div#top-navigation-menu` definition
* Removed unused `nav div.nav ul li` definition
* Updated `editor-style.css` to match new typography of theme
* Updated galleries styles to use HTML5 markup
* Updated font-size of excerpt more link symbol to 35px from 200%

= JavaScript =
* Integrated "SlickNav" (Created by Josh Cope - @computerwolf) for mobile menu support
* Integrated "FitVids" built by Chris Coyier (http://chriscoyier.net/) and Paravel (http://paravelinc.com/)

= Miscellaneous
* Added Contact Form 7 compatibility
* Added BNS Login compatibility to use `dashicons` display
* Added Gravity Forms compatibility (for reCaptcha form)
* Added to `readme.txt` FAQ "I just updated to version 1.3, what could be causing these child-theme errors?"
* Removed `works-in-progress` folder from theme
* Updated `readme.txt` to note the use and license of SlickNav by Josh Cope
* Updated `readme.txt` to note the use and license of FitVids by Chris Coyier and Paravel
* Updated `readme.txt` to remove FAQ item related to blank menu items; resolved in WordPress core trac ticket #23254
* Updated `style.css` description to emphasize the addition of the SlickNav and FitVids libraries
* Updated `screenshot.png` to better reflect latest release
* Updated `hooks-actions.txt` with new additions

/** ------------------------------------------------------------------------- */

== Licenses ==
All items are licensed under the GNU General Public License v2; or, as the case
may be, individually noted below.

* Normalize.css is a project by Nicolas Gallagher and Jonathan Neal. A minimized
version is used. Licensed as Public Domain
- for more information see http://necolas.github.com/normalize.css/

* Font: Merienda One
Copyright (c) 2011, Eduardo Tunni (http://www.tipo.net.ar), with Reserved Font Name "Merienda"
This Font Software is licensed under the SIL Open Font License, Version 1.1.
This license is available with a FAQ at: http://scripts.sil.org/OFL

* Font: Underwood Champion
Copyright (c) 2009, Vic Fieger (http://www.vicfieger.com/)
The Vic Fieger fonts are freeware, to be downloaded and used by anyone who wants them for free.
This license can also be found at this permalink: http://www.fontsquirrel.com/license/Underwood-Champion

* Theme Hook Alliance
Licensed as GNU General Public License, v2 (or newer)
The details of the copyright and license of this work may be found internal to
the relevant files found under ..\stanzas\tha\ or at this website: https://github.com/zamoose/themehookalliance

* SlickNav - Responsive Mobile Menu jQuery Plugin - Version 1.0.1
Copyright (c) 2014, Josh Cope (http://slicknav.com)
Opus Primus uses an adaptation of the plugin which is under a MIT License
The details of the license can be found under ../js/SlickNav/MIT-LICENSE.txt
Only the relevant files have been included, a complete download can be found at https://github.com/ComputerWolf/SlickNav

* FitVids - built by Chris Coyier and Paravel - Version 1.1
Copyright (c) 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
Released under the WTFPL license - http://sam.zoy.org/wtfpl/
Only the plugin file has been included, the complete project can be found at https://github.com/davatron5000/FitVids.js

This above may not be construed as overriding any item with a previously written
and applied license, stated or not, which will take precedence over anything
written here.

== Screenshots ==

== Basic FAQ ==
Q: Where did the Stanzas go?
Although the Stanzas were meant as examples how to extend Opus Primus they were
too close to "plugin territory" to remain as part of the theme proper.

Pleas see the follow links for future references for the Stanzas:
* "TagLines" Stanza: https://github.com/Cais/opus-primus-taglines-stanza

Q: I just updated to version 1.3, what could be causing these child-theme errors?
With version 1.3 of Opus Primus the calls to the classes were changed from using
`require_once` to `locate_template`. This then followed files being updated from
calling the class global variable to creating a "new" class instance as needed.
This is expected to provide better child-theme compatibility going forward and
only be a one-time correction for existing child-themes.

Q: What is the difference between how the "Featured Image" is used on a post and
how it is used on a page?
The "Featured Image" on a page is set to ideally be used as a "banner" on pages;
and, to add emphasis for posts when they are viewed as part of a list, such as
the index view or in archives.

Q: How do the breadcrumb trails work?
There are two different breadcrumb trails used in Opus Primus. One type is used
on pages and shows the page hierarchy from the highest level to the lowest. The
second trail is used on single views of posts and shows the first category and
Post-Format of the post, both linked to their respective archive.

Q: Where are the menu locations, and how are they used?
There are three menu locations defined in Opus Primus.
* The Primary Menu, located at the top of the page above the main content area.
* The Secondary Menu, no location is set by default; the menu has been pre-
defined for uses as the case may be, for example, page templates or Child-Themes
* The Search Results Menu, located at the bottom of the content area when there
are no search results returned, especially in the case of a "404" error be sent.

Q: Is Opus Primus designed to be responsive to multiple screen sizes?
In a word, no. Although the theme does include some minimal CSS specifically
geared towards being responsive to multiple screen sizes the ideal method we
recommend at this time is to take advantage of one of the many quality plugins
available from the WordPress Extend Plugins repository to handle these requests.
Please note, we intend to continue in our efforts to provide an inclusive method
of managing these requests in future versions.

Q: How do I modify an existing function from one of the classes?
Most WordPress functions included with the theme will have their own filter,
otherwise it would be recommended to extend the class and overload the theme
function you are trying to modify.

Q: How does Opus Primus automatically handle multiple column layouts?
Through some CSS trickery and code logic Opus Primus will display by default
one, two, or three columns depending on which sidebar widget areas are active.
There are four(4) widget areas built into two sidebar areas.

The following will show how, if active, they affect the layout:
- Full Page (one-column): no active sidebar widget areas
- Two-Column: widget areas active in only one sidebar area
- Three-Column: at least one widget area active in each sidebar area

Q: What happened to the LESS components of the theme?
The LESS components of the theme were effectively removed at version 1.2 as a
means to improve load time. The styles that were generated by the LESS script
and related file were compiled and merged into the main theme stylesheet.

== Notes ==
1. $content_width is set based on how many columns being used and the common
display size of 1024px * 768px.

This being the case, the following widths will be used:
- one-column: 990px
- two-column: 700px
- three-column: 450px

2. Default Menu depth levels may be of concern in some cases. As it stands, the
default menus are not restricted to any specific depth except the Search Results
Menu which is restricted to a single level only when a custom menu is not used.

3. Future revisions of the 'theme-version-guidelines.txt' file may not
necessarily be recorded in the changelog. The "Theme Version Guidelines" page
found at http://opusprimus.com/under-the-page/theme-version-guidelines/ will
be considered the most current at all times. The version of the guidelines
included with the theme will simply be a copy of the noted page.

== Review Tickets ==
* http://themes.trac.wordpress.org/ticket/11106 - Version 1.0   - February 2013
* http://themes.trac.wordpress.org/ticket/11325 - Version 1.0.1 - February 2013
* http://themes.trac.wordpress.org/ticket/11367 - Version 1.0.2 - February 2013
* http://themes.trac.wordpress.org/ticket/11386 - Version 1.0.3 - February 2013
* http://themes.trac.wordpress.org/ticket/11417 - Version 1.0.4 - March 2013
* http://themes.trac.wordpress.org/ticket/11738 - Version 1.1   - March 2013
* http://themes.trac.wordpress.org/ticket/11803 - Version 1.1.1 - March 2013
* http://themes.trac.wordpress.org/ticket/13740 - Version 1.2   - August 2013
* http://themes.trac.wordpress.org/ticket/13740 - Version 1.2.1 - August 2013
* http://themes.trac.wordpress.org/ticket/15017 - Version 1.2.2 - October 2013
* https://themes.trac.wordpress.org/ticket/16874 - Version 1.2.3 - February 2014
* https://themes.trac.wordpress.org/ticket/18889 - Version 1.2.4 - May 2014
* https://themes.trac.wordpress.org/ticket/19955 - Version 1.2.5 - July 2014
* https://themes.trac.wordpress.org/ticket/21772 - Version 1.3 - November 2014
* https://themes.trac.wordpress.org/ticket/23510 - Version 1.3.3 - March 2015
* https://themes.trac.wordpress.org/ticket/23681 - Version 1.3.4 - March 2015
* https://themes.trac.wordpress.org/ticket/25523 - Version 1.4 - June 2015