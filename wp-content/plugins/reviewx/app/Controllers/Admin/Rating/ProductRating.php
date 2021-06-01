<?php

namespace ReviewX\Controllers\Admin\Rating;

use ReviewX\Controllers\Controller;

/**
 * Class ProductRating
 * @package ReviewX\Controllers\Admin\Rating
 */
class ProductRating extends Controller
{
    /**
     * @param $newStatus
     * @param $oldStatus
     * @param $post
     */
    public function addRatingOption($newStatus, $oldStatus, $post)
    {
        global $post;
        if ($post && $post->post_type !== 'product') return;
        if ('publish' !== $newStatus or 'publish' === $oldStatus) return;

        $this->storeOption($post);
    }

    /**
     * @param $post
     * @param array $data
     */
    public function storeOption($post, $data = [])
    {
        add_option('_rx_product_'. $post->ID . '_rating', $data?: $this->prepareCriterias());
    }

    /**
     * @param $product
     * @throws \WpFluent\Exception
     */
    public function syncReviews($product)
    {
        $reviews = wpFluent()->table('comments')->where('comment_type', 'product')->where('comment_status', 1)
                   ->where('comment_post_ID', $product->ID)->get();

        $criteriaValues = $this->prepareCriterias();

        foreach ($reviews as $review) {
            $rating = get_comment_meta($review->comment_ID, 'rating', true);
            $criteriaRating = get_comment_meta($review->comment_ID, 'reviewx_rating', true);
            $criteriaValues['total_review'] += 1;
            $criteriaValues['total_rating'] += $rating;
            foreach ($criteriaRating as $key => $value) {
                $criteriaValues[$key] += $value;
            }
        }

        $this->storeOption($product, $criteriaValues);
    }

    /**
     * @return int[]
     */
    private function prepareCriterias()
    {
        $criterias = array_keys(get_option('_rx_option_review_criteria'));
        $criteriaValues = [
            'total_review' => 0,
            'total_rating' => 0,
        ];
        foreach ($criterias as $criteria) {
            $criteriaValues[$criteria] = 0;
        }

        return $criteriaValues;
    }
}