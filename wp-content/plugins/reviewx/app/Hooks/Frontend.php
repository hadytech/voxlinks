<?php

use ReviewX\Controllers\Admin\Email\ReminderEmail;

if (ReviewX_Helper::is_pro() && get_option('_rx_option_consent_email_subscription')) {
    $app->addAction(
        'woocommerce_checkout_fields',
        function ($fields) {
            return (new \ReviewX\Controllers\Admin\Email\EmailSettings())->addConsentFieldInCheckout($fields);
        }
    );
    
    $app->addAction(
        'woocommerce_checkout_update_order_meta',
        function ($orderId) {
            (new \ReviewX\Controllers\Admin\Email\EmailSettings())->updateConsentFieldMeta($orderId);
        }
    );
}

$app->addAction(
    'parse_request',
    function() {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $getUri = get_option('_rx_option_unsubscribe_url');
        if (is_numeric(strpos($actual_link, $getUri))) {
            $getEmailLogId = sanitize_text_field($_GET['order']);
            $logId = base64_decode($getEmailLogId);

            $log = (new ReminderEmail())->getEmailLog($logId);

            if ($log) {
                if ($log->is_subscribe) {
                    (new ReminderEmail())->updateLog($log->id, [
                        'is_subscribe' => 0
                    ]);
                }
            }
        }
    }
);