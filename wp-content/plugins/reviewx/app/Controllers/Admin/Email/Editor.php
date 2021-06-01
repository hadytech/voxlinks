<?php

namespace ReviewX\Controllers\Admin\Email;

use ReviewX\Controllers\Controller;

/**
 * Class Editor
 * @package ReviewX\Controllers\Admin\Email
 */
class Editor extends Controller
{
    protected $orderId;
    protected $orderItems = [];
    protected $order;
    protected $customer;
    protected $emailText;
    protected $userId;

    public function __construct($orderId, $orderItems, $emailText)
    {
        $userId = get_post_meta($orderId, '_customer_user', true);
        $this->setCustomer($userId);
        $this->userId = $userId;
        $this->setOrderId($orderId);
        $this->setOrderItems($orderItems);
        $this->setEmailText($emailText);
        $this->setOrder($orderId);
                
    }

    /**
     * @return string[]
     */
    public function defaultKeys()
    {
        return [
            'SHOP_NAME',
            'CUSTOMER_NAME',
            'MY_ORDERS_PAGE',
            'ORDER_ID',
            'ORDER_DATE',
            'ORDER_ITEMS',
            'UNSUBSCRIBE_LINK'
        ];
    }

    /**
     * @return string[]
     */
    public function defaultBehaviour()
    {
        return [
            'SHOP_NAME' => 'text',
            'CUSTOMER_NAME' => 'text',
            'MY_ORDERS_PAGE' => 'link',
            'ORDER_ID' => 'link',
            'ORDER_DATE' => 'date',
            'ORDER_ITEMS' => 'link',
            'UNSUBSCRIBE_LINK' => 'link',
        ];
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderItems
     */
    public function setOrderItems($orderItems)
    {
        foreach ($orderItems as $orderItem) {
            $product = get_post($orderItem);
            if( $this->userId != 0 ){
                $auto_login = get_user_meta( $this->userId, 'rx_autologin_code', true );
                if( !empty($auto_login) ){ 
                    $product_url = get_permalink($orderItem); 
                    $this->orderItems[$product->post_title] = $product_url."?rx_autologin_code=$auto_login";
                } else {
                    $this->orderItems[$product->post_title] = get_permalink($orderItem);
                }
            } else if( $this->userId == 0 ) {
                $product_url = get_permalink($orderItem); 
                $auto_login = 'rx_wc_order_'.$this->orderId.'';
                $this->orderItems[$product->post_title] = $product_url."?rx_autologin_code=$auto_login";
            } else {
                $this->orderItems[$product->post_title] = get_permalink($orderItem);
            }
                        
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * @param $orderId
     */
    public function setOrder($orderId)
    {
        $this->order = \get_post($orderId) ?: null;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param $customerId
     * @return $this
     */
    public function setCustomer($customerId)
    {
        $this->customer = \get_user_meta($customerId) ?: [];
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $emailText
     */
    public function setEmailText($emailText)
    {
        $this->emailText = $emailText;
    }

    /**
     * @return mixed
     */
    public function getEmailText()
    {
        return $this->emailText;
    }

    /**
     * @param array $extended
     * @return mixed
     */
    public function prepareEmail($extended = [])
    {
        $behaviour = (new Behaviour());
        $defaultBehaviour = $this->defaultBehaviour();
        $data = array_merge($this->prepareData(), $extended);

        foreach ($data as $key => $value) {
            $behaviourMethod = sprintf('get%s', ucfirst($defaultBehaviour[$key]));
            $this->setEmailText(str_replace("[{$key}]", call_user_func_array([$behaviour, $behaviourMethod], [$data[$key]]), $this->getEmailText()));
        }

        return $this->getEmailText();
    }

    /**
     * @return array
     */
    private function prepareData()
    {
        $data = [];
        foreach ($this->defaultKeys() as $key) {
            $methodName = sprintf('get_%s', strtolower($key));
            $data[$key] = call_user_func([$this, $methodName]);
        }
        return $data;
    }

    /**
     * @return string|void
     */
    private function get_shop_name()
    {
        return \get_bloginfo('name');
    }

    /**
     * @return string
     */
    private function get_customer_name()
    {
        $customer = $this->getCustomer();
        if (! empty($customer)) {
            return sprintf('%s %s', \_get($customer['first_name'][0], ''), \_get($customer['last_name'][0], ''));
        }
        return '';
    }

    /**
     * @return array
     */
    private function get_my_orders_page()
    {
        $order_page = esc_html__('Orders Page', 'reviewx' );
        if( $this->userId != 0 ){
            $auto_login = get_user_meta( $this->userId, 'rx_autologin_code', true );
            if( !empty($auto_login) ){         
                return [
                    $order_page =>  \wc_get_account_endpoint_url('orders') ."?rx_autologin_code=$auto_login"
                ];
            } else {
                return [
                    $order_page => \wc_get_account_endpoint_url('orders')
                ];
            }
        } else if( $this->userId == 0 ){
            $auto_login = 'rx_wc_order_'.$this->orderId.'';
            $view_order = wc_get_order($this->getOrderId())->get_checkout_order_received_url();
            return [
                $order_page =>  $view_order."&rx_autologin_code=$auto_login"
            ];
        } else {
            return [
                $order_page => \wc_get_account_endpoint_url('orders')
            ];
        }

    }

    /**
     * @return array
     */
    private function get_order_id()
    {
        $auto_login = 'rx_wc_order_'.$this->orderId.'';
        if( $this->userId != 0 ){
            $auto_login = get_user_meta( $this->userId, 'rx_autologin_code', true );
            if( !empty($auto_login) ){ 
                $view_order = wc_get_order($this->getOrderId())->get_view_order_url()."&rx_autologin_code=$auto_login";
                return [
                    ("#" . $this->getOrderId()) => $view_order
                ];
            } else {
                return [
                    ("#" . $this->getOrderId()) => wc_get_order($this->getOrderId())->get_view_order_url()
                ];
            } 
        } else if( $this->userId == 0 ){
            $view_order = wc_get_order($this->getOrderId())->get_checkout_order_received_url()."&rx_autologin_code=$auto_login";
            return [
                ("#" . $this->getOrderId()) => $view_order
            ];
                   
        } else {
            return [
                ("#" . $this->getOrderId()) => wc_get_order($this->getOrderId())->get_view_order_url()
            ];
        }
      
    }

    /**
     * @return string|null
     */
    private function get_order_date()
    {
        if ($order = $this->getOrder()) {
            return $order->post_date;
        }
        return null;
    }

    /**
     * @return array|mixed
     */
    private function get_order_items()
    {
        return $this->getOrderItems();
    }

    /**
     * unsubscribe url
     *
     * @return array
     */
    private function get_unsubscribe_link()
    {
        $orderKey = base64_encode($this->getOrderId());
        $url = parse_url(get_option('_rx_option_unsubscribe_url'));
        if (! empty($url['query'])) {
            $url['query'] = $url['query'] . '&order=' . $orderKey;
        } else {
            $url['query'] = 'order=' . $orderKey;
        }

        $unsubscribeText = esc_html__('unsubscribe', 'reviewx' );
        return [
            $unsubscribeText => build_url($url)
        ];
    }
}