<?php

/**
 * Number Customizer Control
 */
class Crowdfundly_Number_Control extends WP_Customize_Control {
	public $type = 'crowdfundly-number';

	public function render_content() {
		?>
		<div class="number-field">
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				
				<?php endif; ?>
				<input type="number" data-default-val="<?php echo $this->settings[ 'default' ]->value(); ?>" class="<?php echo $this->type ?>" value="<?php echo esc_attr($this->value()); ?>" <?php $this->input_attrs(); $this->link(); ?>>
				<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
		</div>
		<?php
	}
}
