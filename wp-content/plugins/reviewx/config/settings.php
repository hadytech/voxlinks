<?php

return [
    'glue' => [
        'description' => __( 'This is a sample of extra config file.', 'reviewx' )
    ],
    'rxelements'   => [
        'rxcall-to-review' => [
            'class'      => \ReviewX\Elementor\Elements\Data_Tabs::class,            
        ],
        'rxcall-to-review-widget' => [            
            'class'      => \ReviewX\Elementor\Elements\Review_Widget::class,
        ],        
    ],
    'rxextensions' => [
        'rx-promotion'        => [
            'class' => '',
        ],
    ],
];
