<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wolfeo.me/public
 * @since      1.0.0
 *
 * @package    Wolfeo_Pushy
 * @subpackage Wolfeo_Pushy/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wolfeo_Pushy
 * @subpackage Wolfeo_Pushy/public
 * @author     Wolfeo <dev@wolfeo.me>
 */
class Wolfeo_Pushy_Public {

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
		 * defined in Wolfeo_Pushy_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wolfeo_Pushy_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wolfeo-pushy-public.css', array(), $this->version, 'all' );

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
		 * defined in Wolfeo_Pushy_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wolfeo_Pushy_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$js_id = get_option( 'wolf_pushy_id' );
		$pushy_js = "https://www.wolfeo.me/public/assets/$js_id.js?";
		$id_list = esc_attr( (get_option( 'wolf_id_list' ) ) );
        $id_match = explode(",", $id_list);
        if (is_single( $id_match ) || is_page( $id_match )) {
			wp_enqueue_script( $this->plugin_name, $pushy_js . mt_rand() , array( 'jquery' ), $this->version, false );
		}
	}

}
