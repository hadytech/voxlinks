<?php

echo '<div class="wrap"><h2>'. esc_html__('My List Table Test','reviewx') .'</h2>';
$myListTable->prepare_items();
$myListTable->call_analytics_header();
$myListTable->search_box( esc_html__( 'Search Review', 'reviewx'), 'search_id' );
$myListTable->reviewx_test_filter();
$myListTable->display();
echo '</div>';