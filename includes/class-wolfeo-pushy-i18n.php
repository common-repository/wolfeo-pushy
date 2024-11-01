<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wolfeo.me/public
 * @since      1.0.0
 *
 * @package    Wolfeo_Pushy
 * @subpackage Wolfeo_Pushy/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wolfeo_Pushy
 * @subpackage Wolfeo_Pushy/includes
 * @author     Wolfeo <dev@wolfeo.me>
 */
class Wolfeo_Pushy_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wolfeo-pushy',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
