<div class="wrap">
	<h2>
		<?php esc_html_e( 'All Reviews', 'reviewx' ); ?>
	</h2>
	<?php 
		wp_enqueue_script( 'admin-comments' );
		enqueue_comment_hotkeys_js();
	?>
	<?php $records->call_analytics_header(); ?>
	<?php $records->review_action_status(); ?>
	
	<form method="post">
		<?php
			if(! isset($records)) { return; }
			$records->process_bulk_action();
			$records->prepare_items();
			$records->search_box( $searchBoxText, $searchColumn );
			$records->views();
			$records->display();
		?>
	</form>
	<?php wp_comment_trashnotice(); ?>
</div>