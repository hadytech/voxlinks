<?php

class Crowdfundly_Dimension_Control extends WP_Customize_Control {
	public $type = 'crowdfundly-dimension';

	public function render_content() {
		?>
		<div class="dimension-field">
			<input type="number" data-default-val="0" value="<?php echo esc_attr($this->value()); ?>" <?php $this->input_attrs(); $this->link(); ?>>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		</div>
		<?php
	}

	public static function four_horse_men($wp_customize, $section, $ids) {
		$wp_customize->add_setting( $ids[0], array(
			'default'       => '',
			'capability'    => 'edit_theme_options',
			'transport' => 'postMessage',
			'sanitize_callback' => 'crowdfundly_sanitize_integer'
		) );
		$wp_customize->add_control( new Crowdfundly_Dimension_Control( $wp_customize, $ids[0],
			array(
				'type'     => 'crowdfundly-dimension',
				'section'  => $section,
				'settings' => $ids[0],
				'label'    => __( 'Top', 'crowdfundly' ),
				'priority'   => 2,
				'input_attrs' => array(
					'class' => 'crowdfundly-dimension',
				),
			)
		) );
	
		$wp_customize->add_setting( $ids[1], array(
			'default'       => '',
			'capability'    => 'edit_theme_options',
			'transport' => 'postMessage',
			'sanitize_callback' => 'crowdfundly_sanitize_integer'
		) );
		$wp_customize->add_control( new Crowdfundly_Dimension_Control( $wp_customize, $ids[1],
			array(
				'type'     => 'crowdfundly-dimension',
				'section'  => $section,
				'settings' => $ids[1],
				'label'    => __( 'Right', 'crowdfundly' ),
				'priority'   => 2,
				'input_attrs' => array(
					'class' => 'crowdfundly-dimension',
				),
			)
		) );
	
		$wp_customize->add_setting( $ids[2], array(
			'default'       => '',
			'capability'    => 'edit_theme_options',
			'transport' => 'postMessage',
			'sanitize_callback' => 'crowdfundly_sanitize_integer'
		) );
		$wp_customize->add_control( new Crowdfundly_Dimension_Control( $wp_customize, $ids[2],
			array(
				'type'     => 'crowdfundly-dimension',
				'section'  => $section,
				'settings' => $ids[2],
				'label'    => __( 'Bottom', 'crowdfundly' ),
				'priority'   => 2,
				'input_attrs' => array(
					'class' => 'crowdfundly-dimension',
				),
			)
		) );
	
		$wp_customize->add_setting( $ids[3], array(
			'default'       => '',
			'capability'    => 'edit_theme_options',
			'transport' => 'postMessage',
			'sanitize_callback' => 'crowdfundly_sanitize_integer'
		) );
		$wp_customize->add_control( new Crowdfundly_Dimension_Control( $wp_customize, $ids[3],
			array(
				'type'     => 'crowdfundly-dimension',
				'section'  => $section,
				'settings' => $ids[3],
				'label'    => __( 'Left', 'crowdfundly' ),
				'priority'   => 2,
				'input_attrs' => array(
					'class' => 'crowdfundly-dimension',
				),
			)
		) );
	}
}
