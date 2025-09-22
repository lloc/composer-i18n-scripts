<?php
/**
 * Configuration handler for i18n scripts.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts;

use Composer\Composer;

/**
 * I18nConfig class to handle configuration settings.
 */
class I18nConfig {

	public const DEFAULT_SOURCE         = '.';
	public const DEFAULT_LANGUAGES_PATH = 'languages';
	public const DEFAULT_DOMAIN         = 'messages';

	/**
	 * Source directory for scanning files.
	 *
	 * @var string
	 */
	private string $source;

	/**
	 * Languages directory path.
	 *
	 * @var string
	 */
	private string $languages_path;

	/**
	 * Text domain for translations.
	 *
	 * @var string
	 */
	private string $domain;

	/**
	 * Private constructor to enforce the use of the from_file method.
	 *
	 * @param string|null $source Source directory path or null for default value.
	 * @param string|null $languages_path Languages directory path or null for default value.
	 * @param string|null $domain Text domain or null for default value.
	 */
	private function __construct( ?string $source = null, ?string $languages_path = null, ?string $domain = null ) {
		$this->source         = $source ?? self::DEFAULT_SOURCE;
		$this->languages_path = $languages_path ?? self::DEFAULT_LANGUAGES_PATH;
		$this->domain         = $domain ?? self::DEFAULT_DOMAIN;
	}

	/**
	 * Gets the source directory.
	 *
	 * @return string The source directory.
	 */
	public function source(): string {
		return $this->source;
	}

	/**
	 * Gets the languages directory path.
	 *
	 * @return string The languages directory path.
	 */
	public function languages_path(): string {
		return trim( $this->languages_path, '/' );
	}

	/**
	 * Gets the text domain.
	 *
	 * @return string The text domain.
	 */
	public function domain(): string {
		return $this->domain;
	}

	/**
	 * Gets the destination path for the .pot file.
	 *
	 * @return string The destination path.
	 */
	public function destination(): string {
		return $this->languages_path() . DIRECTORY_SEPARATOR . $this->domain() . '.pot';
	}

	/**
	 * Gets the path for a specific language translation file.
	 *
	 * @param string $locale The language code (e.g., 'de_DE').
	 *
	 * @return string The path to the .po file for the specified language.
	 */
	public function translation( string $locale ): string {
		$code = preg_replace( '/[^\w]/', '', $locale );

		return $this->languages_path() . DIRECTORY_SEPARATOR . $this->domain() . '-' . $code . '.po';
	}

	/**
	 * Loads the configuration from the plugin or theme using composer.
	 *
	 * @param Composer $composer The Composer instance to determine the root directory.
	 * @return self An instance of I18nConfig.
	 */
	public static function from_composer( Composer $composer ): self {
		$root_dir = dirname( $composer->getConfig()->get( 'vendor-dir' ) );

		$file = $root_dir . '/style.css';
		if ( file_exists( $file ) ) {
			return self::from_header( $file );
		}

		$file = self::find_plugin_file( $root_dir );
		if ( $file && file_exists( $file ) ) {
			return self::from_header( $file );
		}

		return new self();
	}

	/**
	 * Loads the configuration from the header of a given file.
	 *
	 * @param string $file The file path to read the header from.
	 * @return self An instance of I18nConfig.
	 */
	public static function from_header( string $file ): self {
        // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- safe usage for local file
		$contents = file_get_contents( $file );

		if ( ! $contents ) {
			return new self();
		}

		preg_match( '/^.*Text Domain:\s*(.+)$/mi', $contents, $domain_match );
		preg_match( '/^.*Domain Path:\s*(.+)$/mi', $contents, $path_match );

		$domain = isset( $domain_match[1] ) ? trim( $domain_match[1] ) : null;
		$path   = isset( $path_match[1] ) ? trim( $path_match[1] ) : null;

		return new self( null, $path, $domain );
	}

	/**
	 * Attempts to find the main plugin file in the given directory.
	 *
	 * @param string $dir The directory to search for the plugin file.
	 * @return string|null The path to the plugin file if found, null otherwise.
	 */
	private static function find_plugin_file( string $dir ): ?string {
		$basename = basename( $dir );

		$file = $dir . DIRECTORY_SEPARATOR . $basename . '.php';
		if ( is_file( $file ) ) {
			return $file;
		}

		$file = $dir . DIRECTORY_SEPARATOR . 'index.php';
		if ( is_file( $file ) ) {
			return $file;
		}

		return null;
	}
}
