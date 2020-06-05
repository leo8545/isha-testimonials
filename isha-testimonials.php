<?php
/**
 * Plugin Name: Isha Testimonials
 * Author: Sharjeel Ahmad
 * Description: A testimonial carousal. Display anywhere via shortcode [js_testimonials]. Optional attribute: cats (ids of testimonial categories)
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('ISHA_TEST_URI', plugin_dir_url(__FILE__));
define('ISHA_TEST_DIR', plugin_dir_path(__FILE__));

final class Isha_Testimonials
{
	public function __construct()
	{
		$this->load_dep();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	public function load_dep()
	{
		require ISHA_TEST_DIR . '/admin/class-isha-test-admin.php';
		require ISHA_TEST_DIR . '/public/class-isha-test-public.php';
	}

	public function define_admin_hooks()
	{
		$admin = new Isha_Test_Admin;
		add_action('init', [$admin, 'register_post_types']);
		add_action('init', [$admin, 'register_taxonomies'], 0);
		add_action('add_meta_boxes', [$admin, 'add_metaboxes']);
		add_action('save_post', [$admin, 'save_metaboxes']);
	}

	public function define_public_hooks()
	{
		$public = new Isha_Test_Public;
		add_action('wp_enqueue_scripts', [$public, 'enqueue_styles']);
		add_action('wp_enqueue_scripts', [$public, 'enqueue_scripts']);
		add_shortcode('js_testimonials', [$public, 'shortcode_callback']);
	}
}

new Isha_Testimonials;