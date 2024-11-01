<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wolfeo.me/public
 * @since      1.0.0
 *
 * @package    Wolfeo_Pushy
 * @subpackage Wolfeo_Pushy/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wolfeo_Pushy
 * @subpackage Wolfeo_Pushy/admin
 * @author     Wolfeo <dev@wolfeo.me>
 */
class Wolfeo_Pushy_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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
    	$current_page = get_current_screen()->base;
    	if($current_page == 'settings_page_wolfeo-pushy') {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wolfeo-pushy-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'multiselect_css', plugin_dir_url( __FILE__ ) . 'css/jquery.multiselect.css', array(), $this->version, 'all' );

		} else { 

        	wp_dequeue_style($this->plugin_name);
        	wp_dequeue_style('multiselect_css');

    	}

	}

	/**
	 * Register the JavaScript for the admin area.
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

    	$current_page = get_current_screen()->base;
    	if($current_page == 'settings_page_wolfeo-pushy') {

			wp_enqueue_script( 'multiselect_js', plugin_dir_url( __FILE__ ) . 'js/jquery.multiselect.js', array( 'jquery' ), $this->version, false );


    	} else { 

        	wp_dequeue_script('multiselect_js');

    	}
	}
}