=== Opus Primus readme.txt ===
* Last revised July 27, 2014

== Contents ==
* Copyright
* Licenses
* Screenshots
* Basic FAQ
* Notes
* Changelog
* Review Tickets

== Copyright ==
Copyright (c) 2012-2014, Opus Primus

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

This above may not be construed as overriding any item with a previously written
and applied license, stated or not, which will take precedence over anything
written here.

== Screenshots ==

== Basic FAQ ==
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
on posts and shows the page hierarchy from the highest level to the lowest. The
second trail is used on single views of posts and shows the first category and
Post-Format of the post, both linked to their respective archive.

Q: Where are the menu locations, and how are they used?
There are three menu locations defined in Opus Primus.
* The Primary Menu, located at the top of the page above the main content area.
* The Secondary Menu, no location is set by default; the menu has been pre-
defined for uses as the case may be, for example, page templates or Child-Themes
* The Search Results Menu, located at the bottom of the content area when there
are no search results returned, especially in the case of a "404" error be sent.

Q: Why are there blank areas in my menu?
Although not always the case, it has been shown that if you have a page without
a title and you are using a menu created by the default settings (read: not a
custom menu) you may experience a "blank" area in your menu (usually at the
beginning). This has been noted on the WordPress core trac ticket "Empty Page
Title Not Handled in Menu System" https://core.trac.wordpress.org/ticket/23254

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

Q: Are Child-Themes supported and can they have their own LESS stylesheet?
Simply put, yes. Opus Primus supports WordPress Child-Themes like any other well
made theme. A very simple Child-Theme template is available upon request if you
need help getting started. Please email in.opus.primus@gmail.com for more info.

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
See `changelog.txt` in theme root folder

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