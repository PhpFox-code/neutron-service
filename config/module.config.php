<?php

namespace Phpfox\Service;

return [
    'services' => [
        'map' => [
            'serviceManager' => [
                null,
                ServiceManager::class,
            ],
        ],
    ],
    'events'   => [
        'map' => [
            'onApplicationConfigChanged' => ['serviceManager'],
        ],
    ],
];