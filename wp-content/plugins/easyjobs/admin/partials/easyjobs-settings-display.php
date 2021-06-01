<div class="easyjobs-settings-wrap">
    <div class="easy-page-body">
        <div class="content-area">
            <?php do_action( 'easyjobs_settings_header' ); ?>
            <div class="easyjobs-left-right-settings">
                <?php do_action( 'easyjobs_before_settings_left' ); ?>
                <div class="easyjobs-settings-left">
                    <div class="easyjobs-settings">
                        <div class="easyjobs-settings-menu">
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
                
                        <div class="easyjobs-settings-content">
                            <form method="post" id="easyjobs-settings-form" action="#">
                                <?php
                                $i = 1;
                                /**
                                 * Settings Tab Content Rendering
                                 */
                                foreach( $settings_args as $tab_key => $setting ) {
                                    $active = $i++ === 1 ? 'active ' : '';
                                    $sections = isset( $setting['sections'] ) ? $setting['sections'] : [];
                                    $sections = Easyjobs_Helper::sorter( $sections, 'priority', 'ASC' );
                                    ?>
                                    <div id="easyjobs-<?php echo esc_attr( $tab_key ); ?>" class="easyjobs-settings-tab easyjobs-settings-<?php echo esc_attr( $key );?> <?php echo $active; ?>">
                                        <?php
                                        if( ! empty( $sections ) ) :
                                            /**
                                             * Every Section of a tab
                                             * Rendering.
                                             */
                                            foreach( $sections as $sec_key => $section ) :
                                                $fields = isset( $section['fields'] ) ? $section['fields'] : [];
                                                $fields = Easyjobs_Helper::sorter( $fields, 'priority', 'ASC' );
                                                ?>
                                                <div
                                                    id="easyjobs-settings-<?php echo esc_attr( $sec_key ); ?>"
                                                    class="easyjobs-settings-section easyjobs-<?php echo esc_attr( $sec_key ); ?>">
                                                    <?php
                                                    /**
                                                     * Every Section Field Rendering
                                                     */
                                                    if( ! empty( $fields ) ) : ?>
                                                        <table>
                                                            <tbody>
                                                            <?php
                                                            foreach( $fields as $field_key => $field ) :
                                                                EasyJobs_Settings::render_field( $field_key, $field );
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
                                            <button type="submit" class="easyjobs-settings-button easyjobs-submit-<?php echo $tab_key; ?>" data-nonce="<?php echo wp_create_nonce('easyjobs_'. $tab_key .'_nonce'); ?>" data-key="<?php echo $tab_key; ?>" id="easyjobs-submit-<?php echo $tab_key; ?>"><?php _e( $setting['button_text'], 'easyjobs' ); ?></button>
                                        <?php endif; ?>
                                        <?php if(isset($setting['additional_footer_link']) && !empty
                                            ($setting['additional_footer_link'])): ?>
                                            <a href="<?php echo $setting['additional_footer_link']['link']?>"
                                               class="easyjobs-footer-link-<?php echo $tab_key; ?>" data-nonce="<?php
                                            echo wp_create_nonce('easyjobs_'. $tab_key .'_link_nonce'); ?>"
                                               data-key="<?php echo $tab_key . '_link'; ?>">
                                                <?php echo $setting['additional_footer_link']['text'];?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                } // settings rendering loop end;
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                do_action( 'easyjobs_after_settings_left' );
                ?>
            </div>
        </div>
    </div>
</div>
