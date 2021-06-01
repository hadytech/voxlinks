<?php

namespace ReviewX\Controllers\Admin\Email;

use ReviewX\Controllers\Admin\Core\ReviewxMetaBox;
use ReviewX\Controllers\Admin\Email\Filter\Filterable;
use ReviewX\Controllers\Controller;
use ReviewX\Constants\ReminderEmail as ConstantsReminderEmail;
use ReviewX\Modules\Gatekeeper;
use ReviewX\Services\Epoch\Epoch;

class EmailSettings extends Controller
{
    /**
     * The plugin option
     *
     * @since    1.0.0
     * @access   public
     * @var string option.
     */
    public static $prefix = 'rx_option_';

    /**
     * Send test email
     *
     * @return void
     */
    public function sendTestEmail()
    {
        try {
            $email = sanitize_email($_POST['test_email']);
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $defaultArgs = $this->getDefaultQuickSetupArgs();

            wp_mail(
                $email,
                $this->getEmailSubjectTemplate($defaultArgs),
                $this->getEmailTemplate($defaultArgs),
                $headers
            );

            $this->response([
                'message' => __('Successfully email sent to your mail!', 'reviewx')
            ]);
        } catch (\Exception $exception) {
            $this->response([
                'message' => __('Internal error to sent email! Please Try Again.', 'reviewx')
            ], 400);
        }
    }

    protected function getDefaultQuickSetupArgs()
    {
        return ReviewxMetaBox::get_quick_setup_args();
    }

    protected function getEmailSubjectTemplate($defaultArgs)
    {
        $defaultSubject = $defaultArgs['tabs']['email_tab']['sections']['image']['fields']['email_subject']['default'];
        return get_option('_'.self::$prefix.'email_subject', $defaultSubject) ? : $defaultSubject;
    }

    protected function getEmailTemplate($defaultArgs)
    {
        $defaultEditor = $defaultArgs['tabs']['email_tab']['sections']['image']['fields']['email_editor']['default'];
        return get_option( '_'.self::$prefix.'email_editor', $defaultEditor) ? : $defaultEditor;
    }

    /**
     * Check is processable or not
     *
     * @param [type] $orderId
     * @return boolean
     */
    public function isProcessAble($orderId)
    {
        return $this->checkOrderEmailConsent($orderId);
    }

    /**
     * Check order email consent
     *
     * @param [type] $orderId
     * @return void
     */
    protected function checkOrderEmailConsent($orderId)
    {
        $consent = true;
        if (\ReviewX_Helper::is_pro()) {
            $consentOption = get_option('_rx_option_consent_email_subscription', false);
            if ($consentOption) {
                $value = get_post_meta($orderId, 'consent_email_subscription', true);
                $consentValue = is_numeric($value) ? $value : null;
                if (is_null($consentValue)) {
                    $consent = true;
                } else {
                    $consent = $consentValue ? true : false;
                }
            }
        }
        return $consent;
    }

    /**
     * Add Consent Field in checkout
     *
     * @param [type] $fields
     * @return void
     */
    public function addConsentFieldInCheckout($fields)
    {
        $fields['order']['consent_email_subscription'] = [
            'type' => 'checkbox',
            'label' => __('I want to subscribe email', 'reviewx'),
        ];
        return $fields;
    }

    /**
     * Update Consent Field meta
     *
     * @param [type] $orderId
     * @return void
     */
    public function updateConsentFieldMeta($orderId)
    {
        $field = isset($_POST['consent_email_subscription']) ? $_POST['consent_email_subscription'] : 0;
        update_post_meta($orderId, 'consent_email_subscription', (filter_var($field, FILTER_SANITIZE_NUMBER_INT)));
    }

    /**
     * Process Bulk Email
     *
     * @param [type] $unreviewdOrderWiseProduct
     * @return void
     */
    public function processBulkEmail(&$unreviewdOrderWiseProduct)
    {
        $orderItems = (new Filterable($_POST['filter']))->getOrderItems();

        foreach ($orderItems as $order) {
            try {
                $getProductId = wc_get_order_item_meta($order->order_item_id, '_product_id', true);
                $userId = get_post_meta($order->ID, '_customer_user', true);
                $isPossibleToSendEmail = (new Gatekeeper())->getLogForVerifiedUser($getProductId, $order->ID, $userId);

                if( $userId != 0 ){
                    rx_autologin_stage_new_code($userId);
                }
                
                if ($isPossibleToSendEmail) {
                    
                    if (isset($unreviewdOrderWiseProduct[$order->ID])) {
                        $unreviewdOrderWiseProduct[$order->ID][] = $getProductId;
                    } else {
                        $unreviewdOrderWiseProduct[$order->ID] = [$getProductId];
                    }
                }
            } catch (\Exception $e) {
                throw new \Error($e->getMessage());
            }
        }

        $defaultArgs = $this->getDefaultQuickSetupArgs();
        $email_subject = $this->getEmailSubjectTemplate($defaultArgs);
        $email_editor = $this->getEmailTemplate($defaultArgs);

        foreach ($unreviewdOrderWiseProduct as $orderId => $products) {
            $emailConsent = $this->isProcessAble($orderId);

            if ($emailConsent) {

                $reminderEmail = (new ReminderEmail())->getEmailLog($orderId);

                if (!is_null($reminderEmail)) {

                    $isProcessable = (new ReminderEmail())->isProcessAble($reminderEmail);

                    if ($isProcessable) {
                        $email = unserialize($reminderEmail->processed_email);

                        wp_mail(
                            $reminderEmail->customer_email,
                            $email['subject'],
                            $email['text'],
                            array($email['headers'])
                        );

                        $totalDelivery = intval($reminderEmail->total_delivery) + 1;
                        (new ReminderEmail())->updateLog($reminderEmail->id, [
                            'total_delivery' => $totalDelivery,
                            'scheduled_at' => date('Y-m-d H:i:s')
                        ]);
                    }

                } else {

                    $editorParser = (new Editor($orderId, $products, $email_editor));
                    $subjectParser = (new Editor($orderId, $products, apply_filters("rx_email_subject", $email_subject)));
                    $headers = 'Content-Type: text/html; charset=UTF-8';
                    $text = $editorParser->prepareEmail(apply_filters('rx_email_editor_keys', []));
                    $subject = $subjectParser->prepareEmail([]);

                    $email = [
                        'user_id' => $userId,
                        'headers' => $headers,
                        'subject' => $subject,
                        'text' => $text,
                    ];

                    $wcOrder = new \WC_Order($orderId);
                    $userEmail = $wcOrder->get_billing_email();
                    $wcOrder->get_customer_id();

                    wp_mail($userEmail, $subject, $text, array($headers));

                    (new ReminderEmail())->setEmailLog(
                        $orderId,
                        $userEmail,
                        $products,
                        serialize($email),
                        date('Y-m-d H:i:s'),
                        ConstantsReminderEmail::STATUS_DELIVERED,
                        1
                    );
                }

            }
        }
    }

    public function createScheduleEmail(&$unreviewdOrderWiseProduct)
    {
        $orderItems = (new Filterable($_POST['filter']))->getOrderItems();

        $scheduleAt = date('Y-m-d H:i:s', strtotime(sanitize_text_field($_POST['filter']['cron_after'])));

        foreach ($orderItems as $order) {
            try {
                $getProductId = wc_get_order_item_meta($order->order_item_id, '_product_id', true);
                $userId = get_post_meta($order->ID, '_customer_user', true);
                $isPossibleToSendEmail = (new Gatekeeper())->getLogForVerifiedUser($getProductId, $order->ID, $userId);

                if ($isPossibleToSendEmail) {
                    if (isset($unreviewdOrderWiseProduct[$order->ID])) {
                        $unreviewdOrderWiseProduct[$order->ID][] = $getProductId;
                    } else {
                        $unreviewdOrderWiseProduct[$order->ID] = [$getProductId];
                    }
                }
            } catch (\Exception $e) {
                throw new \Error($e->getMessage());
            }
        }

        $defaultArgs = $this->getDefaultQuickSetupArgs();
        $email_subject = $this->getEmailSubjectTemplate($defaultArgs);
        $email_editor = $this->getEmailTemplate($defaultArgs);

        foreach ($unreviewdOrderWiseProduct as $orderId => $products) {

            $emailConsent = $this->isProcessAble($orderId);

            if ($emailConsent) {

                $reminderEmail = (new ReminderEmail())->getEmailLog($orderId);
                $scheduleUtcAt = (new \DateTime($scheduleAt, new \DateTimeZone(wp_timezone_string())));


                if (is_null($reminderEmail)) {

                    $editorParser = (new Editor($orderId, $products, $email_editor));
                    $subjectParser = (new Editor($orderId, $products, apply_filters("rx_email_subject", $email_subject)));
                    $headers = 'Content-Type: text/html; charset=UTF-8';
                    $text = $editorParser->prepareEmail(apply_filters('rx_email_editor_keys', []));
                    $subject = $subjectParser->prepareEmail([]);

                    $email = [
                        'headers' => $headers,
                        'subject' => $subject,
                        'text' => $text,
                    ];

                    $wcOrder = new \WC_Order($orderId);

                    $userEmail = $wcOrder->get_billing_email();

                    (new ReminderEmail())->setEmailLog(
                        $orderId,
                        $userEmail,
                        $products,
                        serialize($email),
                        date('Y-m-d H:i:s', strtotime($scheduleAt)),
                        ConstantsReminderEmail::STATUS_SCHEDULED,
                        0
                    );

                } else {
                    (new ReminderEmail())->updateLog($reminderEmail->id, [
                        'status' => ConstantsReminderEmail::STATUS_SCHEDULED
                    ]);
                }

                wp_schedule_single_event($scheduleUtcAt->getTimestamp(), 'rx_reminder_email_dispatch_scheduled', [
                    'order_id' => $orderId
                ]);
            }
        }
    }

    public function getAutoReviewReminderConsent()
    {
        if (\ReviewX_Helper::is_pro()) {
            return get_option('_rx_option_auto_review_reminder', false);
        }

        return true;
    }

    /**
     * Process Single Email
     *
     * @param [type] $orderId
     * @return void
     */
    public function processSingleEmail($orderId)
    {
        if (! $this->getAutoReviewReminderConsent()) {
            return;
        }

        $products = [];
        
        $orderItems = wpFluent()->table('woocommerce_order_items')
                    ->where('order_id', $orderId)
                    ->get();

        foreach ($orderItems as $order) {
            $getProductId = wc_get_order_item_meta($order->order_item_id, '_product_id', true);
            $products[] = $getProductId;
        }

        $emailConsent = $this->isProcessAble($orderId);

        $defaultArgs = $this->getDefaultQuickSetupArgs();
        $email_subject = $this->getEmailSubjectTemplate($defaultArgs);
        $email_editor = $this->getEmailTemplate($defaultArgs);

        if ($emailConsent) {

            $reminderEmail = (new ReminderEmail())->getEmailLog($orderId);

            $daysToWait = get_option('_rx_option_get_review_email', 1);
                
            $cronAfter = (( 24 * 60 * 60 * intval($daysToWait)));
            $scheduleAt = time() + $cronAfter;

            if (is_null($reminderEmail)) {
                
                $editorParser = (new Editor($orderId, $products, $email_editor));
                $subjectParser = (new Editor($orderId, $products, apply_filters("rx_email_subject", $email_subject)));
                $headers = 'Content-Type: text/html; charset=UTF-8';
                $text = $editorParser->prepareEmail(apply_filters('rx_email_editor_keys', []));
                $subject = $subjectParser->prepareEmail([]);

                $email = [
                    'headers' => $headers,
                    'subject' => $subject,
                    'text' => $text,
                    'template_hash' => $this->getEmailTemplateHash(),
                    'products' => $products,
                ];
                
                $wcOrder = new \WC_Order($orderId);

                $userEmail = $wcOrder->get_billing_email();

                (new ReminderEmail())->setEmailLog(
                    $orderId,
                    $userEmail,
                    $products,
                    serialize($email),
                    date('Y-m-d H:i:s', $scheduleAt),
                    ConstantsReminderEmail::STATUS_SCHEDULED,
                    0
                );

            } else {
                (new ReminderEmail())->updateLog($reminderEmail->id, [
                    'status' => ConstantsReminderEmail::STATUS_SCHEDULED
                ]);
            }


            wp_schedule_single_event($scheduleAt, 'rx_reminder_email_dispatch_scheduled', [
                'order_id' => $orderId
            ]);
        }

    }

    /**
     * Send Schedule Email
     *
     * @param [type] $orderId
     * @param bool $checkStatus
     * @return void
     */
    public function sendScheduleEmail($orderId, $checkStatus = true)
    {
        $reminderEmail = (new ReminderEmail())->getEmailLog($orderId);

        if ($checkStatus && $reminderEmail->status !== ConstantsReminderEmail::STATUS_SCHEDULED) {
            return;
        }

        $email = $this->findOrUpdateProcessEmail(
            $reminderEmail->id,
            $reminderEmail->order_id,
            unserialize($reminderEmail->processed_email)
        );



        $emailConsent = $this->isProcessAble($orderId);

        if ($emailConsent) {
            wp_mail(
                $reminderEmail->customer_email,
                $email['subject'],
                $email['text'],
                array($email['headers'])
            );

            $totalDelivery = intval($reminderEmail->total_delivery) + 1;

            (new ReminderEmail())->updateLog($reminderEmail->id, [
                'total_delivery' => $totalDelivery,
                'status' => ConstantsReminderEmail::STATUS_DELIVERED
            ]);
        }
    }

    public function sendNowEmail($orderId)
    {
        $this->sendScheduleEmail($orderId, false);
    }

    public function findOrUpdateProcessEmail($id, $orderId, $emailOptions)
    {
        $currentTemplateHash = $this->getEmailTemplateHash();

        if ($currentTemplateHash !== $emailOptions['template_hash']) {
            $defaultArgs = $this->getDefaultQuickSetupArgs();
            $email_subject = $this->getEmailSubjectTemplate($defaultArgs);
            $email_editor = $this->getEmailTemplate($defaultArgs);
            $products = $emailOptions['products'];
            $editorParser = (new Editor($orderId, $products, $email_editor));
            $subjectParser = (new Editor($orderId, $products, apply_filters("rx_email_subject", $email_subject)));
            $headers = 'Content-Type: text/html; charset=UTF-8';
            $text = $editorParser->prepareEmail(apply_filters('rx_email_editor_keys', []));
            $subject = $subjectParser->prepareEmail([]);

            $emailOptions = [
                'headers' => $headers,
                'subject' => $subject,
                'text' => $text,
                'template_hash' => $currentTemplateHash,
                'products' => $products,
            ];

            (new ReminderEmail())->updateLog($id, [
                'processed_email' => serialize($emailOptions)
            ]);

            return $emailOptions;
        }

        return $emailOptions;
    }

    public function getEmailTemplateHash()
    {
        return get_option(\ReviewX\Constants\ReminderEmail::CURRENT_TEMPLATE_HASH);
    }

    public function cancelledScheduleEmail($orderId)
    {
        $reminderEmail = (new ReminderEmail())->getEmailLog($orderId);

        (new ReminderEmail())->updateLog($reminderEmail->id, [
            'status' => ConstantsReminderEmail::STATUS_CANCELLED
        ]);
    }

    /**
     * Set current template hash
     * @param $emailContent
     */
    public static function setCurrentTemplateHash($emailContent)
    {
        update_option(ConstantsReminderEmail::CURRENT_TEMPLATE_HASH, md5($emailContent));
    }

    /**
     * Get Current Template hash
     * @return bool|mixed|void
     */
    public static function getCurrentTemplateHash()
    {
        return get_option(ConstantsReminderEmail::CURRENT_TEMPLATE_HASH);
    }

}