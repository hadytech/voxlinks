<div class="rx-analytics-header-counter-wrapper">
    <div class="rx-header-analytics-counter-wrapper">
        <div>
            <div class="rx-header-analytics-counter">
                <a href="#">
                    <span class="rx-counter-icon">
                        <img src="<?php echo esc_url(assets("admin/images/icons/reviews.png")); ?>" alt="<?php esc_attr_e( 'Total Reviews', 'reviewx' );?>">
                    </span>
                    <div>
                        <span class="rx-counter-number"><?php echo esc_html( $totalReviews ) ?></span>
                        <span class="rx-counter-label"><?php esc_html_e( 'Total Reviews', 'reviewx' ); ?></span>
                    </div>
                </a>
            </div>
        </div>
        <div>
            <div class="rx-header-analytics-counter">
                <a href="#">
                    <span class="rx-counter-icon">
                        <img src="<?php echo esc_url(assets("admin/images/icons/product_reviewed.png")); ?>" alt="<?php esc_attr_e( 'Total Product/Post Reviewed', 'reviewx' );?>">
                    </span>
                    <div>
                        <span class="rx-counter-number"><?php echo esc_html( $totalProducts ) ?></span>
                        <span class="rx-counter-label"><?php esc_html_e( 'Total Product/Post Reviewed', 'reviewx' ); ?></span>
                    </div>
                </a>
            </div>
        </div>
        <div>
            <div class="rx-header-analytics-counter">
                <a href="#">
                    <span class="rx-counter-icon">
                        <img src="<?php echo esc_url(assets("admin/images/icons/product_reviewer.png")); ?>" alt="<?php esc_attr_e( 'Total Product/Post Reviewers', 'reviewx' );?>">
                    </span>
                    <div>
                        <span class="rx-counter-number"><?php echo esc_html( $totalReviewers); ?></span>
                        <span class="rx-counter-label"><?php esc_html_e( 'Total Product/Post Reviewers', 'reviewx' ); ?></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>