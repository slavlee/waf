<?php

return [
    'frontend' => [
        'slavlee/waf/firewall' => [
            'target' => \Slavlee\Waf\Middleware\FrontendFirewall::class,
            'before' => [
                'typo3/cms-frontend/timetracker',
            ],
        ],
    ],
];
