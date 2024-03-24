<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'WAF',
    'description' => 'Web Application Firewall for TYPO3 CMS.',
    'category' => 'misc',
    'author' => 'Kevin Chileong Lee',
    'author_email' => 'support@slavlee.de',
    'author_company' => 'Slavlee',
    'state' => 'beta',
    'version' => '0.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Slavlee\\Waf\\' => 'Classes',
        ],
    ],
];
