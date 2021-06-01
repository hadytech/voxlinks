<?php

/**
 * Declare backend actions/filters/shortcodes
 */

use ReviewX\Controllers\Admin\Email\EmailSettings;
use ReviewX\Controllers\Admin\Rating\ProductRating;
use ReviewX\Modules\Loader;

if ( !(\ReviewX\Modules\Activator::tableExists('reviewx_criterias')) || 
     !(\ReviewX\Modules\Activator::tableExists('reviewx_process_jobs')) ||
     !(\ReviewX\Modules\Activator::tableExists('reviewx_reminder_email'))
   ) {
    \ReviewX\Modules\Activator::createMigration();
}
 
$app->addAction(
    'admin_menu',
    function () {
        (new Loader())->registerSubmenu();
    }
);

$app->addAction(
    "edit_comment",
    function ($commentId) use($app) {
        $comment = get_comment($commentId);
        if ($comment->comment_type == 'review') {
            $rating = get_comment_meta($commentId, 'rating', true);
            $criteriaRating = get_comment_meta($commentId, 'reviewx_rating', true);
            $app->addAction(
                'transition_comment_status',
                function ($newStatus) use($comment, $rating, $criteriaRating) {
                    $statusMap = [
                        'approved' => 1,
                        'pending'  => -1,
                        'spam'     => -1
                    ];
                    $key = sprintf('_rx_product_%s_rating', $comment->comment_post_ID);
                    $getOption = get_option($key) ? : [];
                    $data = [];
                    $totalReview = _get($getOption['total_review'], 0) + $statusMap[$newStatus];
                    $totalRating = _get($getOption['total_rating'], 0) + ($statusMap[$newStatus] > 0 ? $rating : ((-1) * $rating));

                    foreach ($criteriaRating as $key => $value) {
                        if ($statusMap[$newStatus] > 0) {
                            $data[$key] = _get($getOption[$key], 0) + $value;
                        } else {
                            $data[$key] = _get($getOption[$key], 0) - $value;
                        }
                    }

                    update_option($key, array_merge([
                        'total_review' => $totalReview > 0 ? $totalReview : 0,
                        'total_rating' => $totalRating
                    ], $data));
                }
            );
        }
    }
);

$app->addAction(
    'transition_post_status',
    array((new ProductRating()), 'addRatingOption'),
    10,
    3
);

$app->addAction(
    'rx_reminder_email_dispatch_scheduled',
    function($args) {
        $orderId = $args['order_id'];
        (new EmailSettings())->sendScheduleEmail($orderId);
    }
);

if (\ReviewX_Helper::is_pro()) {
    $app->addAction(
        'woocommerce_order_status_completed',
        function($orderId) {
            (new EmailSettings())->processSingleEmail($orderId);
        }
    );
}

$app->addAdminAjaxAction(
    'send_test_email',
    array((new EmailSettings()), 'sendTestEmail')
);