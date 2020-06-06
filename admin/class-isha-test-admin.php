<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for admin side
 * @since 1.0.0
 */
class Isha_Test_Admin
{
	/**
	 * Register post types: isha_testimonials
	 *
	 * @return void
	 */
	public static function register_post_types()
	{
		$args = [
			'labels'				=> 		['name' => 'Isha Testimonials'],
			'public'             	=> 		true,
			'publicly_queryable' 	=> 		true,
			'show_ui'            	=> 		true,
			'show_in_menu'       	=> 		true,
			'query_var'          	=> 		true,
			'rewrite'            	=> 		['slug' => 'isha_testimonials'],
			'capability_type'    	=> 		'post',
			'has_archive'        	=> 		true,
			'hierarchical'       	=> 		false,
			'menu_position'      	=> 		null,
			'supports'           	=> 		[ 'title', 'editor', 'thumbnail' ],
		];

		register_post_type('isha_testimonials', $args);
	}

	/**
	 * Register taxonomies: isha_testimonials_cat
	 *
	 * @return void
	 */
	public static function register_taxonomies()
	{
		register_taxonomy('isha_testimonial_cat', 'isha_testimonials', [
			'label'        => __( 'Categories', 'ishat' ),
			'rewrite'      => ['slug' => 'isha_testimonial_cat'],
			'hierarchical' => true
		]);
	}

	/**
	 * Adds metabox to isha_testimonials screen
	 *
	 * @return void
	 */
	public static function add_metaboxes()
	{
		add_meta_box(
			'ishat_testimonial_author',
			__( 'Testimonial Meta', 'ishat' ),
			[self::class, 'ishat_testimonial_author_callback'],
			'isha_testimonials'
		);
	}

	/**
	 * Callback function of metabox: ishat_testimonials_author
	 *
	 * @param WP_POST $post
	 * @return void
	 */
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

	/**
	 * Save metaboxes fields
	 *
	 * @param integer $post_id
	 * @return void
	 */
	public static function save_metaboxes($post_id)
	{
		if(array_key_exists('ishat', $_POST)) {
			update_post_meta($post_id, 'ishat', $_POST['ishat']);
		}
	}

	public static function manage_testimonials_column($columns)
	{
		$new_columns = [
			'cb' => $columns['cb'],
			'title' => $columns['title'],
			'isha_content' => 'Content',
			'isha_author' => 'Author',
			'date' => $columns['date']
		];
		return $new_columns;
	}

	public static function manage_testimonials_custom_column($column, $post_id)
	{
		if( $column == 'isha_author' ) {
			$ishat = get_post_meta($post_id, 'ishat', true);
			if(@$ishat) {
				echo $ishat['author'];
			}
		}

		if( $column == 'isha_content' ) {
			$isha_post = get_post($post_id);
			if($isha_post instanceof WP_Post) {
				echo substr($isha_post->post_content, 0, 20) . '...';
			}
		}
	}
}