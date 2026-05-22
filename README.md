![Banner Quevedo](assets/banner-1544x500.jpg)

# Quevedo

Version 1.4

Special greetings to the WordPress Sevilla community! This plugin was born thanks to the inspiring conversations and support from the local meetup.

## Description

Quevedo is a set of tools aimed at those authors, writers or bloggers who want to use WordPress for writing. It removes some unnecessary features for single-author sites and improves SEO, but without complications.

WordPress was born as a small blogging tool. Over the years it has grown and now serves for many more things, but deep down there is still a lot of that little blogging tool. Quevedo helps you focus on what matters: writing.

## Features

### WordPress Tweaks
Some minor tweaks to make WordPress more appealing to bloggers and single-user site owners:

- **Disable post tags**: If not used properly, post tags can create a lot of duplicate content in your site
- **Disable post formats**: If you're not using post formats, they only add clutter to the post editor
- **Disable author archives**: For single-user blogs, author archives are identical to the homepage, which can lead to SEO issues
- **Disable date archives**: Redirects year, month and day archive pages to the homepage to avoid duplicate or thin content
- **Redirect attachment pages**: WordPress creates individual pages for gallery images, creating thin content. This feature redirects to the parent post
- **Simplify editor blocks**: When editing a blog post, the available blocks are reduced to: paragraph, heading, list, image, quote, separator, code, preformatted

### Featured image
Options for featured images on your posts:

- **Default featured image**: Fallback image for posts without a featured image set
- **Add featured image to post metadata**: Outputs Open Graph and Twitter image meta tags. Uses the default featured image when set; otherwise the post featured image

### Shortcodes
Quevedo includes useful shortcodes for writers:

- `[year]`: Returns the current year in four-digit format. Perfect for copyright notices
- `[lipsum words="200"]`: Generates Lorem ipsum placeholder text. The optional "words" attribute controls the length (default: 200)

## Requirements

- WordPress 5.9 or higher
- PHP 7.0 or higher
- Tested up to WordPress 7.0 and PHP 8.4

## Installation

1. Upload the plugin files to the `/wp-content/plugins/quevedo` directory, or install the plugin through the WordPress plugins screen
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Configure each tool using the corresponding link on the **Tools > Quevedo** side menu

## Changelog

### 1.4
- Compatibility tested with WordPress 7.0 and PHP 8.4
- Added disable date archives feature
- Featured image settings reorganized as a collection of options
- Added Open Graph and Twitter image metadata option for posts
- Fixed featured image media uploader on the settings page

### 1.3
- Compatibility checked with WordPress 6.8

### 1.2
- Fixed PHP 8.2+ deprecation warnings
- Improved code documentation
- Added proper global variable declarations
- Fixed dynamic property creation warnings
- Added editor simplification: When editing a blog post, the available blocks are reduced to: paragraph, heading, list, image, quote, separator, code, preformatted

### 1.1
- Initial release

## License

This plugin is licensed under the GPLv2 or later.

## Author

Created by [Nilo Velez](https://www.nilovelez.com)
