<div class="crowdfundly-metabox-wrapper">
	<?php 
	include 'crowdfundly-settings-header.php'; 
	?>
    <div class="crowdfundly-settings-wrap">
        <div class="easy-page-body">
            <div class="content-area">
                <div class="crowdfundly-left-right-settings">
                    <?php do_action( 'crowdfundly_before_settings_left' ); ?>
                    <div class="crowdfundly-settings-left">
                        <div class="crowdfundly-settings">
                            <div class="crowdfundly-settings-menu">
                                <ul>
                                    <?php
                                        $i = 1;
                                        foreach( $settings_args as $key => $setting ) {
                                            $active = $i++ === 1 ? 'active' : '';
                                            printf( 
                                                "<li class='%s' data-tab='%s' ><a href='%s'>%s %s</a></li>",
                                                esc_attr($active),
                                                esc_attr($key),
                                                esc_url('#'.$key),
                                                $setting['icon'],
                                                esc_html( $setting['title'] )
                                            );
                                        }
                                    ?>
                                </ul>
                            </div>
                    
                            <div class="crowdfundly-settings-content">
                                <form method="post" id="crowdfundly-settings-form" action="#">
                                    <?php
                                        $i = 1;
                                        foreach( $settings_args as $tab_key => $setting ) {
                                            $active = $i++ === 1 ? 'active ' : '';
                                            $sections = isset( $setting['sections'] ) ? $setting['sections'] : [];
                                            $sections = Crowdfundly_Helper::sorter( $sections, 'priority', 'ASC' );
                                        ?>
                                        <div id="crowdfundly-<?php echo esc_attr( $tab_key ); ?>" class="crowdfundly-settings-tab crowdfundly-settings-<?php echo esc_attr( $key );?> <?php echo $active; ?>">
                                            <?php
                                                if( ! empty( $sections ) ) :
                                                    /**
                                                     * Every Section of a tab
                                                     * Rendering.
                                                     */
                                                    foreach( $sections as $sec_key => $section ) :
                                                        $fields = isset( $section['fields'] ) ? $section['fields'] : [];

                                                        $fields = Crowdfundly_Helper::sorter( $fields, 'priority', 'ASC' );
                                                    ?>
                                                    <div id="crowdfundly-settings-<?php echo esc_attr( $sec_key ); ?>" class="crowdfundly-settings-section crowdfundly-<?php echo esc_attr( $sec_key ); ?>">
                                                        <?php if( ! empty( $fields ) ) : ?>
                                                            <table>
                                                                <tbody>
                                                                    <?php
                                                                        foreach( $fields as $field_key => $field ) :
                                                                            Crowdfundly_Helper::render_field(self::$option_prefix, $field_key, $field );
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
                                            <button type="button" class="crowdfundly-settings-button crowdfundly-submit-<?php echo esc_attr( $tab_key ); ?>" data-nonce="<?php echo wp_create_nonce('crowdfundly_'. esc_attr( $tab_key ) .'_link_nonce'); ?>" data-key="<?php echo esc_attr( $tab_key ); ?>" id="crowdfundly-submit_<?php echo esc_attr( $tab_key ); ?>">
                                                <?php echo esc_html( $setting['button_text']); ?>
                                            </button>
                                            <?php endif; ?>
                                            <?php if(isset($setting['additional_footer_link']) && !empty($setting['additional_footer_link'])): ?>
                                                <button type="button" class="crowdfundly-settings-button crowdfundly-footer-link-<?php echo esc_attr( $tab_key ); ?>" data-nonce="<?php echo wp_create_nonce('crowdfundly_'. esc_attr( $tab_key . '_link_nonce' )); ?>" data-key="<?php echo esc_attr( $tab_key . '_link' ); ?>">
                                                    <?php echo esc_html($setting['additional_footer_link']['text']); ?>
                                                </button>
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
                    do_action( 'crowdfundly_after_settings_left' );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
