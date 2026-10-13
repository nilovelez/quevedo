=== Quevedo ===
Contributors: nilovelez
Tags: writing, blogging, seo, content
Requires at least: 5.9
Tested up to: 7.1
Requires PHP: 8.2
Stable tag: 1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Quevedo is a suite of tools for bloggers and content creators.

== Description ==

Quevedo is a set of tools aimed at those authors, writers or bloggers who want to use WordPress for writing. It removes some unnecessary features for single-author sites and improves SEO, but without complications.

WordPress was born as a small blogging tool. Over the years it has grown and now serves for many more things, but deep down there is still a lot of that little blogging tool. Quevedo helps you focus on what matters: writing.

= WordPress features =
Some minor tweaks to make WordPress a bit more appealing to bloggers and single-user site owners.

* Disable post tags: Prevents duplicate content by hiding tags and redirecting tag archives to the homepage
* Disable post formats: Removes clutter from the post editor
* Disable author archives: Avoids SEO issues for single-author blogs
* Disable date archives: Redirects year, month and day archive pages to the homepage
* Disable attachment pages: Prevents thin content by redirecting attachment pages to the file, as WordPress does by default on sites created with version 6.4 or later
* Simplify editor blocks: When editing a blog post, the available blocks are reduced to: paragraph, heading, list, image, quote, separator, code, preformatted

= Featured image =
Options for featured images on your posts.

* Default featured image: Fallback image for posts without a featured image set
* Add featured image to post metadata: Outputs Open Graph and Twitter image meta tags with the post featured image, or with the default featured image if the post has none

= Shortcodes =
`[year]`
Returns the current year in four-digit format. Very useful for copyright notices.

`[lipsum words="200"]`
Returns a paragraph full of "Lorem ipsum" fill text. The optional attribute "words" defines the number of words, default is 200.

== Installation ==

1. Upload the plugin files to the /wp-content/plugins/quevedo directory, or install the plugin through the WordPress plugins screen
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Configure each tool using the corresponding link on the Tools > Quevedo side menu

== Changelog ==

= 1.5 =
* Fixed lists in the simplified editor: pressing Enter now adds a new list item
* Fixed the Open Graph and Twitter image: the post featured image now takes priority over the default featured image
* Fixed the [lipsum] shortcode with invalid word counts, which now fall back to the default of 200 words
* Fixed "Disable post formats", which only worked in the admin
* Settings can only be saved by users allowed to manage options
* The settings page styles and scripts are now separate files, loaded only on that page
* Improved output escaping on the settings page
* "Disable post tags" now also hides existing tags on the site, in feeds and in the sitemap, and redirects tag archives to the homepage
* "Redirect attachment pages" is now "Disable attachment pages": it redirects attachment pages to the file, using the setting WordPress added in version 6.4
* Author, date and tag archives now redirect to the homepage in a single step
* The default featured image is no longer shown in the editor as if the post had it; it is only used on the site
* Added a "Select image" button for the default featured image
* The settings switches can now be used with the keyboard and screen readers
* Fixed typos in the settings page
* Requires WordPress 5.9 and PHP 8.2
* Tested up to WordPress 7.1
* Translations now come only from translate.wordpress.org, where WordPress downloads them automatically
* Code cleanup to follow the WordPress Coding Standards, with no changes in behavior

= 1.4 =
* Compatibility tested with WordPress 7.0 and PHP 8.4
* Added disable date archives feature
* Featured image settings reorganized as a collection of options
* Added Open Graph and Twitter image metadata option for posts
* Fixed featured image media uploader on the settings page

= 1.3 =
* Compatibility checked with WordPress 6.8

= 1.2 =
* Fixed PHP 8.2+ deprecation warnings
* Improved code documentation
* Added proper global variable declarations
* Fixed dynamic property creation warnings
* Added editor simplification: When editing a blog post, the available blocks are reduced to: paragraph, heading, list, image, quote, separator, code, preformatted

= 1.1 =
* Initial release

= 1.0 =
* First Release