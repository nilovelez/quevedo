# Status

WordPress plugin published on WordPress.org. Version 1.5 is published on GitHub (tag v1.5) and pending upload to WordPress.org: fixes from the code analysis, security, accessibility, PHP 8.2, and translations only from translate.wordpress.org. The code passes WPCS and Plugin Check with no errors.

Next step: publish 1.5 to WordPress.org through SVN. Before that, decide who installs the svn client and whether to add an Upgrade Notice. No blockers.

## Publishing 1.5 to WordPress.org (pending)

State of the SVN repository (https://plugins.svn.wordpress.org/quevedo/) on 2026-10-13:

- `trunk/` is at 1.4 and carries development files that reach users: `README.md`, `phpcs.xml` and `assets/` (banners and icons).
- `tags/`: 1.0, 1.1, 1.3 and 1.4. The root `assets/` folder has the banners and icons for the plugin page.
- This computer only has TortoiseSVN, without the command-line client (`svn.exe`).

Agreed plan:

1. Install the svn client (the "command line client tools" option of TortoiseSVN, or SlikSVN with winget). Still to decide whether Nilo or Claude installs it.
2. Decide whether to add `== Upgrade Notice ==` to `readme.txt` because of the jump to PHP 8.2. If it is added, it must be done before step 4, and the v1.5 tag would have to be moved or become a 1.5.1.
3. Working copy outside the repo (for example `D:\svn\quevedo`), with only `trunk/` and `assets/`.
4. Replace `trunk/` with the contents of `git archive v1.5`, mark additions and deletions with `svn status`, and copy `trunk/` to `tags/1.5` with `svn cp`, in the same commit.
5. Compare the root `assets/` with the repo's `assets/`; touch it only if they differ.
6. Show Nilo the `svn status` and `svn diff` before the commit. Nilo makes the commit, with the SVN password of his WordPress.org account.
7. Afterwards, download the zip from wordpress.org and compare it with `git archive v1.5`, and check the plugin page (version 1.5, Requires PHP 8.2).

## Test environment

- Studio site at `C:\Users\manolito\Studio\quevedo` (http://quevedo.local/, admin / password), in Spanish, with the plugin linked from the repo (junction to `D:\repos\quevedo`) and Plugin Check installed. It is stopped; start it with `studio start --path "C:\Users\manolito\Studio\quevedo" --skip-browser` or from the Studio app.
- For Playground: `blueprint.json` at the repo root. Port 9400 may be taken by another project: use `--port 9401` together with `--site-url`.

## Log

Newest entries first. One per work session, brief.

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
