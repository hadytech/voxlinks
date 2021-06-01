<?php

class CrowdFundly_Heading_Control extends WP_Customize_Control{
	public $type = 'separator';
	public function render_content(){
		?>
		<label <?php $this->input_attrs(); ?>>
			<h4 class="crowdfundly-customize-control-separator">
				<?php echo esc_html( $this->label ); ?>
			</h4>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
		</label>
		<?php
	}
}
