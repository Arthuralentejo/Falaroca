=== ZF WordPress Category Search ===
Contributors: ZuFusion
Tags: custom post type, taxonomies, woocommerce search, wordpress search, tab slider category, radio category search, dropdown category search, search price range, date range, author, woocommerce attributes
Requires at least: 3.7
Tested up to: 4.1
Stable tag: 2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

ZF WordPress Category Search is a WordPress advanced search box, the ability display categories as tabs/radio/dropdown with advanced fields, support custom post type, taxonomies.
You can search by search categories, tags, taxonomies, authors, date range, sort, order by ...
Otherwise, you can also search multiple taxonomies of custom post type. These easily to really refine your searches.

== Description ==

ZF WordPress Category Search is a WordPress advanced search box, the ability display categories as tabs/radio/dropdown with advanced fields, support custom post type, taxonomies.
You can search by search categories, tags, taxonomies, authors, date range, sort, order by ...
Otherwise, you can also search multiple taxonomies of custom post type. These easily to really refine your searches.

Key Features:

* Tab slider category
* Tab alignment
* Radio category search
* Dropdown category search
* Auto suggest like google
* Support WooCommerce category search, WordPress category search
* Support custom post type, multiple taxonomies
* Drap vs drop taxonomies to display
* Search multiple taxonomies, author, price range, date range, order
* Translation ready
* Widget vs Shortcode ready
* Easy to setup and customize
* Support dark vs light skin
* Cross-browser support


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin through `Plugins > Add New > Upload` interface or upload `zf-wordpress-category-search` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress

== How to use the plugin ==

= Using Widget =

1. Go to Appearance -> Widgets, Drag ZF WordPress Category Search widget in to your WordPress Sidebar
2. Save
3. You are done.

= Using Shortcode =

You can use this shortcode in your posts, pages and custom posts

[zfwcs title=""]

== Changelog ==

= 1.0 =
* First release
= 2.0 =
* Added auto suggest like google
* Support custom post type, multiple taxonomies
* Drap vs drop taxonomies
* Moved all options to setting page
* Added some hooks function for the developer
= 2.1 =
* Support Easy Digital Downloads
* Fixed radio css
= 2.2 =
* Fixed menu disappear after using search
* Fixed insert icon for Easy Digital Downloads
= 2.3 =
* Support search form template
* Added taxonomy checkbox field
* Put Advanced box inside the  popup
= 2.4 =
* Added match type taxonomy values (categories) on setting page
* Allows show open advanced button inside or outside input query
* Show advanced button with icon or text or both
* Fixed dropdown mode doesn't show categories
* Fixed conflict with user pro plugin
* Fixed long category name for dropdown mode
= 2.5 =
* Fixed can't open advanced box when category box is empty
* Fixed doesn't respond to the tags, categories of post in advanced box
* Change default value of min count selected to 0 instead of 3 (only dropdown mode)
= 2.6 =
* Work with WordPress 5.2
= 2.7 =
* Added translatable and properly escaped
* Added .pot template file
* Removed en_US.mo and en_US.po
* Removed assets from CDN
* Data Validation
* Added "use strict" to js