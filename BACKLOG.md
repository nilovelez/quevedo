# Backlog

Known issues and pending work, found while analyzing and testing Quevedo 1.4 in WordPress Playground (WordPress 7.1.3, PHP 8.3) on 2026-10-13. Not grouped into milestones yet.

## Bugs

- **Lists can only have one item when "Simplify editor blocks" is on.** The allowed blocks include `core/list` but not `core/list-item` (required since WordPress 6.1), so pressing Enter in a list doesn't add a new item. (`quevedo-actions.php`, `allowed_block_types_all` filter)
- **`og:image` ignores the post's own featured image.** When a default featured image is set, it is always used for the Open Graph and Twitter tags, even if the post has its own featured image, while the theme shows the post's own. The default should be a fallback only. The setting description repeats the same wrong order. (`get_post_featured_image_attachment_id()` in `quevedo-actions.php`)
- **`[lipsum]` mishandles invalid `words` values.** The `is_int` check is inverted and the value is never cast to an integer: `words="abc"` returns 2000 words instead of the default 200, negative values return nothing, and decimals log "Implicit conversion from float-string" deprecation notices on PHP 8.1+. The docblock says the default is 100 and the shortcode is `[lorem]`; both are wrong. (`quevedo-shortcodes.php`)
- **"Disable post formats" does nothing on the front end.** The `after_setup_theme` callback is added from `init`, after that hook has already fired. Only the `admin_init` callback works.

## Features to review

- **"Disable post tags" only hides tags in the admin.** Posts keep showing their existing tags and `/tag/...` archives still load. Decide whether to also hide or redirect them.
- **"Redirect attachment pages" is superseded by WordPress core.** Since WordPress 6.4, sites with attachment pages disabled (the default for new sites) redirect them to the file before the plugin runs. The feature only matters on sites that keep attachment pages; update its description or behavior.
- **The default featured image looks like the post's own in the editor.** The `default_post_metadata` filter also applies in the editor, so posts without a featured image show the default one as if it were set, and the user can't tell the difference.
- **Author and date archives both call `redirect_canonical()`.** With both features on, `redirect_canonical()` runs twice per request. Merge them into one `template_redirect` callback.

## Security and WordPress.org review

- **No capability check when saving settings.** The forms are processed on `init` with a nonce check but no `current_user_can( 'manage_options' )`.
- **Escaping.** `esc_html()` is used for the notice `class` attribute (should be `esc_attr()`), and `esc_attr()` for image URLs (should be `esc_url()`).
- **Inline CSS and JavaScript in the settings page.** Move them to enqueued files (`wp_enqueue_style()`, `wp_enqueue_script()`), loaded only on the plugin's page.
- **Plugin Check.** Not run yet; it needs a Studio site.

## Accessibility and UI

- **The toggles can't be used with the keyboard.** The checkboxes are hidden with `display: none`, which removes them from the tab order. Hide them visually instead.
- **No visible button to choose the default image.** The media library only opens by clicking the preview image. Add a "Select image" button next to "Remove image".

## Code standards and tooling

- **Plugin header.** Add `Requires at least` and `Requires PHP` to `quevedo.php`.
- **Typos in user-facing strings.** "simgle pagle", "theaks", "posts formats", and "standar" in comments. Fixing them changes the translatable strings, so update the `.pot` and the Spanish translation too.

## Release

- **`readme.txt` says "Tested up to: 7.0".** The current version is 7.1.
