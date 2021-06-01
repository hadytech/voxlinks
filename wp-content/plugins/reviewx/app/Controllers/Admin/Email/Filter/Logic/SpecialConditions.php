<?php

namespace ReviewX\Controllers\Admin\Email\Filter\Logic;

use WpFluent\QueryBuilder\Raw;

trait SpecialConditions
{
    public function getMostReviewedProducts()
    {
        global $wpdb;
        $results = $wpdb->get_results($this->reviewedQuery('DESC'));

        return array_map(function ($item) {
            return intval($item->product_id);
        }, $results);
    }

    public function getLessReviewedProducts()
    {
        global $wpdb;
        $results = $wpdb->get_results($this->reviewedQuery('ASC'));

        return array_map(function ($item) {
            return intval($item->product_id);
        }, $results);
    }

    public function getTopRatedProducts()
    {
        global $wpdb;
        $results = $wpdb->get_results($this->ratedQuery('DESC'));

        return array_map(function ($item) {
            return intval($item->product_id);
        }, $results);
    }

    public function getLessRatedProducts()
    {
        global $wpdb;
        $results = $wpdb->get_results($this->ratedQuery('ASC'));

        return array_map(function ($item) {
            return intval($item->product_id);
        }, $results);
    }

    private function reviewedQuery($order)
    {
        global $wpdb;

        return "select c.comment_post_ID as product_id, count(*) as rating from {$wpdb->prefix}comments as c
        where c.comment_type = 'review' and c.comment_approved not in ('trash', 'spam')
        group by c.comment_post_ID
        order by rating $order
        limit 1";

    }

    public function ratedQuery($order)
    {
        global $wpdb;

        return "select c.comment_post_ID as product_id, sum(rc.rating) / count(*) as rating from {$wpdb->prefix}comments as c
        inner join {$wpdb->prefix}reviewx_criterias as rc on rc.review_id = c.comment_ID
        where c.comment_type = 'review' and c.comment_approved not in ('trash', 'spam')
        group by c.comment_post_ID
        order by rating $order
        limit 1";
    }
    
}