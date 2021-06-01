<?php

class Crowdfundly_Select_Control extends WP_Customize_Control {
	public $type = 'crowdfundly-select';

	public function render_content() {
		if( empty( $this->choices ) ) return;

        if( !empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif; ?>
        
		<select <?php $this->link(); ?> data-default-val="<?php echo esc_attr( $this->choices[0] ); ?>" <?php echo $this->input_attrs(); ?>>
			<?php
				foreach( $this->choices as $key => $label ) {
					echo '<option value="' . esc_attr( $key ) . '">' . $label . '</option>';
				}
			?>
		</select>
        <?php
	}

}
