<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
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
 * @package    uml_define_frame_options
 * @subpackage uml_define_frame_options/includes
 * @author     Abel Facenda Carrasco <email@example.com>
 */
class Uml_Define_Frame_Options {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Uml_Define_Frame_Options_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->plugin_name = 'Define X-Frame Options';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-umlDefineFrameOptions-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-umlDefineFrameOptions-i18N.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-uml_define_frame_options-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-umlDefineFrameOptions-public.php';

		$this->loader = new Uml_Define_Frame_Options_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Uml_Define_Frame_Options_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Uml_Define_Frame_Options_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'init', $plugin_admin, 'uml_set_frame_options_header', -41);

        $this->loader->add_action( 'admin_menu', $plugin_admin, 'show_in_admin_menu' );

        $this->loader->add_action( 'wp_ajax_save_option', $plugin_admin, 'save_option' );
        $this->loader->add_action( 'wp_ajax_get_info', $plugin_admin, 'get_info' );
	}



	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Uml_Define_Frame_Options_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'init', $plugin_public, 'uml_set_frame_options_header', -41 );

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
	 * @return    Uml_Define_Frame_Options_Loader    Orchestrates the hooks of the plugin.
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

	function setFrameOptions (){
        global $wpdb;
        echo 'aaaaaaaaaaa';
//        $query = $wpdb->get_results( 'SELECT * FROM `uml_define_frame_options`');
//        if ($query){
//            $option = $query[0]->option;
//
//            if ($option) {
//                $is_ie = false;
//
//                if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false)) {
//                    $is_ie = true;
//                }
//
//                if (stripos($query[0]->allow_from, "self") !== false) {
//                    $setting = str_replace("self", "'self'", $query[0]->allow_from);
//                }
//
//                if (strpos($option, 'ALLOW-FROM') !== false) {
//                    if (!$is_ie) {
//                        $trusted_site_url = $option;
//                    }else{
//                        $trusted_site_url = 'ALLOW-FROM '.$setting;
//                    }
//                } elseif (strpos($option, 'SAMEORIGIN') !== false) {
//                    if (!$is_ie){
//                        $trusted_site_url = " 'self'";
//                    }else{
//                        $trusted_site_url = $setting;
//                    }
//                } else {
//                    if (!$is_ie) {
//                        $trusted_site_url = " 'none'";
//                    }else{
//                        $trusted_site_url = " DENY";
//                    }
//                }
//
//                if ($is_ie) {
//                    $trusted_site_url = $query[0]->allow_from;
//                    $request_host = $_SERVER['HTTP_HOST'];
//                    $protocol = 'http://';
//                    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
//                        $protocol = 'https://';
//                    }
//                    if (strpos($setting, $request_host) !== false) {
//                        $trusted_site_url = 'ALLOW-FROM '.$protocol.$request_host;
//                    }
//                    if (strpos($trusted_site_url, 'self') !== false) {
//                        $trusted_site_url = 'SAMEORIGIN';
//                    }
//                    @header('X-Frame-Options: ' . $trusted_site_url);
//                } else {
//                    $trusted_site_url = $setting;
//                    @header('Content-Security-Policy: frame-ancestors ' . $trusted_site_url);
//                }
//            }
//        }
    }

}
