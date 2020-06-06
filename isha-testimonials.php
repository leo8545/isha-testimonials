<?php
/**
 * Isha Testimonials
 * 
 * @package		IshaTestimonials
 * @author		Sharjeel Ahmad
 * @copyright	2020 Sharjeel Ahmad
 * @license		GPL-2.0
 * 
 * Plugin Name: Isha Testimonials
 * Description: A testimonial carousal. Display anywhere via shortcode [isha_testimonials]. Optional attribute: cats (ids of testimonial categories)
 * Version: 	1.0.0
 * Author: 		Sharjeel Ahmad
 * Author URI: 	https://github.com/leo8545
 * Text Domain: ishat
 * License:     GPL v2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Constants
define('ISHA_TEST_URI', plugin_dir_url(__FILE__)); 	// Plugin uri
define('ISHA_TEST_DIR', plugin_dir_path(__FILE__)); // Plugin dir
define('ISHA_TEST_VERSION', '1.0.0'); 				// Plugin version

/**
 * Main class for the plugin
 * @since 1.0.0
 */
final class Isha_Testimonials
{
	public function __construct()
	{
		register_activation_hook(__FILE__, [$this, 'activate']);
		register_deactivation_hook(__FILE__, [$this, 'deactivate']);

		$this->load_dep();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Activator on plugin activation
	 *
	 * @return void
	 */
	public function activate()
	{
		update_option('rewrite_rules', '');
	}

	/**
	 * Deactivator on plugin activation
	 *
	 * @return void
	 */
	public function deactivate() 
	{}

	/**
	 * Load dependencies
	 * 
	 * Includes files
	 *
	 * @return void
	 */
	public function load_dep()
	{
		require ISHA_TEST_DIR . '/admin/class-isha-test-admin.php';
		require ISHA_TEST_DIR . '/public/class-isha-test-public.php';
	}

	/**
	 * Defines all admin side hooks
	 *
	 * @return void
	 */
	public function define_admin_hooks()
	{
		$admin = new Isha_Test_Admin;
		add_action('init', [$admin, 'register_post_types']);
		add_action('init', [$admin, 'register_taxonomies'], 0);
		add_action('add_meta_boxes', [$admin, 'add_metaboxes']);
		add_action('save_post', [$admin, 'save_metaboxes']);
		add_filter('manage_isha_testimonials_posts_columns', [$admin, 'manage_testimonials_column'], 10, 1);
		add_action('manage_isha_testimonials_posts_custom_column', [$admin, 'manage_testimonials_custom_column'], 10, 2);

		add_action('plugins_loaded', [$this, 'set_locale']);
	}

	/**
	 * Defines all public side hooks
	 *
	 * @return void
	 */
	public function define_public_hooks()
	{
		$public = new Isha_Test_Public;
		add_action('wp_enqueue_scripts', [$public, 'enqueue_styles']);
		add_action('wp_enqueue_scripts', [$public, 'enqueue_scripts']);
		add_shortcode('isha_testimonials', [$public, 'shortcode_callback']);
	}

	/**
	 * Set locale
	 *
	 * @return void
	 */
	public function set_locale()
	{
		load_plugin_textdomain('ishat', false, ISHA_TEST_DIR . '/languages/');
	}
}

new Isha_Testimonials;