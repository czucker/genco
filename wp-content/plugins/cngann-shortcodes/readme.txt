=== ClearCode Shortcode Library ===
Contributors: mflynn, cngann, Clear_Code, bmcswee
Tags: shortcodes, tabs, sliders, tab, slide, hover, spoiler, background, clear, title, link, permalink, utilities, utility, tool, tools, toolkit
Requires at least: 2.5
Tested up to: 4.0
Stable tag: 4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shortcodes used by ClearCode in their WordPress sites.

== Description ==

Shortcodes used by ClearCode in their WordPress sites.

= How to read this guide =

*There are so many different shortcodes in this plugin that it's impractical to list out all of the seperate use-cases that are available*
*The following shortcode declaration is an annotated guide describing how to read this documentation*

**Shortcode: `[SHORTCODE_NAME]`** *This is the base shortcode that is being described*

*Parameters -- A list of the different parameters (eg: `[SHORTCODE_NAME PARAMETER1="VALUE" BOOLEAN1="Y"]`)*
* PARAMETER1: The VALUE to assign to this parameter
 * Default: The default value that is assigned to this parameter, for example: "This is a test"
* BOOLEAN1: Set to "Y" if something is true, otherwise leave blank

*Aliases -- If this shortcode can also be called as `[ALIAS1]` or `[ALIAS2]` it will be noted here*
* ALIAS1
* ALIAS2


Description of the shortcode and a general description of what it does.  If it has to be nested within another shortcode, that too will be documented in this area, like this. **Required Parent: `[SHORTCODE_PARENT_NAME]`**

= Short Codes =

**Shortcode: `[splits]`**

*Parameters*
* None

container for a row of splits

**Shortcode: `[one_half]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is one-half of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[one_third]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is one third of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[two_thirds]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is two thirds of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[one_fourth]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is one fourth of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[two_fourths]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is two fourths of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[three_fourths]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is three fourths of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[one_fifth]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is one fifth of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[two_fifths]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is two fifths of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[three_fifths]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is three fifths of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[four_fifths]`**

*Parameters*

* first: Set to "Y" if it is the first one in the set
* last: Set to "Y" if it is the first one in the set

Creates an element that is four fifths of it's container's width. **Required Parent: `[splits]`**

**Shortcode: `[clear]`**

*Parameters*

* none

Creates an element that does clear:both

**Shortcode: `[more]`**

*Parameters*

* title: the text to display when content is hidden
 * Default: Learn More... / Spoilers...

*Aliases*
* Spoiler
* Spoil

Creates a link that shows a hidden area of content when clicked

**Shortcode: `[tabs]`**

*Parameters*

* class: CSS class(es) to assign to the outer element

Creates a tabbed area.

**Shortcode: `tab`**

*Parameters*

* title: the tab's title
 * Default: New Tab

Creates a tab  **Required Parent: `[tabs]`**

**Shortcode: `[slider]`**

*Parameters*

* height: Height in css-compatible units.
 * Example: 400px

Creates a slider container

**Shortcode: `[slide]`**

*Parameters*

* none
* src: Background image.  Can be either url or media ID.
* href|slug|id|link : Where to go when the slide is clicked.  Can be a url, slug, post/page ID, or any other link format.

Makes a slide.  **Required Parent: `[slider]`**

**Shortcode: `[hover]`**

*Parameters*

* class: CSS class(es) to assign to the element

Creates an area that toggles between two different content ares on hover

**Shortcode: `[on]`**

*Parameters*

* none

designates the content displayed when there is no hover.  **Required Parent: `[hover]`**

**Shortcode: `[off]`**

*Parameters*

* none

designates the content displayed when there is hover.  **Required Parent: `[hover]`**

**Shortcode: `[background]`**

*Parameters*

* bgcolor: the background color
* src: Background image.  Can be either url or media ID.
* position: Background Position.
 * Default: top left
* repeat: Background Repeat.
 * Default: no-repeat
* height: Height in css-compatible units.
 * Example: 400px
* width: width in css-compatible units.
 * Example: 100%
 * Default: 100%
* class: CSS class(es) to assign to the element
* color: the foreground color
* padding: padding of element
 * Default: "0px 0px 0px 0px"

creates a div with a background you set

**Shortcode: `[flashcard]`**

*Parameters*

* height: Height in css-compatible units.
 * Example: 400px
* width: width in css-compatible units.
 * Example: 100%
 * Default: 100%
* class: CSS class(es) to assign to the element

click to rotate from `[front]` to `[back]`

**Shortcode: `[front]`**

*Parameters*

* click : what to click to toggle the flip
 * Default: all
 * Example: .close

Front side of the FlashCard  **Required Parent: `[flashcard]`**

**Shortcode: `[back]`**

*Parameters*

* click : what to click to toggle the flip
 * Default: all
 * Example: .close

Back side of the FlashCard  **Required Parent: `[flashcard]`**

**Shortcode: `[linkmap]`**

*Parameters*

* height: Height in css-compatible units.
 * Example: 400px
* width: width in css-compatible units.
 * Example: 100%
 * Default: 100%
* class: CSS class(es) to assign to the element
* src: Background image.  Can be either url or media ID.
* hover_src: Alternate Background image.  Can be either url or media ID.
* flashcard: Set to "y" to make clicking an area flip to the content of that area
* bgcolor: The background color
 * Default: transparent

Image map replacement using divs.
Use one image for the background, then alter that image for all of the hover changes.
Create a `[maplink]` for each clickable area in the image.

A clickable area in a linkmap  **Required Parent: `[linkmap]`**

**Shortcode: `[link]`**

*Parameters*

* class: CSS class(es) to assign to the element
* href|slug|id|link : Where to go when the slide is clicked.  Can be a url, slug, post/page ID, or any other link format.

Get a link

**Shortcode: `[title]`**

*Parameters*

* id|slug : an identifier for the post/page/etc... to get the title for

Get the title for a page/post/etc... in your WordPress install

**Shortcode: `[buttons]`**

*Parameters*

* align: the alignment of the inner of the area

Designate a area that holds buttons

**Shortcode: `[button]`**

*Parameters*

* class: CSS class(es) to assign to the element
* title: the text displayed in the button

Create a div that's a button so jQuery can be used on it

= Full Examples =

**Splits**

`[splits]
	[one_fourth first="Y"] Hello [/one_fourth]
	[one_fourth] World! [/one_fourth]
	[one_fourth last="Y"] I am Mike [/one_fourth]
[/splits]`

**Tabs**

`[tabs]
	[tab title="Tab 1"]
		Content
	[/tab]
	[tab title="Tab 2"]
		Content 2
	[/tab]
[/tabs]`

**Link & Title**
`This will contain a link to the page whose id is 5 and it's title: [link id="5"][title id="5"][/link]`

= Future Plans =

* Code Comments
* Examples / How to
* Document advanced shortcodes better, get screenshots/video of them in action:
 * Linkmap
 * FlashCard
 * Slider
* TinyMCE Integration
 * Buttons to create/edit shortcodes
 * Content filters that display shortcodes output in the editor and when focused on allow you to click the aforementioned button again to edit it's info - like bold or italic

= Known Issues =

* `[email_form]` needs to be tied into WordPress' email system and should actually send out an email
* `[person]` needs formatting

== Screenshots ==

1. A tab shortcode in action
2. More link closed
3. More link open
4. 50/50 split

== Installation ==

1. Upload `cngann-shortcodes` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==
= 4.0 =
Added better documentation
Added a "How to read" section to the documentation.
Better format for documenting the required parent shortcode for shortcodes that require them.
Spell checked the Documentation.

= 3.8.07 =
Added fifth splits

= 3.6 =
Fixed background display bug

= 3.4 =
* Added Documentation

= 3.3 =
* Bug Fixes:
 * Fixed an error that caused the site to crash

= 3.0 =
* Bug Fixes:
 * Slider multi-instance fails.
 * Slider "first" property - make it work in other themes
 * Slider now uses src parameter instead of altering it's content to get an image
* Removing Dependency on php 5.3
* Removing development error reporting
* Making Class Based
* Complete Re-write

= 2.3 =
* Adding Email Form
* Adding button
* Adding Email Form AJAX processor

= 2.2 =
* Cleanup
* Added various parameter aliases
* Added link
* Added title

= 2.0 =
* Added flashcard
* Added linkmap

= 1.6 =
* Added changelog - Better late than never!  I'll start using it i swear!

== Upgrade Notice ==

= 3.3 =
Bug-fix for the severe error that was happening in 3.0 - 3.2
You'll want the background shortcode... trust me