<?php

namespace ReviewX\Controllers\Admin\Email\Filter;

use Carbon\Carbon;
use ReviewX\Controllers\Admin\Email\Filter\Logic\DateRanges;
use ReviewX\Controllers\Admin\Email\Filter\Logic\SpecialConditions;


class Filterable
{
    use DateRanges, SpecialConditions;

    protected $request = [
        'date_range' => 'all_the_time',
        'order_status' => '',
        'categories' => [],
        'products' => [],
        'special_condition' => null
    ];

    protected $presetDateRanges = [
        'today',
        'yesterday',
        'last_week',
        'this_month',
        'last_month',
        'this_year',
        'last_year',
        'all_the_time',
        'custom_date'
    ];

    public $dateRanges = [];

    public function __construct($request)
    {
        $this->setRequest($request);
    }

    public function setRequest($params)
    {
        $this->request = array_merge($this->request, $params);

        return $this;
    }

    public function prepareDateRange()
    {
        $method = str_replace('_', '', ucwords($this->request['date_range'], '_'));
        $method = sprintf('getRange%s', $method);
        $this->dateRanges = $this->$method();
    }


    public function getOrderItems()
    {
        $this->prepareDateRange();

        // $scheduleUtcAt = (new Carbon($this->dateRanges[1], wp_timezone()));
        $scheduleUtcAt = (new \DateTime($this->dateRanges[1]))->setTimezone(new \DateTimeZone(wp_timezone_string()));

        $query = wpFluent()->table('woocommerce_order_items')
            ->join('posts', function ($query) {
                $query->on('posts.ID', '=', 'woocommerce_order_items.order_id');
            })
            ->whereBetween('posts.post_date', $this->dateRanges[0], $scheduleUtcAt->format('Y-m-d H:i:s'));

        if (!empty($this->request['order_status'])) {
            $query = $query->where('posts.post_status', '=', 'wc-' . $this->request['order_status']);
        }

        $orderItems = $query->get();

        $newOrderItems = [];

        foreach ($orderItems as $orderItem) {

            if (\ReviewX_Helper::is_pro()) {

                if (strlen($this->request['filter_by']) > 1) {
                    $getProductId = wc_get_order_item_meta($orderItem->order_item_id, '_product_id', true);

                    $categories = array_map(function ($category) {
                        return $category->term_id;
                    }, get_the_terms($getProductId, 'product_cat'));

                    if ($this->request['filter_by'] === 'by_category') {
                        if ($this->checkCategory($categories)) {
                            $newOrderItems[] = $orderItem;
                        }
                    }

                    if ($this->request['filter_by'] === 'by_products') {
                        if ($this->checkProduct($getProductId)) {
                            $newOrderItems[] = $orderItem;
                        }
                    }

                    if ($this->request['filter_by'] === 'by_both') {
                        if ($this->checkProduct($getProductId) && $this->checkCategory($categories)) {
                            $newOrderItems[] = $orderItem;
                        }
                    }

                    if ($this->request['filter_by'] === 'by_special_conditions') {
                        if ($this->checkSpecialConditions($getProductId)) {
                            $newOrderItems[] = $orderItem;
                        }
                    }
                } else {
                    $newOrderItems[] = $orderItem;
                }
            } else {
                $newOrderItems[] = $orderItem;
            }
        }

        return $newOrderItems;
    }

    private function checkProduct($productId)
    {
        if (! count($this->request['products'])) {
            return true;
        }

        return in_array($productId, $this->request['products'], true);
    }

    private function checkCategory($categories)
    {
        if (! count($this->request['categories'])) {
            return true;
        }

        foreach ($this->request['categories'] as $category) {
            if (in_array(intval($category), $categories, true)) {
                return true;
            }
        }

        return false;
    }

    private function checkSpecialConditions($productId)
    {
        if ($this->request['special_condition'] === 'most_reviewed') {
            return in_array(intval($productId), $this->getMostReviewedProducts(), true);
        }

        if ($this->request['special_condition'] === 'top_rated') {
            return in_array(intval($productId), $this->getTopRatedProducts(), true);
        }

        if ($this->request['special_condition'] === 'less_reviewed') {
            return in_array(intval($productId), $this->getLessReviewedProducts(), true);
        }

        if ($this->request['special_condition'] === 'less_rated') {
            return in_array(intval($productId), $this->getLessRatedProducts(), true);
        }

        return true;
    }


}