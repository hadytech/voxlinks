<table>
    <tbody>
    <tr data-id="easyjobs_api_key" id="easyjobs-meta-easyjobs_api_key" class="easyjobs-field easyjobs-meta-text type-text">
        <th class="easyjobs-label">
            <label><?php _e('Landing page with profile', EASYJOBS_TEXTDOMAIN);?></label>
        </th>
        <td class="easyjobs-control">
            <div class="easyjobs-control-wrapper ">
                <input class="easyjobs-settings-field" value="[easyjobs]">
                <span class="easyjobs-copy-shortcode">
                        <i class="dashicons dashicons-admin-page"></i>
                        <span class="easyjobs-copytext"><?php _e('Copy to clipboard', EASYJOBS_TEXTDOMAIN); ?></span>
                    </span>
            </div>
        </td>
    </tr>
    <tr data-id="easyjobs_api_key" id="easyjobs-meta-easyjobs_api_key" class="easyjobs-field easyjobs-meta-text type-text">
        <th class="easyjobs-label">
            <label><?php _e('All jobs list', EASYJOBS_TEXTDOMAIN);?></label>
        </th>
        <td class="easyjobs-control">
            <div class="easyjobs-control-wrapper ">
                <input class="easyjobs-settings-field" value="[easyjobs_list]">
                <span class="easyjobs-copy-shortcode">
                        <i class="dashicons dashicons-admin-page"></i>
                        <span class="easyjobs-copytext"><?php _e('Copy to clipboard', EASYJOBS_TEXTDOMAIN); ?></span>
                    </span>
            </div>
        </td>
    </tr>
    <?php if(!empty($jobs)): ?>
    <?php foreach ($jobs as $job): ?>
        <tr data-id="easyjobs_api_key" id="easyjobs-meta-easyjobs_api_key" class="easyjobs-field easyjobs-meta-text type-text">
            <th class="easyjobs-label">
                <label><?php echo $job->title; ?></label>
            </th>
            <td class="easyjobs-control">
                <div class="easyjobs-control-wrapper ">
                    <input class="easyjobs-settings-field" value="<?php echo '[easyjobs_details id='.$job->id.']'?>">
                    <span class="easyjobs-copy-shortcode">
                        <i class="dashicons dashicons-admin-page"></i>
                        <span class="easyjobs-copytext"><?php _e('Copy to clipboard', EASYJOBS_TEXTDOMAIN); ?></span>
                    </span>
                </div>
            </td>
        </tr>
<?php endforeach;?>
    <?php endif; ?>
    </tbody>
</table>
