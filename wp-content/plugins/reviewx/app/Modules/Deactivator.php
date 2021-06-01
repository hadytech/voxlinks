<?php

namespace ReviewX\Modules;

class Deactivator
{
    /**
     * This method will be called on plugin deactivation
     */
    public function handleDeactivation()
    {
        wp_clear_scheduled_hook( 'rx_collect_review_id' );
        wp_clear_scheduled_hook( 'rx_process_re_calculate' );  
        wp_clear_scheduled_hook( 'rx_assign_rating_old_comment' );                
        flush_rewrite_rules();
    }
}
