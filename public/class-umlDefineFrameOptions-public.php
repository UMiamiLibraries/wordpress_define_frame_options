<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Uml_Define_Frame_Options_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}

    function uml_set_frame_options_header() {
        global $wpdb;
        $query = $wpdb->get_results( 'SELECT * FROM `uml_define_frame_options`');

        if ($query){
            $option = $query[0]->option;

            if ($option) {
                $is_ie = false;

                $trusted_site_url = $query[0]->allow_from;
                if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false)) {
                    $is_ie = true;
                }

                if (stripos($query[0]->allow_from, "self") !== false) {
                    $trusted_site_url = str_replace("self", "'self'", $query[0]->allow_from);
                }

                if (strpos($option, 'ALLOW-FROM') !== false) {
                    $trusted_site_url = "ALLOW-FROM ".$trusted_site_url;
                } elseif (strpos($option, 'SAMEORIGIN') !== false) {
                    if (!$is_ie){
                        $trusted_site_url = " 'self'";
                    }else{
                        $trusted_site_url = "SAMEORIGIN";
                    }
                } else {
                    if (!$is_ie) {
                        $trusted_site_url = " 'none'";
                    }else{
                        $trusted_site_url = " DENY";
                    }
                }
                if ($is_ie) {
                    if (isset($_SERVER['HTTP_REFERER'])){
                        $request_host = $_SERVER['HTTP_REFERER'];
                        $request_host=parse_url($request_host)["host"];
                    }else{
                        $request_host = $_SERVER['HTTP_HOST'];
                    }
                    $protocol = 'http://';
                    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
                        $protocol = 'https://';
                    }
                    if (strpos($trusted_site_url, $request_host) !== false) {
                        $trusted_site_url = 'ALLOW-FROM '.$protocol.$request_host;
                    }
                    if (strpos($trusted_site_url, 'self') !== false) {
                        $trusted_site_url = 'SAMEORIGIN';
                    }
                    @header('X-Frame-Options: ' . $trusted_site_url);
                } else {
                    if (strpos($option, 'ALLOW-FROM') !== false) {
                        $trusted_site_url = str_replace("ALLOW-FROM", "", $trusted_site_url);
                    }
                    @header('Content-Security-Policy: frame-ancestors ' . $trusted_site_url);
                }
            }
        }
    }

}
