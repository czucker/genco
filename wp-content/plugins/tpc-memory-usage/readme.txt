=== TPC! Memory Usage ===
Contributors: cstrosser
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7666470
Tags: memory usage, admin, memory, security
Requires at least: 2.7
Tested up to: 3.8
Stable tag: 0.9.1

View detailed system information and keep track of your WordPress memory usage, including peak and current usage, and have e-mail notifications sent if memory usage passes the memory usage threshold. Features a dashboard widget, historical data, and settings page for customization.

== Description ==

TPC! Memory Usage allows WordPress administrators to view the current and peak memory usage of the application. This is extremely helpful when testing new plugins, or if there are a lot of modifications, plugins, or large language files. As of version 0.4, administrators now have the ability to view detailed system information about their web server, MySQL, PHP, and WordPress software. (Requires PHP5)

<a href="http://webjawns.com/tpc-memory-usage-for-wordpress/" title="TPC! Memory Usage - Official Site">Need help or have a suggestion? Join the discussion on TPC! Memory Usage!</a>

A strategic dashboard widget will provide a snapshot which includes the following information:

* Current memory usage
* Current peak memory usage
* Logging for all-time highest memory usage
* File logging for memory usage at checkpoints, when usage exceeds set threshold, both, or none.
* Ability to add custom checkpoints (checkpoint - a WordPress core, language or plugin action at which memory usage is measured)
* Send e-mail notification if memory usage reaches threshold setting
* Customize permissions to show certain users the memory usage widget and display mechanisms
* View PHP and WordPress memory limit (defined in wp-settings.php)
* View PHP version, User Agent tag, server software information

A detailed system information page allows you to keep a close watch on:

* Server, host, and client information
* PHP information
* MySQL uptime, version, and more
* Common and advanced WordPress settings
* Completes basic security check to help prevent attacks

== Installation ==

1. Download TPC! Memory Usage.
2. Upload all files into `/wp-content/plugins/tpc-memory-usage/`.
3. Activate the plugin using the WordPress plugin administration panel.
4. In the left-hand navigation menu, an item entitled Memory Usage should appear.
5. Customize your TPC! Memory Usage installation by adding checkpoints, and using the on-screen options.
6. If you choose to enable file logging, you must make sure that `/wp-content/plugins/tpc-memory-usage/logs/tpcmem.log` is writable on the server.

== Screenshots ==

1. The default dashboard widget with the lower information panel extended
2. The Security Check located within the System Overview

== Changelog ==

= 0.9.1 =
* Updated compatibility for WordPress 3.8
* Fixed memory usage bar graph
* Fixed missing closing SPAN tag

= 0.9 =
* Database logging implemented.
* Reports administration page added for viewing database log.
* Added load averages to dashboard and overview (Linux only).
* Added Apache modules to overview.
* Added `allow_url_fopen`, `allow_url_include`, and `open_basedir` to Security Check.

= 0.8.3 =
* Added Tpcmem_Log_Adapter_Interface for increased extensibility.
* Use dependency injection to implement logging, reducing coupling between objects.
* Changed directory structure for class files to fit ZF coding conventions.
* Trimmed number of plugin files.

= 0.8.2 =
* Adjusted memory limit for graphs, and footer.
* Improved ModSecurity detection.
* Switched to object-oriented model for security check.

= 0.8.1 =
* Added WordPress unique authentication key detection to Security Check.
* Improved System Overview UI.
* Additional WordPress configuration settings added to System Overview.
* Fixed bugs related to 'magic_quotes_gpc' and ModSecurity detection.

= 0.8 =
* File logging for tracking memory usage at checkpoints, and also when usage exceeds threshold.
* Number of database queries shown in high memory usage notification e-mail.

= 0.7.2 =
* Pull PHP 'memory_limit' directly from php.ini instead of using runtime value.

= 0.7.1 =
* Fixed bug related to default checkpoints.

= 0.7 =
* Added support for custom checkpoints, which is defined as a WordPress core, language or plugin action at which memory usage is measured.
* Ability to add multiple recipients of high memory usage notification e-mail.

= 0.6.1 =
* Fixed high memory usage notification e-mail function.

= 0.6 =
* Updated architecture application architecture (PHP5 object model).
* Changed default memory usage notification level from 16MB to 32MB.

= 0.5.1 =
* Added check for apache_get_modules().

= 0.5 =
* Added Security tab to System Overview page (helps prevent security-related vulnerabilities).
* Under Server tab, Server Signature says OFF when it is blank.

= 0.4 =
* Added detailed system information page (MySQL, WordPress, PHP, server/client)
* Added System Overview link to dashboard widget
* Moved TPC! Memory Usage menu item from Settings to top-level menu called Memory Usage

= 0.3.1 =
* Added confirmation for settings page when update completed.

= 0.3 =
* Send e-mail notification to admin if memory usage reaches threshold setting
* Reduced database queries (peak usage only logged at shutdown)
* Moved checkpoint registration to separate function
* Added checkpoint counters to count how many memory usage samples are taken

= 0.2.1 =
* Fixed script and style path bug.

= 0.2 =
* Ability to log historically highest memory usage
* Ability to block certain users from viewing the dashboard widget and other display mechanisms

= 0.1 =
* Initial release
* Dashboard widget with peak and current memory usage
* Option to show memory usage in administration panel footer
* Option to show memory usage in comments within the WP site pages and posts

== Frequently Asked Questions ==

= Why do I keep getting messages saying my memory limit has been exceeded? =
This is actually a feature of TPC! Memory Usage that you can adjust or turn off at will. TPC! Memory Usage will send notifications if the memory usage of PHP exceeds the preset amount (defaults to 32MB). You can change this under Notifications on the Settings page.

= What is a checkpoint? =
A checkpoint is any WordPress action (also known as a hook) at which memory usage is measured. A list of WordPress actions can be found at <a href="http://codex.wordpress.org/Plugin_API/Action_Reference" title="Plugin API/Action Reference">http://codex.wordpress.org/Plugin_API/Action_Reference</a>. Most plugins also use their own actions, and a checkpoint can be created using those as well.

= Why can't I see the memory usage within the HTML on the pages/posts? =
This can happen for either one of two reasons. First, make sure that this feature has been enabled and you are looking in the correct place. A quick search for 'Memory Usage' (w/o the quotes) may help you find the data; however, if this doesn't work you will have to make sure that the `wp_head()` or `wp_footer()` functions or actions are called within the theme you are using. Some themes do not include out-of-the-box support, so you may have to add the `wp_head()` or `wp_footer()` functions to the theme templates yourself.