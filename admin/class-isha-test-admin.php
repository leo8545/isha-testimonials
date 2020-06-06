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

	public static function enqueue_styles()
	{
		$dir = ISHA_TEST_URI . '/admin/assets/css/';
		wp_enqueue_style('ishat_admin_style', $dir . 'ishat_admin_style.min.css', [], ISHA_TEST_VERSION );
	}

	/**
	 * Register post types: isha_testimonials
	 *
	 * @return void
	 */
	public static function register_post_types()
	{
		$labels = [
			'name'                  => _x( 'Isha Testimonials', 'Post type general name', 'ishat' ),
			'singular_name'         => _x( 'Isha Testimonial', 'Post type singular name', 'ishat' ),
			'menu_name'             => _x( 'Isha Testimonials', 'Admin Menu text', 'ishat' ),
			'name_admin_bar'        => _x( 'Isha Testimonial', 'Add New on Toolbar', 'ishat' ),
			'add_new'               => __( 'Add New', 'ishat' ),
			'add_new_item'          => __( 'Add New Isha Testimonial', 'ishat' ),
			'new_item'              => __( 'New Isha Testimonial', 'ishat' ),
			'edit_item'             => __( 'Edit Isha Testimonial', 'ishat' ),
			'view_item'             => __( 'View Isha Testimonial', 'ishat' ),
			'all_items'             => __( 'All Isha Testimonials', 'ishat' ),
			'search_items'          => __( 'Search Isha Testimonials', 'ishat' ),
			'parent_item_colon'     => __( 'Parent Isha Testimonials:', 'ishat' ),
			'not_found'             => __( 'No Isha Testimonials found.', 'ishat' ),
			'not_found_in_trash'    => __( 'No Isha Testimonials found in Trash.', 'ishat' ),
			'featured_image'        => _x( 'Isha Testimonial Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'ishat' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'ishat' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'ishat' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'ishat' ),
			'archives'              => _x( 'Isha Testimonial archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'ishat' ),
			'insert_into_item'      => _x( 'Insert into Isha Testimonial', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'ishat' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this Isha Testimonial', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'ishat' ),
			'filter_items_list'     => _x( 'Filter Isha Testimonials list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'ishat' ),
			'items_list_navigation' => _x( 'Isha Testimonials list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'ishat' ),
			'items_list'            => _x( 'Isha Testimonials list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'ishat' ),
		];

		$args = [
			'labels'                => 		$labels,
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
		<table class='ishat-table'>
			<tbody>
				<tr class="ishat-form_field">
					<td>
						<label for="ishat_author"><?php _e('Author Name', 'ishat') ?></label>
					</td>
					<td>
						<input type="text" name="ishat[author]" value="<?php echo $ishat['author'] ?? ""; ?>" id="ishat_author">
					</td>
				</tr>
				<tr class="ishat-form_field">
					<td>
						<label for="ishat_author_meta"><?php _e('Author Meta', 'ishat') ?></label>
					</td>
					<td>
						<input type="text" name="ishat[author_meta]" value="<?php echo $ishat['author_meta'] ?? ""; ?>" id="ishat_author_meta" >
						<span class="description"><?php _e('Description to be shown under author name.', 'ishat') ?></span>
					</td>
				</tr>
				<tr class="ishat-form_field">
					<td>
						<label for="ishat_rating"><?php _e('Ratings', 'ishat') ?></label>
					</td>
					<td>
						<input type="text" name="ishat[rating]" value="<?php echo $ishat['rating'] ?? ""; ?>" id="ishat_rating">
						<span class="description"><?php _e('Number of stars to show. Min: 1, Max: 5', 'ishat') ?></span>
					</td>
				</tr>
			</tbody>
		</table>
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

	/**
	 * Embed new columns to testimonials
	 *
	 * @param array $columns
	 * @return array $new_columns
	 */
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

	/**
	 * Populate new custom columns
	 *
	 * @param string $column
	 * @param integer $post_id
	 * @return void
	 */
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