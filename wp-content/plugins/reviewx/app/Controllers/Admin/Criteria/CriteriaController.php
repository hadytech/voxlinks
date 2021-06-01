<?php

namespace ReviewX\Controllers\Admin\Criteria;

use ReviewX\Controllers\Admin\Rating\ReCalculateReviewRating;
use ReviewX\Controllers\Controller;

/**
 * Class CriteriaController
 * @package ReviewX\Controllers\Admin\Criteria
 */
class CriteriaController extends Controller
{
    protected $currentCriteria;

    /**
     * @param $criteria
     */
    public function handleAction($criteria)
    {
        $this->setCurrentCriteria($criteria);

        $this->dispatchAction();
    }

    /**
     * @param $reviewId
     * @param $criterias
     * @param int $isAutomated
     * @param bool $shouldRecalCulate
     * @throws \WpFluent\Exception
     */
    public function storeCriteria($reviewId, $criterias, $isAutomated = 0, $shouldRecalCulate = true)
    {
        foreach ($criterias as $criteriaId => $rating) {
            $isAlreadyHave = wpFluent()->table('reviewx_criterias')->where('review_id', '=', $reviewId)
                             ->where('criteria_id', '=', $criteriaId)->first();
            if (! $isAlreadyHave) {
                wpFluent()->table('reviewx_criterias')->insert([
                    'review_id' => $reviewId,
                    'criteria_id' => $criteriaId,
                    'rating'    => intval($rating),
                    'is_automated' => $isAutomated
                ]);
            }
        }

        if ($shouldRecalCulate) {
            $this->singleReviewReCalculation($reviewId);
        }
    }

    /**
     * @param $reviewId
     * @param $criterias
     * @throws \WpFluent\Exception
     */
    public static function updateCriteria($reviewId, $criterias)
    {
        foreach ($criterias as $criteriaId => $rating) {
            wpFluent()->table('reviewx_criterias')->where('review_id', '=', $reviewId)
                ->where('criteria_id', '=', $criteriaId)->update([
                'rating'    => intval($rating)
            ]);
        }

        (new static())->singleReviewReCalculation($reviewId, false);
    }

    /**
     * Remove Criteria
     *
     * @param [type] $reviewId
     * @return void
     */
    public static function removeCriteria($reviewId)
    {
        wpFluent()->table('reviewx_criterias')->where('review_id', '=', $reviewId)->delete();
    }

    /**
     * @param $criteria
     */
    private function setCurrentCriteria($criteria)
    {
        $this->currentCriteria = $criteria;
    }

    /**
     * @return array|bool|mixed|void
     */
    private function getPreviousCriteria()
    {
        return get_option('_rx_option_review_criteria') ?: [];
    }

    /**
     * @return mixed
     */
    private function getCurrentCriteria()
    {
        return $this->currentCriteria;
    }

    /**
     * @return void
     */
    private function dispatchAction()
    {
        $previousCriteria = array_keys($this->getPreviousCriteria());
        $currentCriteria  = array_keys($this->getCurrentCriteria());


        $deleteFromPreviousCriteria = array_diff($previousCriteria, $currentCriteria);
        $createToCurrentCriteria    = array_diff($currentCriteria, $previousCriteria);

        if ($delPrevCount = count($deleteFromPreviousCriteria)) {
            $this->applyDeleteEvent($deleteFromPreviousCriteria);
        }

        if ($addCurCount = count($createToCurrentCriteria)) {
            $this->applyCreateEvent($createToCurrentCriteria);
        }

        if (! $delPrevCount && ! $addCurCount) {
            return;
        }

        $this->applyReCalculateAction();
        return;
    }

    /**
     * @return array|object|null
     * @throws \WpFluent\Exception
     */
    protected function getReviewIds()
    {
        return wpFluent()->table('reviewx_criterias')->selectDistinct(['review_id'])->get();
    }

    /**
     * @param $criteriaKeys
     * @throws \WpFluent\Exception
     */
    private function applyCreateEvent($criteriaKeys)
    {
        foreach ($criteriaKeys as $criteriaKey) {
            foreach ($this->getReviewIds() as $review) {
                wpFluent()->table('reviewx_criterias')->insert([
                    'review_id'     => $review->review_id,
                    'criteria_id'   => $criteriaKey,
                    'rating'        => 5,
                    'is_automated'  => 1
                ]);
            }
        }
    }

    /**
     * @param $criteriaKeys
     * @throws \WpFluent\Exception
     */
    private function applyDeleteEvent($criteriaKeys)
    {
        foreach ($criteriaKeys as $criteriaKey) {
            foreach ($this->getReviewIds() as $review) {
                wpFluent()->table('reviewx_criterias')
                    ->where('review_id', $review->review_id)
                    ->where('criteria_id', $criteriaKey)
                    ->delete();
                //Remove criteria from commenta meta
                $reviewx_rating = get_comment_meta($review->review_id, 'reviewx_rating', true);
                if( is_array($reviewx_rating) ) {
                    unset($reviewx_rating[$criteriaKey]); 
                    update_comment_meta($review->review_id, 'reviewx_rating', $reviewx_rating );
                }

            }
        }
    }

    /**
     * @throws \WpFluent\Exception
     */
    private function applyReCalculateAction()
    {
        wp_clear_scheduled_hook( 'rx_collect_review_id' );
        if ( ! wp_next_scheduled( 'rx_collect_review_id' ) ) {
            wp_schedule_single_event( time() + 120, 'rx_collect_review_id' );
        }
    }

    /**
     * when we do mannually
     * @param $reviewId
     * @param bool $previous
     */
    private function singleReviewReCalculation($reviewId, $previous = true)
    {
        (new ReCalculateReviewRating())->handleAction($reviewId, $previous);
    }
}