# Backlog

Known issues and pending work, found while analyzing and testing Quevedo 1.4 in WordPress Playground (WordPress 7.1.3, PHP 8.3) on 2026-10-13. Not grouped into milestones yet.

## Features to review

- **"Disable post tags" only hides tags in the admin.** Posts keep showing their existing tags and `/tag/...` archives still load. Decide whether to also hide or redirect them.
- **"Redirect attachment pages" is superseded by WordPress core.** Since WordPress 6.4, sites with attachment pages disabled (the default for new sites) redirect them to the file before the plugin runs. The feature only matters on sites that keep attachment pages; update its description or behavior.
- **The default featured image looks like the post's own in the editor.** The `default_post_metadata` filter also applies in the editor, so posts without a featured image show the default one as if it were set, and the user can't tell the difference.
- **Author and date archives both call `redirect_canonical()`.** With both features on, `redirect_canonical()` runs twice per request. Merge them into one `template_redirect` callback.

## WordPress.org review

- **Plugin Check.** Not run yet; it needs a Studio site.

## Accessibility and UI

- **The toggles can't be used with the keyboard.** The checkboxes are hidden with `display: none`, which removes them from the tab order. Hide them visually instead.
- **No visible button to choose the default image.** The media library only opens by clicking the preview image. Add a "Select image" button next to "Remove image".

## Code standards and tooling

- **Plugin header.** Add `Requires at least` and `Requires PHP` to `quevedo.php`.
- **Typos in user-facing strings.** "simgle pagle", "theaks", "posts formats", and "standar" in comments. Fixing them changes the translatable strings, so update the `.pot` and the Spanish translation too.

## Release

- **`readme.txt` says "Tested up to: 7.0".** The current version is 7.1.
