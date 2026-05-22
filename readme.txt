=== Quevedo ===
Contributors: nilovelez
Tags: writing, blogging, seo, content
Requires at least: 5.9
Tested up to: 7.0
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Quevedo is a suite of tools for bloggers and content creators.

== Description ==

Quevedo is a set of tools aimed at those authors, writers or bloggers who want to use WordPress for writing. It removes some unnecessary features for single-author sites and improves SEO, but without complications.

WordPress was born as a small blogging tool. Over the years it has grown and now serves for many more things, but deep down there is still a lot of that little blogging tool. Quevedo helps you focus on what matters: writing.

= WordPress features =
Some minor tweaks to make WordPress a bit more appealing to bloggers and single-user site owners.

* Disable post tags: Prevents duplicate content
* Disable post formats: Removes clutter from the post editor
* Disable author archives: Avoids SEO issues for single-author blogs
* Disable date archives: Redirects year, month and day archive pages to the homepage
* Redirect attachment pages: Prevents thin content by redirecting to the parent post
* Simplify editor blocks: When editing a blog post, the available blocks are reduced to: paragraph, heading, list, image, quote, separator, code, preformatted

= Featured image =
Options for featured images on your posts.

* Default featured image: Fallback image for posts without a featured image set
* Add featured image to post metadata: Outputs Open Graph and Twitter image meta tags using the default featured image when set, otherwise the post featured image

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