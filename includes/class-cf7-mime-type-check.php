<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://hmumarkhan.com/
 * @since      1.0.0
 *
 * @package    Cf7_Mime_Type_Check
 * @subpackage Cf7_Mime_Type_Check/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cf7_Mime_Type_Check
 * @subpackage Cf7_Mime_Type_Check/includes
 * @author     Umar Khan <hmumarkhan@gmail.com>
 */
class Cf7_Mime_Type_Check {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cf7_Mime_Type_Check_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CF7_MIME_TYPE_CHECK_VERSION' ) ) {
			$this->version = CF7_MIME_TYPE_CHECK_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'cf7-mime-type-check';

		$this->load_dependencies();
		$this->define_cf7_filters();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Cf7_Mime_Type_Check_Loader. Orchestrates the hooks of the plugin.
	 * - Cf7_Mime_Type_Check_i18n. Defines internationalization functionality.
	 * - Cf7_Mime_Type_Check_Admin. Defines all hooks for the admin area.
	 * - Cf7_Mime_Type_Check_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cf7-mime-type-check-loader.php';

		$this->loader = new Cf7_Mime_Type_Check_Loader();

		/**
		 * The class responsible for the main actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cf7-mime-type-check-actions.php';

		$this->actions = new Cf7_Mime_Type_Check_Actions($this->plugin_name, $this->version);

		/**
		 * The file is responsible for loading helpers of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __FILE__ ) . 'cf7-mime-type-helpers.php';

	}

	/**
	 * Register all of the filters used in plugin for CF7 custom file validation
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_cf7_filters() {

		$plugin_public = new Cf7_Mime_Type_Check_Actions( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'wpcf7_validate_file*', $plugin_public, 'cf7_custom_file_validation' , 1, 2);
		$this->loader->add_filter( 'wpcf7_validate_file', $plugin_public, 'cf7_custom_file_validation', 1, 2 );
		$this->loader->add_filter( 'wpcf7_posted_data', $plugin_public, 'cf7_custom_posted_data' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Cf7_Mime_Type_Check_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
