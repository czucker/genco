=== Plugin Name ===
Contributors: eherman24, SartMatt
Donate link: http://evan-herman.com/contact
Tags: xpand, Accordion, collapsable content, collapse, collapsible, display, expand, expandable, expandable content, hidden, hide, javascript, jquery, Collapse-O-Matic, more, read me, read more, Evan, Herman, Evan Herman, roll-your-own, shortcode, hidden content, collapseable content
Requires at least: 3.5
Tested up to: 3.9.1
Stable tag: 2.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily add expand and collapse functionality to any WordPress theme. No coding skills required! Beautifully simple UI. Save space with this plugin for generating collapseable content and links to reveal the content.

== Description ==

**Video Demo**

http://www.youtube.com/watch?v=fiNUqZxFwNA

**Feautres**

1. Beautifully simple UI
1. Easy to access custom tinyMCE button
1. Easily add images and YouTube video to hidden content area
1. Input direct links to images or YouTube videos
1. Quick placement of expand+collapse items
1. Use on pages and posts (or copy and paste the code to use in theme templates)
1. Use HTML markup inside the hidden content area
1. Mobile/Responsive Ready
1. Use in sidebar (inside of a 'Text' widget)
1. SEO friendly hidden content
1. Great Support

If you want to include Expand+Collapse Funk you can use the following code anywhere in your Theme: (remember to swap out the Link and Hidden Content for your content)
`
<div class="exp-col-content-holder"><a class="expand-cnt-link" href="#">This Is The Link To Click</a>
	<div class="hidden-content">
		<p class="hiddenContentp">This is all of your hidden content. This will be invisible at first, but after clicking on the link above this will slide in.</p>
	</div>
</div>
`


Using Expand+Collapse Funk allows for very easy placement of collapseable content and a link to reveal the content. The expand and collapse functionality is widely
used across the web to free up space on a page or to place semi-important content into posts, pages or into the sidebar. There is no limit to the length of the collapseable content. Easily include images,
YouTube/Vimeo videos or anything else you could imagine.

I originally built this plugin for the marketing department at my full time job, so a simple UI and ease of use was kept in mind throughout development.

Have an idea, question, concern or found a bug?<a href="http://www.evan-herman.com/contact"> Get In Contact With Me!</a>

== Installation ==

1. Upload `expand-collapse-funk.zip` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create or edit a page or post to access the 'Expand Collapse Funk' tinyMCE button.
1. Input the necessary fields, and click insert.
1. Publish the post or page and enjoy Expand+Collapse Functionality!

== Frequently Asked Questions ==

= I need some help! What's the best way to go about getting support? =

I have moved all support over to a <a href="http://www.evan-herman.com/wordpress-support/" target="_blank">support forum</a> on my website. I've done this to keep all of my plugin support in a centralized location so other users can easily find solutions before submitting requests. I have also decided to offer a premium level of support. Support will be answered very infrequently here in the repository. 


<strong>If you have a question, found a bug or require assistance please direct yourself to the support forum , sign up and open a new thread explaining your issue in detail. I will get back to you shortly with assistance.</strong>


= Do I need to know how to write code to use this plugin? =

No. No coding knowledge is required. I have created this plugin with ease of use for the end user in mind. You type everything in to input fields and the code is generated for you automagically.

= Is there a limit to the length or what can be included inside the hidden content? =

No. You can include anything from text and images to YouTube videos. The possibilities are endless! There is also no limit to the length of the content inside of the hidden content.

= Can I only use Expand+Collapse Funk in the content area of my site? =

No, you can actually include the code literally anywhere on your site. You can use the generated code in widgets to display collapseable content in your sidebar, or you can copy and paste the generated code
into your Footer.php template file to display hidden content in the footer. You can literally use the code anywhere you choose. (check the Description section for sample code)

= Is this plugin going to cause issues with any of my existing plugins? =

Most likely not. I've written the plugin following WordPress plugin best practices. All of the jQuery included in the plugin is written in No Conflict mode so as to already be compatible with the jQuery version pre-loaded with WordPress.

= I would like to include feature X, Can I help with development? =

Of course you can! I am always looking for developers to colaborate with. All of the plugins I develop are added to my <a href="https://github.com/EvanHerman"> GitHub Account</a> and seperated in to their own repositories. Send me a pull request!

== Screenshots ==

1. Expand+Collapse Funk creates a custom tinyMCE icon in the visual editor for very easy use.
2. The Expand+Collapse Funk modal on edit/new post or page screen
3. Example of very simple YouTube video integration inside collapseable content.
4. Example of generated collapsed links on a page.
5. Example of expanded links showing hidden content.

== Changelog ==
= 2.2 =
* Prevent line break after arrow in link
* Merge SartMatt's changes into the plug-in

= 2.1 =
* Removed deprecated function causing ASCII code to appear in post titles
* This also resolves the same issues for multi-language sites 

= 2.0 =
* Updated to work with tinyMCE 4.0 and WordPress 3.9

= 1.0 =
* Initial Release

== Upgrade Notice ==

= 1.0 =
Initial Release