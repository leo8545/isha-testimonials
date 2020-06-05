<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Isha_Test_Admin
{
	public static function register_post_types()
	{
		$args = [
			'labels' => ['name' => 'JS Testimonials'],
			'public'             	=> 		true,
			'publicly_queryable' 	=> 		true,
			'show_ui'            	=> 		true,
			'show_in_menu'       	=> 		true,
			'query_var'          	=> 		true,
			'rewrite'            	=> 		[ 'slug' => 'js_testimonials'],
			'capability_type'    	=> 		'post',
			'has_archive'        	=> 		true,
			'hierarchical'       	=> 		false,
			'menu_position'      	=> 		null,
			'supports'           	=> 		[ 'title', 'editor', 'thumbnail' ],
		];

		register_post_type('isha_testimonials', $args);
	}

	public static function register_taxonomies()
	{
		register_taxonomy('isha_testimonial_cat', 'isha_testimonials', [
			'label'        => __( 'Categories', 'ishat' ),
			'rewrite'      => ['slug' => 'isha_testimonial_cat'],
			'hierarchical' => true
		]);
	}

	public static function add_metaboxes()
	{
		add_meta_box(
			'ishat_testimonial_author',
			__( 'Testimonial Meta', 'ishat' ),
			[self::class, 'ishat_testimonial_author_callback'],
			'isha_testimonials'
		);
	}

	public static function ishat_testimonial_author_callback($post)
	{
		$ishat = get_post_meta($post->ID, 'ishat', true);
		?>
		<div class="ishat-form-field">
			<label for="ishat_author"><?php _e('Author Name', 'ishat') ?></label>
			<input type="text" name="ishat[author]" value="<?php echo $ishat['author'] ?? ""; ?>">
		</div>
		<div class="ishat-form-field">
			<label for="ishat_author_meta"><?php _e('Author Meta', 'ishat') ?></label>
			<input type="text" name="ishat[author_meta]" value="<?php echo $ishat['author_meta'] ?? ""; ?>" id="ishat_author_meta" >
		</div>
		<div class="ishat-form-field">
			<label for="ishat_rating"><?php _e('Ratings', 'ishat') ?></label>
			<input type="text" name="ishat[rating]" value="<?php echo $ishat['rating'] ?? ""; ?>" id="ishat_rating">
		</div>
		<?php
	}

	public static function save_metaboxes($post_id)
	{
		if(array_key_exists('ishat', $_POST)) {
			update_post_meta($post_id, 'ishat', $_POST['ishat']);
		}
	}
}