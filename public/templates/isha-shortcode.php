<?php

/**
 * Template file for shortcode: js_testimonials
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="ishat_wrapper">
	<?php do_action( 'isha_testimonials_before_list_wrapper' ) ?>
	<div class="ishat_list_wrapper">
		<?php foreach($testimonials as $t_cat): ?>
				<?php foreach($t_cat as $test): $test_meta = get_post_meta($test->ID, 'ishat', true); ?>
				<?php do_action( 'isha_testimonials_before_list_item' ) ?>
				<div class="ishat_list_item ishat_<?php echo $test->ID ?>">
					<div class="ishat_test_content">"<?php echo $test->post_content; ?>"</div>
					<div class="ishat_test_author"><?php echo $test_meta['author']; ?></div>
					<?php if(@$test_meta['author_meta'] && !empty($test_meta['author_meta'])): ?>
						<div class="ishat_test_author_meta"><?php _e($test_meta['author_meta'], 'ishat') ?></div>
					<?php endif; ?>
				</div>
				<?php do_action( 'isha_testimonials_after_list_item' )  ?>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
	<?php do_action( 'isha_testimonials_before_list_wrapper' ) ?>
</div>