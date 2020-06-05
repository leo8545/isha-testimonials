<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="ishat_wrapper">
	<div class="ishat_list_wrapper">
		<?php foreach($testimonials as $t_cat): ?>
			<?php foreach($t_cat as $test): $test_meta = get_post_meta($test->ID, 'ishat', true); ?>
				<div class="ishat_list_item ishat_<?php echo $test->ID ?>">
					<div class="ishat_test_content">"<?php echo $test->post_content; ?>"</div>
					<div class="ishat_test_author"><?php echo $test_meta['author']; ?></div>
					<?php if(@$test_meta['author_meta'] && !empty($test_meta['author_meta'])): ?>
						<div class="ishat_test_author_meta"><?php _e($test_meta['author_meta'], 'ishat') ?></div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>
</div>