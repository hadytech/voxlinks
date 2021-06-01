<?php

/******************************
 *  Review Item
 * 
 *******************************/

$wp_customize->add_setting('reviewx_modify_label_list', array(
    'default'           => $defaults['reviewx_modify_label_list'],
    'sanitize_callback' => 'esc_html',
));	

$wp_customize->add_control(new ReviewX_Separator_Custom_Control(
    $wp_customize, 'reviewx_modify_label_list', array(
    'label'	            => esc_html__( 'Review Item', 'reviewx' ),
    'settings'	        => 'reviewx_modify_label_list',
    'section'  	        => 'reviewx_modify_label_settings',
    'priority'          => 102
)));

$wp_customize->add_setting('reviewx_section_title', array(
    'default' => $defaults['reviewx_section_title'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_section_title',
        array(
            'label' => __('Change Review Section Title', 'reviewx'),
            'priority'   => 103,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_section_title',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_customer_recommendation_label', array(
    'default' => $defaults['reviewx_customer_recommendation_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_customer_recommendation_label',
        array(
            'label' => __('Change \'Customer(s) recommended this item\'', 'reviewx'),
            'priority'   => 103,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_customer_recommendation_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_sort_by_label', array(
    'default' => $defaults['reviewx_sort_by_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_sort_by_label',
        array(
            'label' => __('Change \'Sort by\'', 'reviewx'),
            'priority'   => 104,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_sort_by_label',
            'type' => 'text',
        )
    )
);

if( class_exists('ReviewXPro') ) {

    $wp_customize->add_setting('reviewx_reply_label', array(
        'default' => $defaults['reviewx_reply_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_reply_label',
            array(
                'label' => __('Change \'Reply\'', 'reviewx'),
                'priority'   => 105,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_reply_label',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting('reviewx_reply_to_this_review_label', array(
        'default' => $defaults['reviewx_reply_to_this_review_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_reply_to_this_review_label',
            array(
                'label' => __('Change \'Reply to this review\'', 'reviewx'),
                'priority'   => 106,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_reply_to_this_review_label',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting('reviewx_edit_this_reply_label', array(
        'default' => $defaults['reviewx_edit_this_reply_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_edit_this_reply_label',
            array(
                'label' => __('Change \'Edit this reply\'', 'reviewx'),
                'priority'   => 107,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_edit_this_reply_label',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting('reviewx_reply_review_label', array(
        'default' => $defaults['reviewx_reply_review_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_reply_review_label',
            array(
                'label' => __('Change \'Reply Review\'', 'reviewx'),
                'priority'   => 108,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_reply_review_label',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting('reviewx_update_button_label', array(
        'default' => $defaults['reviewx_update_button_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_update_button_label',
            array(
                'label' => __('Change \'Update\'', 'reviewx'),
                'priority'   => 109,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_update_button_label',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting('reviewx_cancel_button_label', array(
        'default' => $defaults['reviewx_cancel_button_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_cancel_button_label',
            array(
                'label' => __('Change \'Cancel\'', 'reviewx'),
                'priority'   => 110,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_cancel_button_label',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting('reviewx_helpful_label', array(
        'default' => $defaults['reviewx_helpful_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_helpful_label',
            array(
                'label' => __('Change \'Helpful?\'', 'reviewx'),
                'priority'   => 111,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_helpful_label',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting('reviewx_share_on_label', array(
        'default' => $defaults['reviewx_share_on_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_share_on_label',
            array(
                'label' => __('Change \'Share on\'', 'reviewx'),
                'priority'   => 112,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_share_on_label',
                'type' => 'text',
            )
        )
    );

}

/******************************
 *  Review Form
 * 
 *******************************/

$wp_customize->add_setting('reviewx_modify_label', array(
    'default'           => $defaults['reviewx_modify_label'],
    'sanitize_callback' => 'esc_html',
));	

$wp_customize->add_control(new ReviewX_Separator_Custom_Control(
    $wp_customize, 'reviewx_modify_label', array(
    'label'	            => esc_html__( 'Review Form', 'reviewx' ),
    'settings'	        => 'reviewx_modify_label',
    'section'  	        => 'reviewx_modify_label_settings',
    'priority'          => 113
)));

$wp_customize->add_setting('reviewx_form_title_label', array(
    'default' => $defaults['reviewx_form_title_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_form_title_label',
        array(
            'label' => __('Change \'Leave feedback about this\'', 'reviewx'),
            'priority'   => 114,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_form_title_label',
            'type' => 'text',
        )
    )
);
if( class_exists('ReviewXPro') ) {
    $wp_customize->add_setting('reviewx_video_upload_first_label', array(
        'default' => $defaults['reviewx_video_upload_first_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_video_upload_first_label',
            array(
                'label' => __('Change \'Upload File\' Label', 'reviewx'),
                'priority'   => 115,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_video_upload_first_label',
                'type' => 'text',
            )
        )
    );

    $wp_customize->add_setting('reviewx_video_upload_second_label', array(
        'default' => $defaults['reviewx_video_upload_second_label'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_video_upload_second_label',
            array(
                'label' => __('Change \'External Link\' Label', 'reviewx'),
                'priority'   => 116,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_video_upload_second_label',
                'type' => 'text',
            )
        )
    );	

    $wp_customize->add_setting('reviewx_video_external_link', array(
        'default' => $defaults['reviewx_video_external_link'],
        'capability'    => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'reviewx_video_external_link',
            array(
                'label' => __('Change Example \'Video Link\' URL', 'reviewx'),
                'priority'   => 117,
                'section' => 'reviewx_modify_label_settings',
                'settings' => 'reviewx_video_external_link',
                'type' => 'text',
            )
        )
    );  
}

$wp_customize->add_setting('reviewx_form_recommednation_label', array(
    'default' => $defaults['reviewx_form_recommednation_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_form_recommednation_label',
        array(
            'label' => __('Change \'Recommendation:\'', 'reviewx'),
            'priority'   => 118,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_form_recommednation_label',
            'type' => 'text',
        )
    )
);

if( class_exists('ReviewXPro') ) {
$wp_customize->add_setting('reviewx_anonymously_label', array(
    'default' => $defaults['reviewx_anonymously_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_anonymously_label',
        array(
            'label' => __('Change \'Review anonymously\'', 'reviewx'),
            'priority'   => 119,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_anonymously_label',
            'type' => 'text',
        )
    )
);
}

$wp_customize->add_setting('reviewx_media_compliance', array(
    'default' => $defaults['reviewx_media_compliance'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_media_compliance',
        array(
            'label' => __('Change \'Allow shop owner to display consent checkbox.\'', 'reviewx'),
            'priority'   => 119,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_media_compliance',
            'type' => 'textarea',
        )
    )
);

$wp_customize->add_setting('reviewx_submit_button_label', array(
    'default' => $defaults['reviewx_submit_button_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_submit_button_label',
        array(
            'label' => __('Change \'Submit Review\'', 'reviewx'),
            'priority'   => 120,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_submit_button_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_review_title_validation_label', array(
    'default' => $defaults['reviewx_review_title_validation_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_review_title_validation_label',
        array(
            'label' => __('Change \'Please enter a title\'', 'reviewx'),
            'priority'   => 121,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_review_title_validation_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_review_leave_label', array(
    'default' => $defaults['reviewx_review_leave_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_review_leave_label',
        array(
            'label' => __('Change \'Please leave a message\'', 'reviewx'),
            'priority'   => 122,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_review_leave_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_title_validation_label', array(
    'default' => $defaults['reviewx_title_validation_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_title_validation_label',
        array(
            'label' => __('Change \'Review title can\'t be empty\' (My order)', 'reviewx'),
            'priority'   => 123,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_title_validation_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_text_validation_label', array(
    'default' => $defaults['reviewx_text_validation_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_text_validation_label',
        array(
            'label' => __('Change \'Review can\'t be empty\' (My order)', 'reviewx'),
            'priority'   => 124,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_text_validation_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_review_success_label', array(
    'default' => $defaults['reviewx_review_success_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_review_success_label',
        array(
            'label' => __('Change \'Your review submitted successfully!\'', 'reviewx'),
            'priority'   => 125,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_review_success_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_rate_satisfaction_label', array(
    'default' => $defaults['reviewx_rate_satisfaction_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_rate_satisfaction_label',
        array(
            'label' => __('Change \'Please rate your satisfaction\'', 'reviewx'),
            'priority'   => 126,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_rate_satisfaction_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_review_failed_label', array(
    'default' => $defaults['reviewx_review_failed_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_review_failed_label',
        array(
            'label' => __('Change \'Review submission failed!\'', 'reviewx'),
            'priority'   => 127,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_review_failed_label',
            'type' => 'text',
        )
    )
);

/******************************
 *  Guest Review
 * 
 *******************************/

$wp_customize->add_setting('reviewx_guest_name_validation_label', array(
    'default' => $defaults['reviewx_guest_name_validation_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_guest_name_validation_label',
        array(
            'label' => __('Change \'Please enter your name\' (Guest Review)', 'reviewx'),
            'priority'   => 128,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_guest_name_validation_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_guest_email_validation_label', array(
    'default' => $defaults['reviewx_guest_email_validation_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_guest_email_validation_label',
        array(
            'label' => __('Change \'Please enter a valid email address\' (Guest Review) ', 'reviewx'),
            'priority'   => 129,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_guest_email_validation_label',
            'type' => 'text',
        )
    )
);

$wp_customize->add_setting('reviewx_already_given_review_label', array(
    'default' => $defaults['reviewx_already_given_review_label'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_already_given_review_label',
        array(
            'label' => __('Change \'This email has already given review on this product\' (Guest Review)', 'reviewx'),
            'priority'   => 130,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_already_given_review_label',
            'type' => 'textarea',
        )
    )
);

$wp_customize->add_setting('reviewx_media_upload_compliance_validation', array(
    'default' => $defaults['reviewx_media_upload_compliance_validation'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_media_upload_compliance_validation',
        array(
            'label' => __('Change \'Please accept the media upload compliance', 'reviewx'),
            'priority'   => 130,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_media_upload_compliance_validation',
            'type' => 'textarea',
        )
    )
);


/******************************
 *  Purchase Validation Message
 * 
 *******************************/

$wp_customize->add_setting('reviewx_re_reviewed_without_purchase_again', array(
    'default' => $defaults['reviewx_re_reviewed_without_purchase_again'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_re_reviewed_without_purchase_again',
        array(
            'label' => __('Change \'Once reviewed item can not be re-reviewed without purchase it again.\'', 'reviewx'),
            'priority'   => 131,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_re_reviewed_without_purchase_again',
            'type' => 'textarea',
        )
    )
);

$wp_customize->add_setting('reviewx_only_logged_customer_review', array(
    'default' => $defaults['reviewx_only_logged_customer_review'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_only_logged_customer_review',
        array(
            'label' => __('Change \'Only logged in customers who have purchased this product may leave a review.\'', 'reviewx'),
            'priority'   => 132,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_only_logged_customer_review',
            'type' => 'textarea',
        )
    )
);

$wp_customize->add_setting('reviewx_re_reviewed_without_purchase_it', array(
    'default' => $defaults['reviewx_re_reviewed_without_purchase_it'],
    'capability'    => 'edit_theme_options',
    'sanitize_callback' => 'esc_html',
));

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'reviewx_re_reviewed_without_purchase_it',
        array(
            'label' => __('Change \'Once reviewed item can not be re-reviewed without purchase.\'', 'reviewx'),
            'priority'   => 133,
            'section' => 'reviewx_modify_label_settings',
            'settings' => 'reviewx_re_reviewed_without_purchase_it',
            'type' => 'textarea',
        )
    )
);