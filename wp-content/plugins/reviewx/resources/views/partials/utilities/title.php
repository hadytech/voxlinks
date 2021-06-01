<?php
if( ! empty( $title ) ){
    echo esc_html( $title );
}else{
    esc_html_e( 'N/A', 'reviewx' );
}
?>