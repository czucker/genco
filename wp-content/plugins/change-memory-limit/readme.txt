=== Plugin Name ===
Contributors: Simon99
Tags: memory, memory limit, memory exhausted
Requires at least: 2.7
Tested up to: 3.3
Stable tag: 1.0

Update the WordPress default memory limit. Never run into the dreaded "allowed memory size of 33554432 bytes exhausted" error again!

== Description ==

Update the WordPress default memory limit. Never run into the dreaded "allowed memory size of 33554432 bytes exhausted" error again!

The default WordPress memory limit is sometimes not enough, especially if you have a lot of plugins installed. This plugin allows you to increase the memory limit without editing any WordPress files.

== Installation ==

1.) Upload 'change-mem-limit/change-mem-limit.php' to the '/wp-content/plugins/' directory.
2.) Activate the plugin through the 'Plugins' menu in WordPress.
3.) You'll automatically be forwarded to memory limit options.

== Frequently Asked Questions ==

= Why is this plugin necessary? =

The default WordPress memory limit is sometimes not enough, especially if you have a lot of plugins installed. This plugin allows you to increase the memory limit without editing any WordPress files.

= What is an appropriate limit to set? =

Most blogs are perfectly happy with a 64Mb limit. The plugin uses 64Mb as a default (if you haven't already set it higher by some other means).

= Why doesn't it work? =

Your host may prevent PHP from increasing its own memory limit. Please speak to your web host about "changing the default php memory limit".

== Changelog ==

= 1.0 =
* Release.