# Status

WordPress plugin published on WordPress.org. Version 1.5 is published on WordPress.org (SVN r3753561) and on GitHub (tag v1.5): fixes from the code analysis, security, accessibility, PHP 8.2, and translations only from translate.wordpress.org. The code passes WPCS and Plugin Check with no errors.

No work in progress and no blockers. Next: whatever comes up in the backlog or from users.

## Pending: migration to bender (Mac mini M1)

The project is moving from the Windows machine to bender. The paths in "Publishing to WordPress.org (SVN)" and "Test environment" below are still the Windows ones. On the first session on bender, update them:

- Run `composer install` (vendor/ is not in the repo).
- Install `svn` (`brew install subversion`), redo the sparse checkout (`trunk/` and `assets/` at full depth, `tags/` empty) and cache the `nilovelez` credentials again: the cached ones stayed on Windows.
- Recreate the Studio site with the plugin linked from the clone and Plugin Check installed.
- Replace the Windows paths in this file with the new ones, remove this section and add a Log entry.

## Publishing to WordPress.org (SVN)

Version 1.5 was published on 2026-10-18 by Claude, step by step with Nilo's confirmation. How it was done, for the next release:

- Working copy at `D:\repos-svn\quevedo`, a sparse checkout of https://plugins.svn.wordpress.org/quevedo/: `trunk/` and `assets/` at full depth, `tags/` empty. Run `svn update` before starting.
- The command-line client is `C:\Program Files\TortoiseSVN\bin\svn.exe`. The WordPress.org credentials of `nilovelez` were cached (check with `svn auth plugins.svn.wordpress.org`); if they are not, Nilo enters the password.
- Steps: replace the contents of `trunk/` (keeping `.svn`) with `git archive --format=zip v<version>`; `svn add` the new files and `svn rm` the missing ones; `svn cp trunk tags/<version>`; compare the root `assets/` with the repo's by hash; commit trunk and tag together with the message "Release version <version>.".
- Afterwards: wait for the plugin API to report the new version, download the zip from wordpress.org, compare it with `git archive`, and check the plugin page.
- The old trunk's development files (`README.md`, `phpcs.xml`, `trunk/assets/`, `languages/`) were removed with 1.5. The root `assets/` matched the repo's and was not touched.

## Test environment

- Studio site at `C:\Users\manolito\Studio\quevedo` (http://quevedo.local/, admin / password), in Spanish, with the plugin linked from the repo (junction to `D:\repos\quevedo`) and Plugin Check installed. It is stopped; start it with `studio start --path "C:\Users\manolito\Studio\quevedo" --skip-browser` or from the Studio app.
- For Playground: `blueprint.json` at the repo root. Port 9400 may be taken by another project: use `--port 9401` together with `--site-url`.

## Log

Newest entries first. One per work session, brief.

- 2026-11-04: preparing the move to bender (Mac mini M1); repo and memory checked. Machine-specific setup listed under "Pending: migration to bender".

- 2026-10-18: version 1.5 published on WordPress.org (SVN r3753561), without an Upgrade Notice. Download zip verified identical to `git archive v1.5`; the plugin page shows 1.5 and PHP 8.2.
- 2026-10-16: migrated to the new Guppy format (STATUS.json).
- 2026-10-14: repo moved from `C:\Users\manolito\quevedo` to `D:\repos\quevedo`; Studio plugin junction recreated to point to the new path.
- 2026-10-13: session closed. SVN release plan documented above; servers stopped.
- 2026-10-13: version 1.5 published on GitHub (tag v1.5), tested in Studio with WordPress 7.1.3.
- 2026-10-13: 1.5 milestone merged into master. Plugin Check with no errors on the Studio site (Studio/quevedo); its only warning (load_plugin_textdomain) is resolved by removing the bundled translations, which already come from translate.wordpress.org (branch chore/remove-bundled-translations, not merged).
- 2026-10-13: 1.5 milestone: tags hidden and redirected, attachment pages following the WordPress setting, a single redirect, default image only on the website, "Select image" button, accessible toggles, typos (new strings untranslated), PHP 8.2 and Tested up to 7.1.
- 2026-10-13: 1.5 milestone: fixed the four bugs (lists, og:image, [lipsum], formats), capability check on save, escaping, and CSS/JS enqueued in admin/. Tested in Playground.
- 2026-10-13: 1.5 milestone opened on the release/1.5 branch; its changelog includes the WPCS cleanup. Scope: the "Bugs" and "Security and WordPress.org review" sections of BACKLOG.md.
- 2026-10-13: code clean under WPCS (composer lint with no warnings) and tested in Playground (branch fix/phpcs, not merged).
- 2026-10-13: PHPCS configured with the full WordPress standard, prefix and text domain `quevedo`, and `composer lint` (branch chore/phpcs-setup, not merged). 28 warnings left in the code.
- 2026-10-13: backlog of what needs fixing in BACKLOG.md; the Playground blueprint merged into master.
- 2026-10-13: code analysis and tests in Playground with a new blueprint (branch chore/playground-blueprint, not merged).
- 2026-10-13: guppy/STATUS.md created.
