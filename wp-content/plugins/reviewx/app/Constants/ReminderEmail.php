<?php

namespace ReviewX\Constants;

interface ReminderEmail
{
    const STATUS_SCHEDULED = "scheduled";
    const STATUS_DELIVERED = "delivered";
    const STATUS_FAILED = "failed";
    const STATUS_CANCELLED = "cancelled";

    const CURRENT_TEMPLATE_HASH = '_rx_option_current_template_hash';
}