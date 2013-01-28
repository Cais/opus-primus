=== Opus Primus readme.txt ===
* Last revised January 28, 2013

== Contents ==
* Copyright
* Licenses
* Screenshots
* Basic FAQ
* Notes

== Copyright ==
Copyright (c) 2012-2013, Opus Primus

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

Note: Opus Primus file Copyright years start with the first year of use and are
amended with subsequent years based on file modification as the case may be.

== Licenses ==
All items are licensed under the GNU General Public License v2; or, as the case
may be, individually noted below.

* Normalize.css is a project by Nicolas Gallagher and Jonathan Neal. A minimized
version is used. Licensed as Public Domain
- for more information see http://necolas.github.com/normalize.css/

* less-1.3.3.js is a project by Alexis Sellier. A minimized version is used.
Licensed under Apache v2.0
- for more information see https://github.com/cloudhead/less.js

* Font: Merienda One
Copyright (c) 2011, Eduardo Tunni (http://www.tipo.net.ar), with Reserved Font Name "Merienda"
This Font Software is licensed under the SIL Open Font License, Version 1.1.
This license is available with a FAQ at: http://scripts.sil.org/OFL

* Font: Underwood Champion
Copyright (c) 2009, Vic Fieger (http://www.vicfieger.com/)
The Vic Fieger fonts are freeware, to be downloaded and used by anyone who wants them for free.
This license can also be found at this permalink: http://www.fontsquirrel.com/license/Underwood-Champion

This above may not be construed as overriding any item with a previously written
and applied license, stated or not, which will take precedence over anything
written here.

== Screenshots ==

== Basic FAQ ==
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

== Notes ==
1. $content_width is set based on how many columns being used and the common
display size of 1024px * 768px.

This being the case, the following widths will be used:
- one-column: 990px
- two-column: 700px
- three-column: 450px