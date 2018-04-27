=== UsersManager ===
Contributors: Stackhouse
Requires at least: 4.6
Tested up to: 4.9.5
Stable tag: 4.7
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

UsersManager allows you to create and manage recurring payments

== Description ==

UsersManager allows you to create and manage recurring payments:
Just create an account on www.usersmanager.com and start creating and proposing your products, as you wish, monthly, half-yearly, yearly etc.
Once you have created the page related to your products, you can view them on your wordpress site.
You just have to log in from our plugin and select (through settings) the products to display.

Products can be displayed on pages through the use of usersmanager tag.
It have to be inserted in the pages through editor.

The tag is: [usersmanager]

If you're setting up your page and you need to choose a specific background for your component you can override the default background (set up on plugin setting page) by using the bgcolor property. 

For Example: [usersmanager bgcolor=“eee”]
(The editor property bgcolor doesn’t need # symbol. If you use it, background will be white)

If you need to use a single page of your account you must insert id property:

Example: [usersmanager id="_Ie14kfsf1kfFas"]
(All single ids can be found in your usersmanager account)


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/usersmanager` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->UsersManager screen to configure the plugin

== Changelog ==

= 1.0 =
* Plugin resizing adjusted using 'usrmng_resizer.js'
