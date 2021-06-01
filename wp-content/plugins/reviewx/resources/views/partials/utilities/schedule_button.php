<?php if(($item['max_delivery'] > $item['total_delivery']) && $item['is_subscribe']): ?>
    <button type="button" data-order-id="<?php _e($item['order_id']); ?>" class="rx-common-form-button rx-send-manually" type="button"><?php _e('Send Now', 'reviewx') ?></button>
<?php endif; ?>

<?php if ($item['status'] == \ReviewX\Constants\ReminderEmail::STATUS_SCHEDULED && ($item['max_delivery'] > $item['total_delivery'])): ?>
    <button type="button" data-order-id="<?php _e($item['order_id']); ?>" class="rx-common-form-button rx-cancelled-manually" type="button"><?php _e('Cancel', 'reviewx') ?></button>
<?php endif; ?>
