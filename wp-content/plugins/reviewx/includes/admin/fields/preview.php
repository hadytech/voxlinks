
<table class="rx-preview-publish">
    <thead>
        <tr>
            <th><?php esc_html_e( 'Feature', 'reviewx' ); ?></th>
            <th><?php esc_html_e( 'Status', 'reviewx' ); ?></th>
        </tr>
    </thead>
    <tbody>       
        <?php if( is_array($field['content']) ):
            foreach( $field['content'] as $content): ?>
                <tr>
                    <td> 
                        <span class="rx-table-icon">
                            <?php echo $content['icon']; ?>
                        </span>
                        <span class="rx-table-text">
                            <?php echo $content['label']; ?>
                        </span>                                                
                    </td>
                    <?php if( is_array($content['value']) ) { ?>
                    <td>
                        <ul style="display: inline-block; margin: 0">
                            <?php foreach($content['value'] as $key => $value ){ ?>
                            <li id="rx-wc-<?php echo $key; ?>" class="rx-wc-order-status" style="float: left; margin-right: 10px; margin-bottom:0" data-order-key="<?php echo $key; ?>" data-order-label="<?php echo $value; ?>"></li>
                            <?php } ?>
                        </ul>
                    </td>
                    <?php } else { ?>
                        <td id="<?php echo $content['id']; ?>">
                            <?php 
                                if( ! empty($content['value']) ) { 
                                    echo $content['value'];
                                }
                            ?>
                        </td>
                    <?php } ?>    
                </tr>            
        <?php endforeach; ?>        
        <?php endif; ?>    
    </tbody>
</table>