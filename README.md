# Composer i18n Scripts

Automate the internationalization workflow of your WordPress plugin or theme by wiring WP-CLI translation tools into familiar Composer commands.

## Requirements
- PHP 7.4+ and Composer 2.6+ (Composer plugin API 2.6 is required)
- WP-CLI 2.12+ available on your `$PATH`
- A WordPress plugin or theme with `Text Domain` and `Domain Path` headers defined

## Installation
```bash
composer require --dev lloc/composer-i18n-scripts
```
Composer automatically registers the plugin; no manual bootstrap code is needed. Running `composer install` on the project will keep the plugin active for all contributors.

## Configuration
The plugin inspects your project root to infer settings:
- Themes: reads `style.css`
- Plugins: reads the main plugin file (matching the directory name or `index.php`)

Provide headers like the following so WP-CLI receives the right text domain and language directory:
```php
/*
Plugin Name: Sample Plugin
Text Domain: sample-plugin
Domain Path: /languages
*/
```
If no metadata is found, defaults are `Text Domain: messages` and `Domain Path: /languages`.

## Usage
Run the commands from the WordPress project root so that `wp` can load your environment.

| Command | Purpose |
| ------- | ------- |
| `composer i18n:make-pot` | Scan the source directory and generate `languages/<domain>.pot`. |
| `composer i18n:create-po <locale>` | Copy the `.pot` file to a locale-specific `.po` file (e.g. `de_DE`). |
| `composer i18n:update-po` | Merge the current `.pot` changes into every `.po` in `languages/`. |
| `composer i18n:make-mo` | Compile all `.po` files into `.mo` binaries. |
| `composer i18n:make-php` | Export `.po` translations into PHP array files for performance-sensitive setups. |
| `composer i18n:make-json` | Build JavaScript translation catalogs (`*.json`) without purging existing assets. |

Example workflow:
```bash
composer i18n:make-pot
composer i18n:update-po
composer i18n:make-json
composer i18n:make-mo
```

## Development
- `composer install` – install dependencies and register the plugin
- `composer qa` – PHPCS (WordPress Coding Standards) + PHPStan level 10
- `composer tests` – run PHPUnit suite under `tests/Commands`
- `composer tests:coverage` – generate HTML coverage in `tests/coverage/`
- `composer cs:fix` – automatically fix style violations

Refer to `AGENTS.md` for contributor conventions, coding standards, and pull request expectations.

## Troubleshooting
- **“Text domain is not set”**: ensure your plugin/theme headers declare `Text Domain` and `Domain Path`.
- **WP-CLI not found**: verify `wp` is installed globally or provide an absolute path (e.g. symlink `wp` into `/usr/local/bin`).
- **Translations not picking up new strings**: rerun `composer i18n:make-pot` before updating `.po` files so the template is up to date.
