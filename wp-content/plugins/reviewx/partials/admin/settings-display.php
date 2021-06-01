<div class="rx-settings-wrap">
    <?php do_action( 'reviewx_settings_header' ); ?>

    <div class="rx-left-right-settings">
        <?php do_action( 'rx_before_settings_left' ); ?>

        <div class="rx-settings-left">

            <div class="rx-settings">

                <div class="rx-settings-menu">
                    <ul>
                        <?php
                            $i = 1;
                            foreach( $settings_args as $key => $setting ) {
                                $active = $i++ === 1 ? 'active ' : '';
                                echo '<li class="'. $active .'" data-tab="'. $key .'"><a href="#'. $key .'">'. $setting['title'] .'</a></li>';
                            }
                        ?>
                    </ul>
                </div>

                <div class="rx-settings-content">
                    <?php 
                        $i = 1;
                        /**
                         * Settings Tab Content Rendering
                         */
                        foreach( $settings_args as $tab_key => $setting ) {
                            $active = $i++ === 1 ? 'active ' : '';
                            $sections = isset( $setting['sections'] ) ? $setting['sections'] : [];
                            $sections = ReviewX_Helper::sorter( $sections, 'priority', 'ASC' );
                            ?>
                            <div id="fs-<?php echo esc_attr( $tab_key ); ?>" class="rx-settings-tab rx-settings-<?php echo esc_attr( $key );?> <?php echo esc_attr( $active ); ?>">
                                <form method="post" id="rx-settings-<?php echo esc_attr( $tab_key ); ?>-form" action="#">
                                    <?php 
                                        if( ! empty( $sections ) ) :
                                            /**
                                             * Every Section of a tab 
                                             * Rendering.
                                             */
                                            foreach( $sections as $sec_key => $section ) :
                                                $fields = isset( $section['fields'] ) ? $section['fields'] : [];
                                                $fields = ReviewX_Helper::sorter( $fields, 'priority', 'ASC' );
                                                ?>                                 
                                                <div id="rx-settings-<?php echo esc_attr( $sec_key ); ?>" class="rx-settings-section rx-<?php echo esc_attr( $sec_key ); ?>">
                                                    <?php 
                                                    /**
                                                     * Every Section Field Rendering
                                                     */
                                                    if( ! empty( $fields ) ) : ?>
                                                    <table>
                                                        <tbody>
                                                        <?php 
                                                            foreach( $fields as $field_key => $field ) :
	                                                            ReviewX_Settings::render_field( $field_key, $field );
                                                            endforeach;
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                    <?php endif; // fields rendering end ?>
                                                </div>
                                                <?php
                                            endforeach;
                                        endif; // sections rendering end

                                        // Submit Button
                                        if( isset( $setting['button_text'] ) && ! empty( $setting['button_text'] ) ) :
                                    ?>
                                    <button type="submit" class="rx-settings-button rx-submit-<?php echo esc_attr( $tab_key ); ?>" data-nonce="<?php echo wp_create_nonce('rx_'. $tab_key .'_nonce'); ?>" data-key="<?php echo esc_attr( $tab_key ); ?>" id="rx-submit-<?php echo esc_attr( $tab_key ); ?>"><?php echo esc_html(  $setting['button_text'] ); ?></button>
                                    <?php endif; ?>
                                </form>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                
            </div>

        </div>

    </div>

</div>
