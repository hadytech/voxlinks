<?php
class Crowdfundly_Customizer_Switcher_Control extends WP_Customize_Control {
	public $type = 'crowdfundly-switcher';

	public function enqueue() {
		wp_enqueue_script( 'crowdfundly-customizer-switcher-control',
			CROWDFUNDLY_URL . 'admin/customizer/assets/js/switcher.js',
			array( 'jquery' ),
			rand(),
			true
		);
		wp_enqueue_style( 'crowdfundly-customizer-switcher-control-css', 
			CROWDFUNDLY_URL . 'admin/customizer/assets/css/switcher.css',
			array(),
			rand()
		);

		$css = '
			.disabled-control-title {
				color: #a0a5aa;
			}
			input[type=checkbox].tgl-light:checked + .tgl-btn {
				background: #37de89;
			}
			input[type=checkbox].tgl-light + .tgl-btn {
			  background: #a0a5aa;
			}
			input[type=checkbox].tgl-light + .tgl-btn:after {
			  background: #f7f7f7;
			}

			input[type=checkbox].tgl-ios:checked + .tgl-btn {
			  background: #37de89;
			}

			input[type=checkbox].tgl-flat:checked + .tgl-btn {
			  border: 4px solid #37de89;
			}
			input[type=checkbox].tgl-flat:checked + .tgl-btn:after {
			  background: #37de89;
			}

		';
		wp_add_inline_style( 'pure-css-toggle-buttons' , $css );
	}

	public function render_content() {
		?>
		<label>
			<div style="display:flex;flex-direction: row;justify-content: flex-start;">
				<span class="customize-control-title" style="flex: 2 0 0; vertical-align: middle;"><?php echo esc_html( $this->label ); ?></span>
				<input id="cb<?php echo $this->instance_number ?>" type="checkbox" data-default-val="<?php echo $this->settings[ 'default' ]->value(); ?>" class="tgl tgl-<?php echo $this->type?> <?php echo $this->type?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
				<label for="cb<?php echo $this->instance_number ?>" class="tgl-btn"></label>
			</div>
			<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
		</label>
		<?php
	}
}
