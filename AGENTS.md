# Repository Guidelines

## Project Structure & Module Organization
Source code lives under `src/`, with `ComposerPlugin.php` bootstrapping the Composer integration and the `Commands/` directory holding the WP-CLI subcommands (`MakePotCommand`, `MakeJsonCommand`, etc.). Shared helpers such as `ShellRunner.php` and `I18nConfig.php` sit at the root of `src/` for reuse. Tests live in `tests/Commands` and mirror the command class names. Composer metadata (`composer.json`, `phpstan.neon.dist`, `phpunit.xml.dist`) resides at the project root; avoid editing `vendor/` manually.

## Build, Test, and Development Commands
Run `composer install` after cloning to pull dependencies and register the plugin. Use `composer qa` for the quick pre-flight check (PHPCS with WPCS ruleset plus PHPStan level 10). Execute `composer tests` for the PHPUnit suite, and `composer tests:coverage` when you need HTML coverage output in `tests/coverage/`. Fix formatting automatically with `composer cs:fix`.

## Coding Style & Naming Conventions
We target PHP 7.4+ and follow PSR-4 autoloading (`lloc\ComposerI18nScripts\` namespace). Adopt the WordPress Coding Standards with four-space indentation, snake_case function names when calling WP APIs, and StudlyCase class names that end with `Command` for WP-CLI handlers. Mirror class names in file names, and keep configuration arrays ordered consistently to aid PHPStan. Before committing, run `composer cs` to confirm a clean lint baseline.

## Testing Guidelines
Cover new functionality with PHPUnit tests under `tests/Commands`, using the `*Test` suffix. When introducing a command or helper, add the companion test class and describe edge cases. Prefer data providers for repetitive scenarios and assert exit codes plus generated file paths. Run `composer tests` before pushing; if you alter CLI output or file generation, assert on the rendered strings or fixtures. Keep the coverage directory out of version control.

## Commit & Pull Request Guidelines
Commit messages are short, present-tense imperatives (`Add MakePot command`, `Raise PHPStan level`). Squash noisy fix-ups locally. Each pull request should include a concise summary, linked GitHub issues (`Fixes #123`), notable commands you ran, and screenshots or sample output when altering CLI behaviour. Mention whether documentation in `README.md` or this guide needs updates.

## Localization Workflow Tips
Command classes convert translation templates into multiple formats; leverage existing helpers (`ShellRunner`) instead of spawning custom shell logic. When adding options, document them in the command’s PHPDoc and update related tests to cover both WP-CLI arguments and generated artifacts. Validate that generated `.pot` and `.json` files respect WordPress locale conventions to keep downstream usage smooth.
