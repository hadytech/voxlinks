<?php 
    $message = isset( $field['message'] ) ? $field['message'] : '';
?>

<div class="rx-info-message">
    <?php echo esc_html_e( $message ); ?>
</div>