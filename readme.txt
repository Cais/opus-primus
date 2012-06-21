=== Opus Primus readme.txt ===
* Last revised May 9, 2012

== Contents ==
* Copyright
* Licenses
* Screenshots
* Basic FAQ
* Notes

== Copyright ==
Copyright (c) 2012, Opus Primus

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

== Licenses ==
All items are licensed under the GNU General Public License v2; or, as the case
may be, individually noted below.

* Normalize.css is a project by Nicolas Gallagher and Jonathan Neal. A minimized
version is used. Licensed as Public Domain
- for more information see http://necolas.github.com/normalize.css/

* less-1.3.0.js is a project by Alexis Sellier. A minimized version is used.
Licensed under Apache v2.0
- for more information see https://github.com/cloudhead/less.js

This above may not be construed as overriding any item with a previously written
and applied license, stated or not, which will take precedence over anything
written here.

== Screenshots ==

== Basic FAQ ==
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
- Full Page (one-column): no active widget areas
- Two-Column: widget areas active only in one sidebar area
- Three-Column: at least one widget area active in each sidebar area

== Notes ==
1. $content_width is set based on how many columns being used and the common
display size of 1024px * 768px.

This being the case, the following widths will be used:
- one-column: 990px
- two-column: 700px
- three-column: 450px