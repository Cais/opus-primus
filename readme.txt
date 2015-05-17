=== Opus Primus readme.txt ===
* Last revised April 28, 2015

== Contents ==
* Copyright
* Licenses
* Screenshots
* Basic FAQ
* Notes
* Changelog
* Review Tickets

== Copyright ==
Copyright (c) 2012-2015, Opus Primus

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
Q: I just updated to version 1.3, what could be causing these child-theme errors?
With version 1.3 of Opus Primus the calls to the classes were changed from using
`require_once` to `locate_template`. This then followed files being updated from
calling the class global variable to creating a "new" class instance as needed.
This is expected to provide better child-theme compatibility going forward and
only be a one-time correction for existing child-themes.

Q: What are Stanzas?
Stanzas are meant to add additional functionality specifically to Opus Primus by
either using specific Opus Primus assets, such as a particular font face; or, by
hooking into specific action and/or filter hooks only found in Opus Primus.

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

== Changelog ==
=== Opus Primus changelog.txt ===
Last revised April 18, 2015
Please note, the Opus Primus copyright can be found at the end of this file.

= Version 1.4 =
* Released ...

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

= CSS =
* Added class definition to hide comment link text when comments are closed and there are no comments
* Adjusted CSS to not reference `li` elements in default widget styles
* Adjust breadcrumb font-size (reduced by 1px) to correct wrapping effect

= Miscellaneous =
* i18n: Added base `.po` file as well as English (Canadian) `.pomo` files
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
== Version 1.2.5 ==
* Released July 2014

= Code =
* Added new method `OpusPrimusNavigation::pagination` for moving between pages of posts
* Added new method `OpusPrimusNavigation::pagination_wrapped` to provide actions hooks before and after the `pagination` method
* Added `antispambot` email protection to author biography email addresses
* Added sanity checks to ensure widgets are active before rendering sidebars
* Added `opus_primus_defaults.php` to replace `$opus_defaults` class
* Added `opus-primus-ignite.php` to reduce clutter in `functions.php`
* Added `opus_image_link_navigation_output` filter hook to provide access to navigation output
* Added `opus_tagline` to default hidden screen options array
* Adjusted the `OpusPrimusStructures::the_loop` and `OpusPrimusStructures::the_loop_archives` to use the `pagination_wrapped` method
* Changed navigation method from `posts_link` to `pagination`
* Changed single view first year of copyright to published year of post/page in `OpusPrimusStructures::copyright` method
* Deprecated `OpusPrimusDefaults` class (file may be removed in a future release)
* Enqueue custom stylesheet in an update safe location `/wp-content/opus-primus-customs/`
* Enqueue custom JavaScript in an update safe location `/wp-content/opus-primus-customs/`
* Refactored all defaults using true/false to use filtered define statements
* Refactored `OpusPrimusTaglines::tagline_create_boxes` to clarify the parameter usage
* Remove conditional customization enqueue using internal theme folder
* Renamed `opus-ignite.php` to `opus-primus-ignite.php` and moved to theme root
* Renamed `OpusPrimusNavigation::image_nav` to `OpusPrimusNavigation::image_link_navigation`
* Replaced `OpusPrimusStructures::replace_spaces` with `sanitize_html_class`
* Set Customization path and URL CONSTANTS

= CSS =
* Added `Navigation` section and `Pagination Method` sub-section
* Complete refactoring of the `@media` query styles for better responsiveness
* Corrected `select` element to use "max-width" rather than "width"
* Fixed white space on right side of iPhone displays
* Minor adjustments to `img` tag related items
* Monster be gone!? - addressed special case many level menu in sidebar

= Miscellaneous =
* Updated `hooks-filter.txt` documentation to note eight (8) new filters
* Updated `hooks-actions.txt` documentation to note two (2) new actions
* Updated `screenshot.png` to show a bit more of the theme display

/** ------------------------------------------------------------------------- */
== Version 1.2.4 ==
* Released May 2014

= Code =
* Added sanity check to only display comments_link when not in single view or in an archive view
* Added Featured Image Thumbnails to post-format single and archive view templates (except Post-Formats: Image and Gallery)
* Added `opus_primus_theme_version()` call as an accessible text string
* Added new default `number_of_secondary_images` method under Gallery parameters
* Bring the Featured Image Thumbnail back into the index view ... can you say "waffle"?
* Change `$output = null` to `$output = ''` in `OpusPrimusPosts::sticky_flag` method
* Corrected typo in `'opus_links_pages_after'` hook
* Corrected modified date/time output to account for scheduled posts being modified earlier than they are posted
* Refactored conditional comments and featured thumbnail checks into the `comments_link` and `show_featured_thumbnail` methods
* Removed `extract` function, escaped attributes, and refactored conditional checks in PullQuotes Stanza
* Use `opus_primus_theme_version` in place of `wp_get_theme` calls
* Use transients to improve performance impact of the `OpusPrimusStructures::copyright` method

= CSS =
* Added Format-Aside Dashicons to Post-Format: Aside posts
* Added Flag Dashicons to Sticky Posts
* Changed Password Protected Dashicons to use the Lock
* Separated the Tagline output class into two different classes
* Updated normalize.css to 3.0.1 (copy and pasted from git.io/normalize)

= Miscellaneous =
* Added filter `opus_primus_theme_version_text`
* Change text domain to match theme slug
* Updated `hooks-actions.txt`
* Updated `hooks-filters.txt` (corrected reference to `opus_first_author_details_text`)
* Updated Opus Primus PullQuotes `readme.txt`

/** ------------------------------------------------------------------------- */
== Version 1.2.3 ==
* Released February 2014

= Code =
* Added more tests
* Added Featured Image thumbnail to standard post-format archive views
* Moved `featured_image` wrapper into OpusPrimusGallery::featured_image method
* Moved `secondary_images` wrapper into OpusPrimusGallery::secondary_images method
* Moved the ellipsis out of the read more link
* Refactored `$output` to use `button` class versus the button element in meta byline flags
* Removed unused parameter `$more` from `OpusPrimusPosts::excerpt_more_link` method
* Removed `$sep_location` parameter as it was not used in `browser_title` method
* Removed Featured Image thumbnail from index view
* Renamed `OpusPrimusDefaults` methods from `show_*` to `display_*`
* Set `display_page_byline` to true as theme author aesthetic choice

= CSS =
* Added post coda post format classes
* Added `dashicons` dependency to main `Opus-Primus` stylesheet
* Added `button` class to replace the button element styles
* Change to only append to the `cite` tag when it is inside the `blockquote` tag
* Center align Calendar Day table header cells
* Fixed really long Post Titles and Words not wrapping as expected
* General clean-up and removal of excess/over-writing properties
* Prepended Post Byline with matching Post-Format dashicons
* Re-Adjust `ul.nav-menu` and `.nav-menu` to `z-index: 3` for main menu
* Reduced the citation font-size for better aesthetics

= JavaScript =
* Re-format code structures
* Removed `table-stripe` class from specific Calendar elements

= Miscellaneous =
* Updated tags used in `style.css` header block to include responsive-layout and fluid-layout
* Updated `readme.txt` to note existence and location of `changelog.txt`
* Updated `readme.txt` copyright notice to clarify copyright years used by individual files.
* Updated Required WordPress version to 3.8 for `dashicons` dependency

/** ------------------------------------------------------------------------- */
== Version 1.2.2 ==
* Released October 2013

= Code =
* Added conditional test rather than print both breadcrumbs (one empty)
* Additional i18n code corrections and enhancements
* Corrected i18n code for EXIF data
* Extracted $post_title management from `post_breadcrumb` method into the `breadcrumb_post_title` method
* Fixed issue with Gallery Post-Format being used when the `gallery` shortcode is not used.
* Fixed undefined offset when there is no image found in post
* Reformatted to be closer to (modified) WordPress Coding Standards - see https://gist.github.com/Cais/8023722

= CSS =
* Reduced all menu related elements with `z-index` property to a value of 1
* Removed `z-index` property from breadcrumb related elements
* Set the breadcrumbs background color to `#ffffff` (white)

= Miscellaneous
* Add documentation to the `first_linked_image` function
* Removed `table-stripe` class from Post-Format: Image tables
* Tested up to WordPress version 3.7

/** ------------------------------------------------------------------------- */
== Version 1.2.1 ==
* Released August 2013
* Removed `translation-ready` tag

/** ------------------------------------------------------------------------- */
== Version 1.2 ==
* Released August 2013

= Code =
* Added display of featured image centered at full size in single standard post format view
* Added full `featured_image` method call to single view of post formats audio, chat, quote, and status
* Added `get_author_description` method in Authors class
* Added filtered `comment_form_required_field_glyph` method in Comments class
* Added many new filters - see http://opusprimus.com/under-the-page/hooks-filters/ or `hooks-filters.txt` for a current list
* Added sanity conditional check to eliminate potential duplicate body classes
* Added `is_single` conditional test before enqueue of Comment Tabs script
* Added post to post navigation in single view
* Added conditional check if not post password required when displaying comments
* Added conditional for showing the page byline details
* Added `display_page_byline` default and set as false
* Changed `the_post_thumbnail` to use parameters which are set in the call to `OpusPrimusImage::featured_image`
* Changed post thumbnail on pages to full size image and align to the center
* Changed comment fields into an unordered list
* Changed `meta-tags` container from `p` to `div` (adjusted CSS as needed)
* Changed `opus_post_byline_details` filter to `opus_post_byline_phrase`
* Check for long post titles in breadcrumbs and trim as needed
* Display comment count in meta details if comments exist and comments are closed
* Fixed call to wrong post navigation function in single view
* Merge `opus-ignite.php` into `functions.php`
* Moved `featured_image` method call into `is_single` conditional in post-format loops
* Removed `featured_image` method call from post-formats link and video loops
* Removed global `$opus_image_meta`; replaced with call to `exif_data` method
* Removed `style.less` related function and action calls
* Removed `restore_image_title`

= CSS =
* Added styles for comment form fields
* Added more specific selector used with `.post.format-link`
* Added more BNS Plugin Integration (BPI) adjustments
* Added styles from compiled `style.less` file (file removed)
* Added `img` elements for captioned images and `wp-smiley` images
* Address both class and id usage for the sidebar search form
* Adjusted widths of comment form elements
* Adjusted CSS to better handle large images with captions in large full-width displays
* Adjusted `table` elements from `max-width: 100%` to `width: 100%` and other minor changes
* Minor tweaks and adjustments
* Sorted out the adaptive layout for screens less than 480px wide

= JavaScript =
* Added more specific selector used with `.post.format-link` when adding `.link-symbol` class
* Added script to create class to display tables with striped rows
* Removed LESS JavaScript library

= Stanzas =
* PullQuotes - Added `pullquotes-readme.txt` file
* PullQuotes - Added left-side placement with new `to` parameter
* Taglines - Added `taglines-readme.txt` file
* THA - Added `tha-readme.txt` file

= Miscellaneous =
* Documentation Updates
* Minor changes to text tense used in `changelog.txt`
* Removed `style.less` file (compiled and merged into `opus-primus.css` file)
* Removed license references related to LESS as all components were removed
* Updated `hooks-actions.txt`
* Updated `hooks-filters.txt`
* Updated `readme.txt` FAQ - What is the difference between how the "Featured Image" is used on a post and how it is used on a page?
* Updated `readme.txt` FAQ - What are Stanzas?
* Updated `readme.txt` FAQ - What happened to the LESS components of the theme?

/** ------------------------------------------------------------------------- */
== Version 1.1.1 ==
* Released March 2013

= Code =
* Added `all_comments_count` and `show_all_comments_count` methods to Comments class to be used in the 'comments.php' template when displaying total comments
* General minor code refactorings and improvements
* Moved `comments only tab`, `pingbacks only tab` and `trackbacks only tab` functionality into Comments class methods
* Moved `comments only panel`, `pingbacks only panel` and `trackbacks only panel` functionality into Comments class methods

= CSS =
* Added rounded corners for the comment type tabs and the comments panel
* Added `#d3d3d3` color as default tab background color; active is transparent
* Removed unused element for non-existent 'comments-toggle' script

= Miscellaneous =
* Remove $content_width set values from Structures class method `layout_open` and set in 'functions.php'
* Updated 'hooks-actions.txt'

/** ------------------------------------------------------------------------- */
== Version 1.1 ==
* Released March 2013

= Code =
* Added `excerpt_more_link` and attached to `excerpt_more` filter
* Added `anchor_title_text` for use with `excerpt_more_link` and permalink in the post meta details
* Added additional list wrapper around each comment type
* Added Breadcrumbs trails to pages and posts
* Added Comment Tabs for each type (Comment, Pingback, and Trackback)
* Created and enqueued 'opus-primus-comment-tabs.js'
* Created Header class
* Dropped `restore_image_title` filter hook into `media_send_to_editor` as potentially blocking insertion of media
* Fixed comments (only) count output
* Limit width generated by "Full Size Video" JavaScript to a maximum of 1000px
* Refactored Structures class to put `site_title`, `site_description`, and `custom_header_image` into Header class
* Refactored `opus-primus-header` to reflect class/method changes of Structures and Header

= CSS =
* Added classes to `h2`, `ul`, and `li` elements in `OpusPrimusAuthors::author_details`
* Add minor comments styles
* Centered content of Post Format: Video posts.

= Miscellaneous =
* Removed unused style sheet 'opus-primus-responsive-layout.css'

/** ------------------------------------------------------------------------- */
== Version 1.0.4 ==
* Released March 2013

= Code =
* Added 'Breadcrumbs' class
* Fixed problem with wrong loop method call in 'archive.php'
* Moved `breadcrumbs` method from 'Structures' class to 'Breadcrumbs' class
* Removed `hgroup` container from 'opus-primus-header'

= CSS =
* Added Breadcrumbs section
* Code formatting

/** ------------------------------------------------------------------------- */
== Version 1.0.3 ==
* Released February 2013

= Code =
* Changed the MetaBoxes class to TagLines
* Moved TagLines into its own Stanza as another example of the theme extensibility
* Added `breadcrumbs` method to Structures as a precursor to new features in version 1.1

/** ------------------------------------------------------------------------- */
== Version 1.0.2 ==
* Released February 2013

= Code =
* Fixed 'search' template bug when a page is returned in the results

= CSS =
* Started "BNS Plugin Integrations" (aka BPI) - BNS Inline Asides

/** ------------------------------------------------------------------------- */
== Version 1.0.1 ==
* Released February 2013

= Code =
* Added 'opus_footer_after' action hook
* Change classes in '404.php' from using underscores to using hyphens
* Created new methods `the_loop_wrapped` and `the_loop_archives_wrapped`
* Modified action hooks to more semantic naming convention: `opus_<section>_<placement>`
* Moved 'opus_body_bottom' action hook to immediately before closing body tag
* Replaced `the_loop` method and surrounding code with `the_loop_wrapped`
* Replaced `the_loop_archives` method and surrounding code with `the_loop_archives_wrapped`
* Wrapped 'opus_modified_post_after' action hook in conditional making it consistent with 'opus_modified_post_before'

= CSS =
* Centered top level menu items only - better aesthetics with short page titles
* Added `clear: both;` to 'img.aligncenter, img.center' to address Firefox issue when when a Featured Image and a large in post image are too close together.
* Added post coda post format classes
* Fixed really long Post Titles and Words not wrapping as expected

= Miscellaneous =
* Fixed no comments message
* Minor code formatting
* Refactored the 'hooks-actions.txt' listing
* Updated 'theme-version-guidelines.txt' as taken from http://opusprimus.com/under-the-page/theme-version-guidelines/
* Updated 'hooks-actions.txt' as taken from http://opusprimus.com/under-the-page/hooks-actions/

/** ------------------------------------------------------------------------- */
== Version 1.0 ==
* Initial release - February 2013


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