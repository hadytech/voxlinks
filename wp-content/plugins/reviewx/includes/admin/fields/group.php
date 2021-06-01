<?php 
    if( isset( $field['fields'] ) ){
        $fields = WP_Opt_Wizard_Helper::sorter( $field['fields'], 'priority', 'ASC' );;
    } else {
        return;
    }

    $group_value = $value;
    $group_title = isset( $field['title'] ) ? $field['title'] : '';
    $parent_key = $key;
    $group_field_info = array();
?>

<div class="rx-group-field-wrapper" id="<?php echo esc_attr( $id ); ?>" data-name="<?php echo esc_attr( $name ); ?>">
    <script type="text/html" class="rx-group-template">
        <div class="rx-group-field" data-id="1" data-field-name="<?php echo esc_attr( $parent_key );?>">
            <h4 class="rx-group-field-title">
                <span><?php echo esc_html( $group_title ); ?></span>
                <div class="rx-group-controls">
                    <a href="#" class="rx-group-clone">D</a>
                    <a href="#" class="rx-group-remove">x</a>
                </div>
            </h4>
            <div class="rx-group-inner">
                <table>
                    <?php 
                        foreach( $fields as $inner_key => $inner_field ) {
                            $name = $parent_key . '[1][' . $inner_key . ']';
                            $group_field_info['group_field'] = $parent_key;
                            $group_field_info['group_sub_fields'][] = array(
                                'field_name'    => $name,
                                'original_name' => $inner_key,
                            );
                            WP_Opt_Wizard_MetaBox::render_option_field( $name, $inner_field );
                        }
                    ?>
                </table>
                <div class="rx-group-field-info" data-info="<?php echo esc_attr( json_encode( $group_field_info ) ); ?>"></div>
            </div>
        </div>
    </script>

    <div class="rx-group-fields-wrapper">
        <?php if( empty( $group_value ) ) : ?>
            <div class="rx-group-field" data-id="1" data-field-name="<?php echo esc_attr( $parent_key );?>">
                <h4 class="rx-group-field-title">
                    <span><?php echo esc_html( $group_title ); ?></span>
                    <div class="rx-group-controls">
                        <a href="#" class="rx-group-clone">D</a>
                        <a href="#" class="rx-group-remove">x</a>
                    </div>
                </h4>
                <div class="rx-group-inner">
                    <table>
                        <?php 
                            $group_field_info = array();
                            foreach( $fields as $inner_key => $inner_field ) {
                                $name = $parent_key . '[1][' . $inner_key . ']';

                                $group_field_info['group_field'] = $parent_key;
                                $group_field_info['group_sub_fields'][] = array(
                                    'field_name'    => $name,
                                    'original_name' => $inner_key,
                                );

                                WP_Opt_Wizard_MetaBox::render_option_field( $name, $inner_field );
                            }
                        ?>
                    </table>
                    <div class="rx-group-field-info" data-info="<?php echo esc_attr( json_encode( $group_field_info ) ); ?>"></div>
                </div>
            </div>
        <?php else : ?>
            <?php 
                $group_field_info = array();
                foreach( $group_value as $group_id => $field_data ) : ?>
            <div class="rx-group-field" data-id="<?php echo esc_attr( $group_id ); ?>" data-field-name="<?php echo esc_attr( $parent_key ); ?>">
                <h4 class="rx-group-field-title">
                    <span><?php echo esc_html( $group_title ); ?></span>
                    <div class="rx-group-controls">
                        <a href="#" class="rx-group-clone">D</a>
                        <a href="#" class="rx-group-remove">x</a>
                    </div>
                </h4>
                <div class="rx-group-inner">
                    <table>
                        <?php 
                            foreach( $fields as $key => $field ) {
                                $name = $parent_key . '['. $group_id .'][' . $key . ']';
                                $group_field_info['group_field'] = $parent_key;
                                $group_field_info['group_sub_fields'][] = array(
                                    'field_name'    => $name,
                                    'original_name' => $key,
                                );
                                $field_value = isset( $field_data[ $key ] ) ? $field_data[ $key ] : '';
                                WP_Opt_Wizard_MetaBox::render_option_field( $name, $field, $field_value );
                            }
                        ?>
                    </table>
                    <div class="rx-group-field-info" data-info="<?php echo esc_attr( json_encode( $group_field_info ) ); ?>"></div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <button class="rx-group-field-add"><?php echo __( 'Add', 'reviewx' ); ?></button>
    </div>
</div>
