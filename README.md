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

- **Disable post tags**: If not used properly, post tags can create a lot of duplicate content in your site. This feature hides them and redirects tag archives to the homepage
- **Disable post formats**: If you're not using post formats, they only add clutter to the post editor
- **Disable author archives**: For single-user blogs, author archives are identical to the homepage, which can lead to SEO issues
- **Disable date archives**: Redirects year, month and day archive pages to the homepage to avoid duplicate or thin content
- **Disable attachment pages**: WordPress can create a page for each uploaded file, creating thin content. This feature redirects those pages to the file itself, as WordPress does by default on sites created with version 6.4 or later
- **Simplify editor blocks**: When editing a blog post, the available blocks are reduced to: paragraph, heading, list, image, quote, separator, code, preformatted

### Featured image
Options for featured images on your posts:

- **Default featured image**: Fallback image for posts without a featured image set
- **Add featured image to post metadata**: Outputs Open Graph and Twitter image meta tags with the post featured image, or with the default featured image if the post has none

### Shortcodes
Quevedo includes useful shortcodes for writers:

- `[year]`: Returns the current year in four-digit format. Perfect for copyright notices
- `[lipsum words="200"]`: Generates Lorem ipsum placeholder text. The optional "words" attribute controls the length (default: 200)

## Requirements

- WordPress 5.9 or higher
- PHP 8.2 or higher
- Tested up to WordPress 7.1

## Installation

1. Upload the plugin files to the `/wp-content/plugins/quevedo` directory, or install the plugin through the WordPress plugins screen
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Configure each tool using the corresponding link on the **Tools > Quevedo** side menu

## Development

### Coding standards

The code follows the [WordPress Coding Standards](https://github.com/WordPress/WordPress-Coding-Standards), configured in `phpcs.xml.dist`. Install the development tools with Composer and run the checks from the repository root:

```sh
composer install
composer lint    # report
composer fix     # fix what can be fixed automatically
```

### Building the release zip

The release zip is built with `git archive` from the repository root:

```sh
git archive --format=zip --prefix=quevedo/ -o quevedo-1.4.zip HEAD
```

- `--prefix` puts the files inside a `quevedo/` folder, as WordPress expects when uploading a plugin zip. The zip file name includes the version, but the folder inside does not.
- Development files, such as this README, the WordPress.org assets and the project notes, are left out through `export-ignore` rules in `.gitattributes`. To leave out a new development file, add it there.
- Only committed files are included: commit your changes before building the zip.

## Changelog

### 1.5 (in development)
- Fixed lists in the simplified editor: pressing Enter now adds a new list item
- Fixed the Open Graph and Twitter image: the post featured image now takes priority over the default featured image
- Fixed the [lipsum] shortcode with invalid word counts, which now fall back to the default of 200 words
- Fixed "Disable post formats", which only worked in the admin
- Settings can only be saved by users allowed to manage options
- The settings page styles and scripts are now separate files, loaded only on that page
- Improved output escaping on the settings page
- "Disable post tags" now also hides existing tags on the site, in feeds and in the sitemap, and redirects tag archives to the homepage
- "Redirect attachment pages" is now "Disable attachment pages": it redirects attachment pages to the file, using the setting WordPress added in version 6.4
- Author, date and tag archives now redirect to the homepage in a single step
- The default featured image is no longer shown in the editor as if the post had it; it is only used on the site
- Added a "Select image" button for the default featured image
- The settings switches can now be used with the keyboard and screen readers
- Fixed typos in the settings page
- Requires WordPress 5.9 and PHP 8.2
- Tested up to WordPress 7.1
- Translations now come only from translate.wordpress.org, where WordPress downloads them automatically
- Code cleanup to follow the WordPress Coding Standards, with no changes in behavior

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
