<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Main class for public side
 * @since 1.0.0
 */
class Isha_Test_Public
{
	/**
	 * Enqueue public css files
	 *
	 * @return void
	 */
	public static function enqueue_styles()
	{
		$dir = ISHA_TEST_URI . '/public/assets/';
		wp_enqueue_style('leo_test_style', $dir . 'css/isha-test-style.min.css', [], ISHA_TEST_VERSION);
	}

	/**
	 * Enqueue public javascript files
	 *
	 * @return void
	 */
	public static function enqueue_scripts()
	{
		$dir = ISHA_TEST_URI . '/public/assets/';
		wp_enqueue_script('leo_test_script', $dir . 'js/isha-test-script.js', ['jquery'], ISHA_TEST_VERSION);
		wp_enqueue_script('slick', $dir . 'js/slick.min.js', ['jquery'], ISHA_TEST_VERSION);
	}

	/**
	 * Callback function for shortcode
	 *
	 * @param array $atts Shortcode attributes
	 * @return string Output
	 */
	public static function shortcode_callback($atts)
	{
		$atts = shortcode_atts([
			'cats' => "",
			'ids' => ""
		], $atts);

		$testimonials = [];

		// If attribute:cats is provided
		if( strlen($atts['cats']) !== 0 ) {
			$t_cats = explode(',', $atts['cats']);
			foreach($t_cats as $cat) {
				$testimonials[$cat] = self::get_testimonials('category', $cat);
			}
		} else if ( strlen($atts['ids'] !== 0) ) {
			// Get testimonials by testimonials ids
			$t_ids = explode(',', $atts['ids']);
			$testimonials[] = self::get_testimonials('ids', $t_ids);
		} else {
			// Get all testimonials
			$testimonials[] = self::get_testimonials();
		}

		ob_start();
		require ISHA_TEST_DIR . '/public/templates/isha-shortcode.php';
		$output = ob_get_clean();
		return $output;
	}

	/**
	 * Get testimonials
	 * 
	 * If no argument is supplied, then it gets all testimonials
	 *
	 * @param string $field Field name (Available: ids, category)
	 * @param mixed $value Value of the field
	 * 
	 * @return array Array of testimonials
	 */
	public static function get_testimonials(string $field = '', $value = null)
	{
		$args = [
			'posts_per_page' => -1,
			'post_type' => 'isha_testimonials'
		];

		if( $field == 'category' ) {
			$args['tax_query'] = [[
				'taxonomy' => 'isha_testimonial_cat',
				'field' => 'term_id',
				'terms' => $value
			]];
		}

		if( $field == 'ids' ) {
			$args['include'] = $value;
		}

		return get_posts($args);
	}
}