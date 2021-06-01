<?php

return [
    'env'       => 'dev',
    'asset_url' => null, // if you want to change media storage, then set url here
    'activator' => \ReviewX\Modules\Activator::class,
    'deactivator' => \ReviewX\Modules\Deactivator::class,
    'providers' => [
        'core' => [
            \JoulesLabs\Warehouse\Foundation\AppProvider::class,
            \JoulesLabs\Warehouse\Config\ConfigProvider::class,
            \JoulesLabs\Warehouse\Request\RequestProvider::class,
            \JoulesLabs\Warehouse\View\ViewProvider::class,
        ],

        'plugin' => [
            'common' => [
                \ReviewX\Providers\WpFluentProvider::class,
            ],

            'backend' => [
            ],

            'frontend' => [
            ],
        ],
    ],
];
