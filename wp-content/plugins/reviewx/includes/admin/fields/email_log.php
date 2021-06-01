<?php

// echo '<form method="get">';
// echo '<input type="hidden" name="page" value="reviewx-review-email" />';
    $myListTable = (new ReviewX\Controllers\Admin\Email\ReminderEmail());
    $myListTable->prepare_items();
    // $myListTable->search_box( __('Search', 'reviewx'), $searchColumn );
    $myListTable->views();
    echo '<div class="rx_schedule_email_table">';
        $myListTable->display();
    echo '</div>';
// echo '</form>';