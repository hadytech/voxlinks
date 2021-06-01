<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
do_action( 'woocommerce_before_account_orders', $has_orders );
$get_img                    = $prod_name = $prod_qty = $prod_price = '';
$order_count                = 1;
$rx_order_table_column_name = wc_get_account_orders_columns();
?>

<?php if ( $has_orders ){ ?>
    <div class="overflow-auto">
        <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table table table-bordered reviewx-order-table" id="rx-order-table">
            <thead>
                <tr>
                    <?php foreach (  $rx_order_table_column_name as $column_id => $column_name ) { ?>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>">
                            <span class="nobr"><?php echo esc_html__( $column_name, 'reviewx' ); ?></span>
                        </th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach ( $customer_orders->orders as $customer_order ) {
                        $order           = wc_get_order( $customer_order );
                        $temp_order      = json_decode( $customer_order );
                        $single_order_id = $temp_order->id;
                        $item_count      = $order->get_item_count();
                        $pablo           = 0;

                        // get basic order data
                        $order  = new WC_Order( $order->get_order_number() );
                        $order_url = $order->get_view_order_url();
                        $order_date = $order->get_date_created();
                        $order_date_time = $order->get_date_created()->date( 'c' );
                        $order_status = $order->get_status();

                        $items = $order->get_items();
                        foreach ( $items as $item ){
                            $product_image  = get_post_thumbnail_id( $item["product_id"] );
                            $item_attachment = wp_get_attachment_image_src( $product_image, array('100','80'), true );
                            $item_sub_total = get_woocommerce_currency_symbol().$order->get_total();
                            // prepare data for ajax call
                            $product_id             = $item["product_id"];
                            $product_image          = get_post_thumbnail_id( $product_id );
                            $attachment             = wp_get_attachment_image_src( $product_image, 'full' );
                            $check_already_reviewed = \ReviewX_Helper::check_already_reviewed( $product_id, get_current_user_id(), $item["order_id"] );
                            $current_user_id        = get_current_user_id();
                            $review_id              = \ReviewX_Helper::retrieve_review_id( $item["order_id"], $product_id, $current_user_id );
                            $settings               = (array) \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
                            $check_order_status     = $order_status;

                            $reviewx_order_status = array();
                            $wc_order_statuses      = apply_filters( 'rx_wc_order_status', true );
                            foreach( $wc_order_statuses as $key => $value ) {
                                if( array_key_exists($key, $settings) && $settings[$key] == 1 ){                    
                                   array_push($reviewx_order_status, $key);
                                }                
                            }
                ?>

                <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order<?php echo esc_attr( $order_count ); ?>">
                    <?php foreach ( $rx_order_table_column_name as $column_id => $column_name ){ ?>
                         <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
                             <?php
                                if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                                    <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

                                <?php #Order Id
                                elseif ( 'order-number' === $column_id ) : ?>
                                     <p><a href="<?php echo esc_url( $order_url ); ?>"><?php echo esc_html__( '#', 'reviewx' ) . $item["order_id"]; ?></a></p>

                                <?php #Order Date
                                elseif ( 'order-date' === $column_id ) : ?>
                                    <time datetime="<?php echo esc_attr( $order_date_time ); ?>"><?php echo esc_html( wc_format_datetime( $order_date ) ); ?></time>

                                <?php #Product Image
                                elseif ( 'order-image' === $column_id ) : ?>
                                    <p><img src="<?php echo esc_url( $item_attachment[0] ); ?>" id="thumb<?php echo esc_attr( $order_count ); ?>"></p>

                                <?php #Product Name
                                elseif ( 'order-name' === $column_id ) : ?>
                                    <p><a href="<?php echo get_permalink($product_id); ?>"><?php echo esc_html__( $item["name"], 'reviewx' ); ?></a></p>

                                <?php #Product Price
                                elseif ( 'order-price' === $column_id ) :?>

                                    <p><?php printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'reviewx' ), $order->get_formatted_order_total(), $item_count ); ?></p>

                                <?php #Order Status
                                elseif ( 'order-status' === $column_id ) :?>
                                    <?php echo esc_html__( wc_get_order_status_name( $order_status ), 'reviewx' ); ?>
                               
                                <?php #Order Action ReviewX
                                elseif ( 'order-actions' === $column_id ) :

                                    // get all actions
                                    $actions = wc_get_account_orders_actions( $order ); 

                                    // display the each action
                                    if ( ! empty( $actions ) ) {
                                        foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
                                            echo '<p class="padding_5"> <a href="' . esc_url( $action['url'] ) . '" class="rx_my_account_view_review rx-btn btn-primary btn-sm rx-form-primary-btn btn-review review-off btn-info rx-order-btn' . sanitize_html_class( $key ) . '">' . esc_html__( $action['name'], 'reviewx' ) . '</a> </p>';
                                        }
                                    }

                                    if( $check_already_reviewed ) { ?>
                                        <p class="padding_5"> 
                                            <a class="rx_my_account_view_review rx-btn btn-primary btn-sm rx-form-primary-btn btn-review review-off btn-info rx-order-btn" href="<?php echo esc_url( get_permalink($product_id))?>#tab-reviews" target="_blank">
                                                <?php echo esc_html__('View review', 'reviewx' ); ?>
                                            </a>  
                                        </p>
                                        
                                        <?php

                                            if ( in_array( $check_order_status, $reviewx_order_status ) ) {
                                                $data                   = array();
                                                $data['prod_id']        = $product_id;
                                                $data['order']          = $order_count;
                                                $data['order_status']   = esc_html__( wc_get_order_status_name( $order->get_status(), 'reviewx' ) );
                                                $data['order_id']       = $single_order_id;
                                                $data['order_url']      = esc_url( $order_url );
                                                $data['prod_url']       = get_permalink($product_id);
                                                $data['prod_img']       = $attachment[0];
                                                $data['prod_name']      = $item["name"];
                                                $data['prod_qty']       = $item["quantity"];
                                                $data['prod_price']     = $item_sub_total;
                                                $data['review_id']      = $review_id;
                                                apply_filters( 'rx_review_edit_button', $data );
                                            }
                                                
                                        } else {
                                        
                                            if ( in_array( $check_order_status, $reviewx_order_status ) ) {
                                                echo '<p class="padding_5">
                                                    <a class="rx_my_account_submit_review rx-btn btn-primary btn-sm rx-form-primary-btn btn-review review-on btn-info rx-order-btn" 
                                                        data-product_id ="'.$product_id.' "
                                                        data-order="'.$order_count.'" 
                                                        data-order_status="'.esc_html__( wc_get_order_status_name( $order->get_status() ), 'reviewx' ).'" 
                                                        data-order_id="'.$item["order_id"].'"
                                                        data-order_url="'.esc_url( $order_url ).'"
                                                        data-product_url="'.get_permalink($product_id).'" 
                                                        data-product_img="'.esc_url($attachment[0]).'"
                                                        data-product_name="'.$item["name"].'" 
                                                        data-product_quantity="'.$item["quantity"].'" 
                                                        data-product_price="'.$item_sub_total.'" >'.
                                                            esc_html__('Submit review', 'reviewx' ).'
                                                    </a>
                                                </p>';
                                            }
                                        } 
                                    endif; ?>
                         </td>
                    <?php } //end foreach, column list ?>
                    </td>
                </tr>

                <?php
                    $order_count++; // increment order count
                        } // end foreach of order items
                    } //end foreach of customer_orders
                ?>
            </tbody>
        </table>
    </div>

    <?php
    /**
     * For order pagination
     */
    do_action( 'woocommerce_before_account_orders_pagination' );

    if ( 1 < $customer_orders->max_num_pages ) {
        ?>
        <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
            <?php if ( 1 !== $current_page ) : ?>
                <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'reviewx' ); ?></a>
            <?php endif; ?>

            <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
                <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'reviewx' ); ?></a>
            <?php endif; ?>
        </div>
    <?php
    } // end if

//end has_order
 } else {  ?>
        <div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		    <a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'reviewx' ); ?></a>
		    <?php esc_html_e( 'No order has been made yet.', 'reviewx' ); ?>
	    </div> 
<?php }

    do_action( 'woocommerce_after_account_orders', $has_orders );

    /**
     * Get and show value from admin setting page
     */
    $settings                   = \ReviewX\Controllers\Admin\Core\ReviewxMetaBox::get_option_settings();
    $review_criteria            = $settings->review_criteria;    
    $allow_review_title         = get_option('_rx_option_allow_review_title');  
    $allow_img                  = get_option( '_rx_option_allow_img' );
    $allow_recommendation       = get_option( '_rx_option_allow_recommendation' );
    $rating_style               = $settings->rating_style;
    $allow_video                = get_option( '_rx_option_allow_video' );
    $video_source               = get_option( '_rx_option_video_source' );    
    $allow_anonymouse           = get_option( '_rx_option_allow_anonymouse' );   

    /**
     * Show product review from from my account page
     */
    include('add-review.php');

    /*=================================
    *
    * Load review edit template
    *
    *==================================*/
    echo apply_filters( 'rx_edit_review_form', '' );
?>