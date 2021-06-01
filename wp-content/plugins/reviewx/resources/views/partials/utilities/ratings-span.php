<div class="rviwx-rating-column">
    <?php if( ! empty( $avg ) ) : ?>
    <div class="rviwx-rating-column__title">
        <div class="rviwx-rating-column__title-top">
            <span class="rviwx-rating-column__title-rating"><?php echo number_format($avg,1); ?></span>
            <svg style="width: 14px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path style="fill: #FFAF22" fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>
        </div>
        <div class="rviwx-rating-column__title-text">
            <?php esc_html_e('(avg)', 'reviewx'); ?>
        </div>
    </div>
    <?php endif; ?> 
    <?php if( \ReviewX_Helper::is_multi_criteria( get_post_type($post_id) ) ) { ?>   
    <div class="rviwx-rating-column__desc">
        <?php
        if( ! empty( $ratings ) ) {
            foreach ($ratings as $criteria => $rated) {
                ?>
                <div class="rviwx-rating-column__item">
                    <div class="rviwx-rating-column__item-label"><?php echo esc_html($criteria) . ':'; ?></div>
                    <div class="rviwx-rating-column__item-value">
                        <span class="rviwx-rating-column__item-rating"><?php echo ' ' . esc_html($rated); ?></span>
                        <svg style="width: 10px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star"
                             class="svg-inline--fa fa-star fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 576 512">
                            <path style="fill: #FFAF22" fill="currentColor"
                                  d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
                        </svg>

                    </div>
                </div>
                <?php
            }
        }else{
            esc_html_e( 'N/A', 'reviewx' );
        }
        ?>

    </div>
    <?php } ?>
</div>



