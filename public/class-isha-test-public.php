<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Isha_Test_Public
{
	public static function enqueue_styles()
	{
		$dir = ISHA_TEST_URI . '/public/assets/';
		wp_enqueue_style('leo_test_style', $dir . 'css/isha-test-style.min.css');
	}

	public static function enqueue_scripts()
	{
		$dir = ISHA_TEST_URI . '/public/assets/';
		wp_enqueue_script('leo_test_script', $dir . 'js/isha-test-script.js', ['jquery']);
		wp_enqueue_script('slick', $dir . 'js/slick.min.js', ['jquery']);
	}

	public static function shortcode_callback($atts)
	{
		$atts = shortcode_atts([
			'cats' => ""
		], $atts);

		$testimonials = [];

		if( strlen($atts['cats']) !== 0 ) {
			$t_cats = explode(',', $atts['cats']);
			foreach($t_cats as $cat) {
				$testimonials[$cat] = self::get_testimonials_by_cat($cat);
			}
		} else {
			$testimonials[] = self::get_testimonials();
		}

		ob_start();
		require ISHA_TEST_DIR . '/public/templates/isha-shortcode.php';
		$output = ob_get_clean();
		return $output;
	}

	public static function get_testimonials_by_cat($cat_id)
	{
		return get_posts([
			'posts_per_page' => -1,
			'post_type' => 'isha_testimonials',
			'tax_query' => [[
				'taxonomy' => 'isha_testimonial_cat',
				'field' => 'term_id',
				'terms' => $cat_id
			]]
		]);
	}

	public static function get_testimonials()
	{
		return get_posts([
			'posts_per_page' => -1,
			'post_type' => 'isha_testimonials'
		]);
	}
}