<?php


namespace ReviewX\Modules;

use ReviewX\Controllers\Admin\Core\ReviewxMetaBox;

class Gatekeeper
{
    private $review_status = [];

    /**
     * 
     *
     * @param [type] $productID
     * @param boolean $orderID
     * @return boolean
     */
    public static function hasPermit($productID, $orderID = false)
    {
        if (\is_user_logged_in()) {
            if ( class_exists('WooCommerce') && wc_customer_bought_product( '', get_current_user_id(), $productID ) && get_post_type( $productID ) == 'product' ) {
                $review_status['success'] = (new static())->getLogForVerifiedUser($productID, $orderID, get_current_user_id());                
                
                if( get_theme_mod('reviewx_re_reviewed_without_purchase_again') ) {
                    $review_status['msg'] = get_theme_mod('reviewx_re_reviewed_without_purchase_again');
                } else {
                    $review_status['msg'] = __( 'Once reviewed item can not be re-reviewed without purchase it again.', 'reviewx' );
                }

                return $review_status;

            } else if ( class_exists('Easy_Digital_Downloads') && get_post_type( $productID ) == 'download' && (new static())->edd_customer_bought_product( get_current_user_id(), $productID ) ) {                
                $review_status['success'] = (new static())->getLogForVerifiedUser($productID, $orderID, get_current_user_id());                
                
                if( get_theme_mod('reviewx_re_reviewed_without_purchase_again') ) {
                    $review_status['msg'] = get_theme_mod('reviewx_re_reviewed_without_purchase_again');
                } else {
                    $review_status['msg'] = __( 'Once reviewed item can not be re-reviewed without purchase it again.', 'reviewx' );
                }

                return $review_status;

            } else {
                if( get_post_type() == 'product' ) {
                    $review_status['success'] = (new static())->wcGuestPermission() && (new static())->getLogForNonVerifiedUser($productID);
                } else { 
                    $review_status['success'] = (new static())->getLogForNonVerifiedUser($productID);
                }

                if( (new static())->getLogForNonVerifiedUser($productID) ) {                    

                    if( get_theme_mod('reviewx_only_logged_customer_review') ) {
                        $review_status['msg'] = get_theme_mod('reviewx_only_logged_customer_review');
                    } else {
                        $review_status['msg'] = __( 'Only logged in customers who have purchased this product may leave a review.', 'reviewx' );
                    }

                } else {                    
                    if( get_theme_mod('reviewx_re_reviewed_without_purchase_it') ) {
                        $review_status['msg'] = get_theme_mod('reviewx_re_reviewed_without_purchase_it');
                    } else {
                        $review_status['msg'] = __( 'Once reviewed item can not be re-reviewed without purchase.', 'reviewx' );
                    }
                }
                
                return $review_status;
            }
        } else {
            if( get_post_type() == 'product' ) {
                
                //Check allow multiple review and unlock review for guest
                $allow_multiple_review = get_option( '_rx_option_allow_multiple_review' );
                if( \ReviewX_Helper::is_pro() && $allow_multiple_review == 1 ){
                    $review_status['success'] = (new static())->wcGuestPermission();  
                } else {
                    $review_status['success'] = (new static())->wcGuestPermission() && (new static())->getLogForGuest($productID);                  
                }
        
            } else {
                $review_status['success'] = (new static())->getLogForGuest($productID);
       
            }             
            
            $review_status['msg']= __( 'Only logged in customers who have purchased this product may leave a review.', 'reviewx' );
            return $review_status;
        }
    }

    /**
     * Set log for user
     *
     * @param [type] $productID
     * @param boolean $orderID
     * @param boolean $reviewID
     * @return void
     */
    public static function setLogForUser($productID, $orderID = false, $reviewID = false)
    {
        if (\is_user_logged_in()) {
            if ( class_exists('WooCommerce') && wc_customer_bought_product( '', get_current_user_id(), $productID ) && get_post_type( $productID ) == 'product' ) {                
                (new static())->setLogForVerifiedUser($productID, $orderID, $reviewID);
            } else if ( class_exists('Easy_Digital_Downloads') && (new static())->edd_customer_bought_product( get_current_user_id(), $productID ) && get_post_type( $productID ) == 'download' ) {
                update_option('verified_edd', $reviewID);
                (new static())->setLogForVerifiedUser($productID, $orderID, $reviewID);
            } else {
                update_option('unverified_edd', $reviewID);
                (new static())->setLogForNonVerifiedUser($productID, $reviewID);
            }
        } else {
            (new static())->setLogForGuest($productID, $reviewID);
        }
    }

    /**
     * Check order status
     *
     * @param [type] $orderID
     * @return void
     */
    private function checkOrderStatus($orderID)
    {
        $order = wc_get_order($orderID);
        $orderStatus = $order->get_status();
        $settings = ReviewxMetaBox::get_option_settings();
        $mapStatus = apply_filters('rx_wc_order_status', true );
        $orderStatuses = [];
        foreach ($mapStatus as $key => $label) {
            if ($settings->{$key} == 1) {
                $orderStatuses[] = $key;
            }
        }

        return in_array($orderStatus, $orderStatuses);
    }

    /**
     * Set log for verified user
     *
     * @param [type] $productID
     * @param [type] $orderID
     * @param [type] $reviewID
     * @return void
     */
    private function setLogForVerifiedUser($productID, $orderID, $reviewID)
    {
        if ($orderID) {
            $key = sprintf("RX_VERIFIED_%s_ORDER_%s_PRODUCT_%s", get_current_user_id(), $orderID, $productID);
            \update_option($key, 1);
            $this->reviewIssuedBy($reviewID, $key);

        } else if( get_post_type( $productID ) == 'download' ) {

            $orders = (new static())->getEDDOrders('', get_current_user_id(), $productID);
            foreach ($orders as $order_id) {
                $key = sprintf("RX_VERIFIED_%s_ORDER_%s_PRODUCT_%s", get_current_user_id(), $order_id, $productID);
                if (!get_option($key)) {
                    \update_option($key, 1);
                    $this->reviewIssuedBy($reviewID, $key);
                    return;
                }
            }

        } else {

            $orders = (new static())->getOrders('', get_current_user_id(), $productID);
            update_option('verified_wc', $orders);
            foreach ($orders as $order_id) {
                $key = sprintf("RX_VERIFIED_%s_ORDER_%s_PRODUCT_%s", get_current_user_id(), $order_id, $productID);
                if (!get_option($key)) {
                    \update_option($key, 1);
                    $this->reviewIssuedBy($reviewID, $key);
                    return;
                }
            }
        }
    }

    /**
     * Get log for verified user
     *
     * @param [type] $productID
     * @param [type] $orderID
     * @param [type] $userId
     * @return void
     */
    public function getLogForVerifiedUser($productID, $orderID, $userId)
    {
        if ($orderID) {
            $key = sprintf("RX_VERIFIED_%s_ORDER_%s_PRODUCT_%s", $userId, $orderID, $productID);
            return !get_option($key) && $this->checkOrderStatus($orderID);
        } else if( get_post_type( $productID ) == 'download' ) {            
           
            $orders = (new static())->getEDDOrders('', $userId, $productID);
            foreach ($orders as $order_id) {
                $key = sprintf("RX_VERIFIED_%s_ORDER_%s_PRODUCT_%s", $userId, $order_id, $productID);
                if (!get_option($key)) {
                    return true;
                }
            }

            return false; 
       
        } else {

            $orders = (new static())->getOrders('', $userId, $productID);
            foreach ($orders as $order_id) {
                $key = sprintf("RX_VERIFIED_%s_ORDER_%s_PRODUCT_%s", $userId, $order_id, $productID);
                if (!get_option($key)) {
                    return true && $this->checkOrderStatus($order_id);
                }
            }
            return false;
        }
    }

    /**
     * set log for non verified user
     *
     * @param [type] $productID
     * @param [type] $reviewId
     * @return void
     */
    private function setLogForNonVerifiedUser($productID, $reviewId)
    {
        $key = sprintf("RX_NON_VERIFIED_%s_PRODUCT_%s", get_current_user_id(), $productID);
        \update_option($key, 1);
        $this->reviewIssuedBy($reviewId, $key);
    }

    /**
     * Get log for non verified user
     *
     * @param [type] $productID
     * @return void
     */
    private function getLogForNonVerifiedUser($productID)
    {
        $key = sprintf("RX_NON_VERIFIED_%s_PRODUCT_%s", get_current_user_id(), $productID);
        return (! \get_option($key));
    }

    /**
     * Set log for guest
     *
     * @param [type] $productID
     * @param [type] $reviewId
     * @return void
     */
    private function setLogForGuest($productID, $reviewId)
    {
        $ipAddress = str_replace('.', '_', (new static())->getIP());
        $key = sprintf("RX_GUEST_%s_PRODUCT_%s", $ipAddress, $productID);
        \update_option($key, 1);
        $this->reviewIssuedBy($reviewId, $key);
    }

    /**
     * Get log for guest
     *
     * @param [type] $productID
     * @return void
     */
    private function getLogForGuest($productID)
    {
        $settings               = (array) ReviewxMetaBox::get_option_settings();
        $reviewx_order_status   = array();
        $wc_order_statuses      = apply_filters( 'rx_wc_order_status', true );
        foreach( $wc_order_statuses as $key => $value ) {
            if( array_key_exists($key, $settings) && $settings[$key] == 1 ){                    
               array_push($reviewx_order_status, $key);
            }                
        }        
        if (isset($_GET[REVIEWX_AUTOLOGIN_VALUE_NAME])) {    
            $autologin_code = preg_replace('/[^a-zA-Z0-9]+/', '', $_GET[REVIEWX_AUTOLOGIN_VALUE_NAME]);
            if($autologin_code) {
                if(strpos($autologin_code, "rxwcorder") !== false) {
                    $rxwcorder  = explode("rxwcorder", $autologin_code);
                    $order_id   = isset($rxwcorder[1])?$rxwcorder[1]: '';
                    $order 		= wc_get_order( $order_id );
                    $get_product_current_status = $order->get_status(); 
                    if( in_array($get_product_current_status, $reviewx_order_status) ) {
                        $check_already_reviewed = \ReviewX_Helper::check_already_reviewed( get_the_ID(), $order->get_billing_email(), $order_id );
                        if( empty( $check_already_reviewed ) ) {
                            return true;
                        }
                    }                           
                }    
            }
        }    
        $ipAddress = str_replace('.', '_', (new static())->getIP());
        $key = sprintf("RX_GUEST_%s_PRODUCT_%s", $ipAddress, $productID);
        return (! \get_option($key));
    }

    /**
     * Get IP
     *
     * @return void
     */
    private function getIP()
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        return $ipAddress;
    }

    /**
     * Get Orders
     *
     * @param [type] $customer_email
     * @param [type] $user_id
     * @param [type] $product_id
     * @return void
     */
    public function getOrders($customer_email, $user_id, $product_id)
    {
        
        $orderIds = [];
        $customer_orders    = wc_get_orders( array(
            'meta_key'      => '_customer_user',
            'meta_value'    => $user_id,
            'numberposts'   => -1
        ) );

        foreach( $customer_orders as $order ) {
            $orderIds[]     = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->ID;
        }

        $orderItems = [];

        if (count($orderIds)) {
            $orderItems = wpFluent()->table('woocommerce_order_items')
                                ->whereIn('order_id', $orderIds)
                                ->get();
        }

        $orders = [];

        foreach ($orderItems as $orderItem) {
            $getProductID = wc_get_order_item_meta($orderItem->order_item_id, '_product_id', true);
            if ((int)$getProductID == $product_id) {
                $orders[] = $orderItem->order_id;
            }
        }

        return array_map('absint', $orders);
    }

    /**
     * Get Orders
     *
     * @param [type] $customer_email
     * @param [type] $user_id
     * @param [type] $product_id
     * @return void
     */
    public function getEDDOrders($customer_email, $user_id, $product_id)
    {
        
        $customer    = new \EDD_Customer( $user_id, true ); 
        $emails      = $customer->emails;
        //Get order id, here is payment id 
        $payment_ids = explode( ',', $customer->payment_ids );
        $user_data   = get_userdata( $user_id );
        if( in_array($user_data->user_email,  $emails) ) {
            $payments    = edd_get_payments( array( 'post__in' => $payment_ids ) );
            $payments    = array_slice( $payments, 0, 10 );

            $orders = [];
            foreach( $payment_ids as $payment_id ) {
                //Retrieve payment history
                $payment      = new \EDD_Payment( $payment_id );
                $cart_items   = $payment->cart_details;

                if ( ! empty( $cart_items ) && is_array( $cart_items ) ) {
                    foreach ( $cart_items as $key => $cart_item ) {
                        $item_id    = isset( $cart_item['id'] ) ? $cart_item['id'] : $cart_item;
                        if( $item_id == $product_id ) {
                            $orders[] = $payment_id;
                        }
                    }
                }    
            }
        }

        return array_map('absint', $orders);
    }    

    /**
     * Get WooCommerce Permission
     *
     * @return void
     */
    private function wcGuestPermission()
    {
        return \get_option( 'woocommerce_review_rating_verification_required' ) === 'no';
    }

    /**
     * Get review issue by
     *
     * @param [type] $reviewId
     * @param [type] $key
     * @return void
     */
    private function reviewIssuedBy($reviewId, $key)
    {
        \update_comment_meta($reviewId, 'review_issued_by', $key);
    }

    /**
     * Remove log
     *
     * @param [type] $reviewId
     * @return void
     */
    public static function removeLog($reviewId)
    {
        $getIssueKey = \get_comment_meta($reviewId, 'review_issued_by', true);
        \delete_option($getIssueKey);
    }

    /**
     * Check purchase 
     *
     * @param [type] $reviewId
     * @return void
     */
    public static function edd_customer_bought_product( $userId, $productId )
    {        
        //Get customer details
        $customer    = new \EDD_Customer( $userId, true ); 
        $emails      = $customer->emails;
        //Get order id, here is payment id 
        $payment_ids = explode( ',', $customer->payment_ids );
        $user_data   = get_userdata( $userId );
        
        //Check logged in email is in the order history
        if( in_array($user_data->user_email,  $emails) ) {
            $payments    = edd_get_payments( array( 'post__in' => $payment_ids ) );
            $payments    = array_slice( $payments, 0, 10 );

            foreach( $payment_ids as $payment_id ) {
                //Retrieve payment history
                $payment      = new \EDD_Payment( $payment_id );
                $cart_items   = $payment->cart_details;

                if ( ! empty( $cart_items ) && is_array( $cart_items ) ) {
                    foreach ( $cart_items as $key => $cart_item ) {
                        $item_id    = isset( $cart_item['id'] ) ? $cart_item['id'] : $cart_item;
                        if( $item_id == $productId ) {                                   
                            return true;
                        }
                    }
                }
            }
        }
        
        return false;
    }

}