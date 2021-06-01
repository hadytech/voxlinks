<?php if(!empty($scores)): ?>
<div class="ai-score-details">
    <ul>
        <?php foreach ($scores as $name => $score): ?>
            <?php if($score !== null): ?>
                <li>
                    <?php echo ucfirst(str_replace('_',' ', $name)); ?>: <strong style="color: <?php echo Easyjobs_Helper::get_ai_score_color($name);?>"><?php echo $score; ?>%</strong>
                </li>
            <?php endif;?>
        <?php endforeach;?>
    </ul>
</div>
<?php endif; ?>