<div class="test_email_checkbox">
    <label>
        <input type="checkbox" class="send_test_email" value="1"/>
        <span></span>
        <?php esc_html_e( 'Send Test Email?', 'reviewx' );?>
    </label>
</div>

<div id="send_test_email_section">
    <input type="email" placeholder="<?php esc_attr_e('admin@yourshop.com', 'reviewx' ); ?>" id="send_test_email" class="te_input">
    <button type="button" id="send_test_email_button" class="te_button"><?php esc_html_e('Send test email', 'reviewx' );?></button>
    <p class="rx-test-email-validation-error"></p>
    <?php
    $url = 'https://wordpress.org/plugins/wp-mail-smtp/';
    ?>
    <p><b><?php esc_html_e( 'Note:', 'reviewx' );?></b> <?php esc_html_e( 'To send the review reminder email you have to make sure that your WordPress mail delivery is working properly. Don’t worry, for easy configuration you can use', 'reviewx' ); ?> <a href="<?php echo esc_url( $url ); ?>" target="_blank"><?php esc_html_e( 'WP Mail by WPForms plugin', 'reviewx' );?></a></p>
</div>