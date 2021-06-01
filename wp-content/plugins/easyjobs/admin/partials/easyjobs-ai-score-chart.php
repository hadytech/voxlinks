<?php if(!empty($scores)): ?>
    <div class="easyjobs-ai-chart">
        <svg width="100%" height="100%" viewBox="0 0 36 36" class="donut" style="width: 100px; height: 100px">
            <circle class="donut-hole" cx="18" cy="18" r="18" fill="none"></circle>
            <?php echo Easyjobs_Helper::get_ai_score_circles($scores); ?>
        </svg>
    </div>
<?php endif; ?>