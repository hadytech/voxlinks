<label>
    <select class="rx_filter">
        <?php foreach($options as $option) { ?>
            <option value="<?php echo esc_attr($option['value']); ?>"><?php esc_html_e($option['text'], $domain); ?></option>
        <?php } ?>
    </select>
</label>


