<?php 

    if( ! is_array( $value ) ) {
        $value = [
            'days'    => '',
            'hours'   => '',
            'minutes' => '',
            'seconds' => '',
        ];
    }

?>

<div class="rx-countdown-inputs">
    <div class="rx-countdown-input rx-days">
        <input placeholder="Days" step="1" min="0" max="31" id="<?php echo esc_attr( $name ); ?>[days]" type="number" name="<?php echo esc_attr( $name ); ?>[days]" value="<?php echo esc_attr( $value['days'] ); ?>">
    </div>
    <div class="rx-countdown-input rx-hours">
        <input placeholder="Hours" step="1" min="0" max="23" id="<?php echo esc_attr( $name ); ?>[hours]" type="number" name="<?php echo esc_attr( $name ); ?>[hours]" value="<?php echo esc_attr( $value['hours'] ); ?>">
    </div>
    <div class="rx-countdown-input rx-minutes">
        <input placeholder="Minutes" step="5" min="0" max="59" id="<?php echo esc_attr( $name ); ?>[minutes]" type="number" name="<?php echo esc_attr( $name ); ?>[minutes]" value="<?php echo esc_attr( $value['minutes'] ); ?>">
        </div>
    <div class="rx-countdown-input rx-seconds">
        <input placeholder="Seconds" step="10" min="0" max="59" id="<?php echo esc_attr( $name ); ?>[seconds]" type="number" name="<?php echo esc_attr( $name ); ?>[seconds]" value="<?php echo esc_attr( $value['seconds'] ); ?>">
    </div>
</div>