<?php


namespace ReviewX\Controllers\Admin\Rating;

use ReviewX\Controllers\Admin\Criteria\CriteriaController;
use ReviewX\Controllers\Controller;

/**
 * Class ReCalculateReviewRating
 * @package ReviewX\Controllers\Admin\Rating
 */
class ReCalculateReviewRating extends Controller
{
    protected $reviewId;

    protected $criteria;

    protected $previous;

    /**
     * @param $reviewID
     * @param bool $previous
     */
    public function handleAction($reviewID, $previous = false)
    {
        
        $this->setReviewId($reviewID);
        $this->setPrevious($previous);
        $this->setCriteria();
        $this->dispatchAction();
    }

    /**
     * @param mixed $previous
     */
    public function setPrevious($previous)
    {
        $this->previous = $previous;
    }

    /**
     * @return mixed
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @param mixed $reviewId
     */
    public function setReviewId($reviewId)
    {
        $this->reviewId = $reviewId;
    }

    /**
     * @return mixed
     */
    public function getReviewId()
    {
        return $this->reviewId;
    }

    /**
     * @throws \WpFluent\Exception
     */
    protected function setCriteria()
    {
        if ($this->getPrevious()) {
            $criterias = \get_comment_meta($this->getReviewId(), 'reviewx_rating', true);
            (new CriteriaController())->storeCriteria($this->getReviewId(), $criterias, 0, false);
        }

        $this->criteria = wpFluent()->table('reviewx_criterias')->select(['criteria_id', 'rating'])
            ->where('review_id', '=',$this->getReviewId())
            ->get();
    }

    /**
     * @return mixed
     */
    protected function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Dispatch Action
     */
    protected function dispatchAction()
    {
        $this->updateRating();
        $this->updateIndividualRating();
    }

    /**
     * Update rating on meta
     */
    private function updateRating()
    {
        $review_rating = get_comment_meta($this->reviewId,'reviewx_rating', true);
        if( $review_rating ) {
            \update_comment_meta($this->reviewId,'rating', $this->calculateAverage());
        }        
    }

    /**
     * Update criteria on meta
     */
    private function updateIndividualRating()
    {
        $reviewx_rating = get_comment_meta($this->reviewId,'reviewx_rating', true);
        
        if( $reviewx_rating ) {
            \update_comment_meta($this->reviewId,'reviewx_rating', $this->prepareIndividualRating());
        } else {
            \update_comment_meta($this->reviewId,'reviewx_rating', $this->prepareDefaultReviewCriteria());
        }        
    }

    /**
     * Calculate avg
     * @return false|float
     */
    private function calculateAverage()
    {
        $criteria = $this->getCriteria();
        $totalRating = 0;
        $totalCriteria = 0;

        foreach ($criteria as $item) {
            $totalRating += $item->rating;
            $totalCriteria++;
        }

        return round(($totalRating/$totalCriteria), 2);
    }

    /**
     * Prepare Individual Rating
     * @return array
     */
    private function prepareIndividualRating()
    {
        $criteria = $this->getCriteria();
        $individualRating = [];

        foreach ($criteria as $item) {
            $individualRating[$item->criteria_id] = $item->rating;
        }

        return $individualRating;
    }

    /**
     * Prepare Default Review Rating
     * @return array
     */    
    private function prepareDefaultReviewCriteria() 
    {
        $rating         = [];
        $default_rating = get_comment_meta( $this->reviewId,'rating', true );
        $reviewx_rating = get_comment_meta( $this->reviewId,'reviewx_rating', true );
        $criteria       = get_option('_rx_option_review_criteria');
        if( is_array($criteria) ) {
            foreach( $criteria as $key => $value ) {
                $rating[$key] = $default_rating;
            }
        }        
        return $rating;
    }

}