=== Clean Login ===
Contributors: hornero, carazo
Donate link: http://codection.com
Tags: form, login, registration, editor, lost password, responsive, wpml, internationalization, languages, role, CAPTCHA, honeypot, shortcode, wordpress, frontend
Requires at least: 3.4
Tested up to: 4.0.0
Stable tag: 1.1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin for displaying useful forms in front-end only using shortcodes. Login, Registration, Profile Editor and Lost Password forms

== Description ==

Responsive Frontend Login and Registration plugin. A plugin for displaying login, register, editor and restore password forms through shortcodes.

*   _[clean-login]_
*   _[clean-login-edit]_
*   _[clean-login-register]_
*   _[clean-login-restore]_

## **Basics**

*   Add your login form in the frontend easily (page or post)
*   And also the registration and the lost password form
*   If user is logged in, the user will see a custom profile and will be able to edit his/her data in another front-end form
*   One shortcode per form, you only need to create a page or post and apply this shortcode to create each form you want

## **Style**

*   Every form created is Responsive
*   CSS adapted to every theme

## **Spam protection**

*   Register form protected with CAPTCHA (as an option)
*   Forms are also protected by Honeypot antispam protection

## **Internacionalization**

*   WMPL ready
*   .po/.mo template included
*	English, Spanish and French languages included by default

## **More features**

*   Auto status checker
*   Hide admin bar for non-admin users as an option
*   Disable dashboard access as an option
*   Standby user role for new user registration. With no capabilities, to allow admin approval of users optionally
*   Auto linked forms, if you place a shortcode in a page/post the link between them will be automatically generated
*   And yes, this is WordPress 4.0 ready! Also compatible with WooCommerce.

You could test it here [cleanlogin.codection.com](http://cleanlogin.codection.com/). Enjoy!

== Usage and Settings ==

Please, refer to [Installation section](https://wordpress.org/plugins/clean-login/installation/)

== Screenshots ==

1. Login form
2. Preview user
3. Editor form
4. Lost password form
5. Register form with CAPTCHA
6. Setting access from the dashboard
7. Setting page from the dashboard
8. Settings menu
9. Plugin status
10. Options section
11. Settings updated

== Changelog ==

= 1.1.4 =
*   Danish language included. Thanks to Bkold (Børge Kolding)
*   Registration button disabled on submit (with JS, no jQuery to ensure themes compatibility)
*   Icon for WordPress dashboard included (for both 128 and 256 px resolutions)

= 1.1.3 =
*   French language updated from sources (no translation included)

= 1.1.2 =
*   Simplifying the placeholder in the restore form by ensuring external plugins (which replace strings) compatibility.

= 1.1.1 =
*   Bug detected: First name and last name of the current user is hidden if the username is hidden by settings. Solved!

= 1.1.0 =
*   Enabling to permit users to reset their password using their email. Feature supported by KTS915
*   The username can be switched off from the preview form. Feature supported by KTS915
*   Spanish language updated.

= 1.0.6 =
*   French language included. Thanks to Blasteur83 (Dylan Lane)

= 1.0.5 =
*   Prepend all the functions names by ensuring the plugin compatibility and stability. Thanks to dharmashanti
*   Tested on 3.9.2

= 1.0.4 =
*   Output buffering turned on, following the Shortcode API. Thanks to stewarty

= 1.0.3 =
*   Mistake solved under plugin description. Thanks to WP-Biz (Ryan)

= 1.0.2 =
*   Demo site URL updated and also the content
*   Screenshots updated
*   Documentation deleted from index.html and also updated here.

= 1.0.1 =
*   Banner created
*   Screenshots added
*   Demo site for testing purposes

= 1.0.0 =
*   First release

== Upgrade Notice ==

= 1.0 =
*   First installation

== Demo site ==

[cleanlogin.codection.com](http://cleanlogin.codection.com/)

== Frequently Asked Questions ==

*   Not yet

== Installation ==

### **Installation**

*   Install **Clean Login** automatically through the WordPress Dashboard or by uploading the ZIP file in the _plugins_ directory.
*   Then, after the package is uploaded and extracted, click&nbsp;_Activate Plugin_.

Now going through the points above, you should now see a new&nbsp;_Clean Login_&nbsp;menu item under Settings menu in the sidebar of the admin panel, see figure below of how it looks like.

[Setting Menu image link](https://ps.w.org/clean-login/assets/screenshot-8.jpg)

If you get any error after following through the steps above please contact us through item support comments so we can get back to you with possible helps in installing the plugin and more. On successful activation of this plugin, you should be able to see the login form when you place this shortcode&nbsp;_[clean-login]_&nbsp;in any page or post

* * *

### **Settings**

Below, the description of each shortcode for use as registration, login, lost password and profile editor forms

*   _[clean-login]_ This shortcode contains login form and login information.
*   _[clean-login-edit]_ This shortcode contains the profile editor. If you include in a page/post a link will appear on your login preview.
*   _[clean-login-register]_ This shortcode contains the register form. If you include in a page/post a link will appear on your login form.
*   _[clean-login-restore]_ This shortcode contains the restore (lost password?) form. If you include in a page/post a link will appear on your login form.

Also, in the Clean Login settings page you can check the plugin status as follows:

[Plugin status image link](https://ps.w.org/clean-login/assets/screenshot-9.jpg)

In this setting page you can also find the way to enable/disable the differents options of the plugin, like below:

[Options image link](https://ps.w.org/clean-login/assets/screenshot-10.jpg)

Regarding the widget usage, just place the&nbsp;_Clean Login status and links_&nbsp;widget in the widget area you prefer. It will show the user status and the links to the pages/posts which contains the plugin shortcodes.

Please feel free to contact us if you have any questions.

* * *

### **Example**

A post/page need to be created by typing the main shortcode&nbsp;_[clean-login]_&nbsp;in the content.

When you save or update this post/page you will see the login form.

And also in the setting page&nbsp;_[clean-login]_&nbsp;entry will be updated pointing to the current post/page which contains the shortcode (and generates the login form):

[Settings updated image link](https://ps.w.org/clean-login/assets/screenshot-11.jpg)

We would repeat the same process with the rest of shortcodes if we need it:

*   _[clean-login-edit]_&nbsp;to create an edit profile form
*   _[clean-login-register]_&nbsp;to create a registration form
*   _[clean-login-restore]_&nbsp;to create a forgotten password and restore form
