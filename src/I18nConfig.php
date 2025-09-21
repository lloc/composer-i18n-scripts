<?php
/**
 * Configuration handler for i18n scripts.
 *
 * @package lloc\ComposerI18nScripts
 */

declare( strict_types=1 );

namespace lloc\ComposerI18nScripts;

use Symfony\Component\Yaml\Yaml;
use Composer\Composer;

/**
 * I18nConfig class to handle configuration settings.
 */
class I18nConfig {

	public const FILENAME = '.i18n-config.yaml';

	public const DEFAULTS = array(
		'source'         => '.',
		'languages_path' => './languages',
		'domain'         => '',
	);

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
		$this->source         = $source ?? self::DEFAULTS['source'];
		$this->languages_path = $languages_path ?? self::DEFAULTS['languages_path'];
		$this->domain         = $domain ?? self::DEFAULTS['domain'];
	}

	/**
	 * Creates an instance of I18nConfig from a YAML file.
	 *
	 * @param string $file_name The path to the YAML configuration file.
	 * @return self An instance of I18nConfig.
	 */
	public static function from_file( string $file_name ): self {
		if ( ! file_exists( $file_name ) ) {
			return new self();
		}

		try {
			$yaml = Yaml::parseFile( $file_name );
		} catch ( \Throwable $e ) {
			return new self();
		}

		return new self(
			$yaml['source'] ?? null,
			$yaml['languages'] ?? null,
			$yaml['domain'] ?? null
		);
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
		return $this->languages_path;
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
	public function destination(): ?string {
		$domain = $this->domain();

		if ( empty( $domain ) ) {
			print_r( $this );
			return null;
		}

		return rtrim( $this->languages_path(), '/' ) . '/' . $domain . '.pot';
	}

	/**
	 * Loads the configuration from the default file.
	 *
	 * @param Composer $composer The Composer instance to determine the root directory.
	 * @return self An instance of I18nConfig.
	 */
	public static function from_composer( Composer $composer ): self {
		$root_dir = dirname( $composer->getConfig()->get( 'vendor-dir' ) );

		return self::from_file( $root_dir . '/' . self::FILENAME );
	}
}
