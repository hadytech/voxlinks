<?php 

/**
 * Range Value Customizer Control
 * 
 * Class ReviewX_Customizer_Range_Value_Control
 *
 * @since 1.0.0
 */
class Crowdfundly_Range_Value_Control extends WP_Customize_Control {
	public $type = 'crowdfundly-range-value';
	
	/**
	 * Enqueue scripts/styles for custom range contorl.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script(
			'crowdfundly-customizer-range-value-control',
			CROWDFUNDLY_URL . 'admin/customizer/assets/js/customizer-range-value-control.js',
			array( 'jquery' ),
			CROWDFUNDLY_VERSION,
			true
		);

		wp_enqueue_style( 
			'crowdfundly-customizer-range-value-control', 
			CROWDFUNDLY_URL . 'admin/customizer/assets/css/customizer-range-value-control.css',
			array(),
			CROWDFUNDLY_VERSION . time()
		);
	}

	/**
	 * Render the control's content.
	 *
	 * @version 1.0.0
	 * 
	 */
	public function render_content() {
		?>
		<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="crowdfundly-customizer-reset-wrap">
			<a 
			href="#" 
			title="<?php echo esc_html__('Reset', 'crowdfundly') ?>" 
			class="crowdfundly-customizer-reset <?php echo esc_attr( $this->type ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="20px">
					<path d="M 25 2 C 12.321124 2 2 12.321124 2 25 C 2 37.678876 12.321124 48 25 48 C 37.678876 48 48 37.678876 48 25 A 2.0002 2.0002 0 1 0 44 25 C 44 35.517124 35.517124 44 25 44 C 14.482876 44 6 35.517124 6 25 C 6 14.482876 14.482876 6 25 6 C 30.475799 6 35.391893 8.3080175 38.855469 12 L 35 12 A 2.0002 2.0002 0 1 0 35 16 L 46 16 L 46 5 A 2.0002 2.0002 0 0 0 43.970703 2.9726562 A 2.0002 2.0002 0 0 0 42 5 L 42 9.5253906 C 37.79052 4.9067015 31.727675 2 25 2 z"></path>
				</svg>
			</a>
			</div>
		<?php endif; ?>
		<div class="crowdfundly-range-slider" data-default-val="<?php echo esc_attr( $this->settings[ 'default' ]->value() ); ?>" style="width:100%; display:flex;flex-direction: row;justify-content: flex-start;">
			<span class="crowdfundly-range-slider-inner-wrapper"  style="width:100%; flex: 1 0 0; vertical-align: middle;">
				<input class="crowdfundly-range-slider__range" type="range" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->input_attrs(); $this->link(); ?>>
				<span class="crowdfundly-range-slider__value" style="position: absolute;">0</span>
			</span>
		</div>
		<?php if ( ! empty( $this->description ) ) : ?>
		<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php endif; ?>
		<?php
	}
}
