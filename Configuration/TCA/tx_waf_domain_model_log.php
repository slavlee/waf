<?php

defined('TYPO3') or die;

$ll = 'LLL:EXT:waf/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_waf_domain_model_log',
        'label' => 'log_data',
        'crdate' => 'crdate',
        'versioningWS' => false,
        'iconfile' => 'EXT:waf/Resources/Public/Icons/Extension.svg',
        'adminOnly' => true,
        'hideTable' => true,
    ],
    'columns' => [
        'type' => [
            'label' => $ll . 'tx_waf_domain_model_log_type',
            'config' => [
                'type' => 'number',
                'default' => '0',
            ],
        ],
        'channel' => [
            'label' => $ll . 'tx_waf_domain_model_log_channel',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'default' => 'default',
                'required' => true,
                'max' => 120
            ],
        ],
        'log_data' => [
            'label' => $ll . 'tx_waf_domain_model_log_log_data',
            'config' => [
                'type' => 'text',
                'readonly' => true,
            ],
        ],
        'message' => [
            'label' => $ll . 'tx_waf_domain_model_log_message',
            'config' => [
                'type' => 'text',
                'readonly' => true,
                'max' => 255
            ],
        ],
    ],
    'types' => [
        0 => ['showitem' => 'type,channel,log_data,message'],
    ],
];
