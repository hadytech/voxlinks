<?php add_thickbox(); ?>
<div id="my-content-id" style="display:none;">
    <div class="rx_erf_item">
        <div class="rx_label"> <?php echo __( 'Orders Date Range:', 'reviewx' ); ?> </div>
        <div class="rx_content">
            <select class="select-css" id="date_range">
                <option value="all_the_time"><?php echo __( 'All the Time', 'reviewx' ); ?></option>
                <option value="yesterday"><?php echo __( 'Yesterday', 'reviewx' ); ?></option>
                <option value="last_week"><?php echo __( 'Last Week', 'reviewx' ); ?></option>
                <option value="this_month"><?php echo __( 'This Month', 'reviewx' ); ?></option>
                <option value="last_month"><?php echo __( 'Last Month', 'reviewx' ); ?></option>
                <option value="this_year"><?php echo __( 'This Year', 'reviewx' ); ?></option>
                <option value="last_year"><?php echo __( 'Last year', 'reviewx' ); ?></option>
                <option value="custom_date"><?php echo __( 'Custom Date', 'reviewx' ); ?></option>
            </select>
        </div>
    </div>

    <div class="rx_erf_item">
        <div class="rx_label"><?php echo __( 'Custom Date Range:', 'reviewx' ); ?> </div>
        <div class="rx_content">
            <input type="datetime-local" placeholder="Start Datetime" id="start_datetime" class="te_input">
            <input type="datetime-local" placeholder="End Datetime" id="end_datetime" class="te_input">
        </div>
    </div>

    <div class="rx_erf_item">
        <div class="rx_label"><?php echo __( 'Select Order Status:', 'reviewx' ); ?> </div>
        <div class="rx_content">
            <select class="select-css">
                <option><?php echo __( 'Completed', 'reviewx' ); ?></option>
                <option><?php echo __( 'Processing', 'reviewx' ); ?></option>
            </select>
        </div>
    </div>

    <div class="rx_erf_item">
        <div class="rx_label"><?php echo __( 'Filter Products', 'reviewx' ); ?></div>
        <div class="rx_content">
            <div>
                <label>
                    <input type="checkbox" checked="">
                    <span></span>
                </label>
            </div>
        </div>
    </div>

    <div class="rx_erf_item">
        <div class="rx_label"><?php echo __( 'Filter By:', 'reviewx' ); ?> </div>
        <div class="rx_content">
            <select class="select-css">
                <option><?php echo __( 'By Category', 'reviewx' ); ?></option>
                <option><?php echo __( 'By product(s)', 'reviewx' ); ?></option>
                <option><?php echo __( 'Special Conditions', 'reviewx' ); ?></option>
            </select>
        </div>
    </div>

    <div class="rx_erf_item">
        <div class="rx_label">Filter By: </div>
        <div class="rx_content">
            <select class="select-css">
                <option><?php echo __( 'Most reviewed product', 'reviewx' ); ?></option>
                <option><?php echo __( 'Lowest reviewed product', 'reviewx' ); ?></option>
                <option><?php echo __( 'Products with highest price', 'reviewx' ); ?></option>
                <option><?php echo __( 'Products with lowest price', 'reviewx' ); ?></option>
                <option><?php echo __( 'Products with max. quantity', 'reviewx' ); ?></option>
                <option><?php echo __( 'Products with min. quantity', 'reviewx' ); ?></option>
            </select>
        </div>
    </div>

    <div class="rx_erf_item">
        <div class="rx_label"><?php echo __( 'Filter Products', 'reviewx' ); ?></div>
        <div class="rx_content">
            <div>
                <label>
                    <input type="checkbox" checked="">
                    <span></span>
                </label>
            </div>
        </div>
    </div>
</div>

<a href="#TB_inline?&width=600&height=550&inlineId=my-content-id" class="thickbox"><?php echo __( 'View content!', 'reviewx' ); ?></a>

