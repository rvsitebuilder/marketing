<?php

return [
    'BuildInLoginSave' => [
        'loginType' => 'The "login Type" field is required.',
    ],
    'SsoLoginSave' => [
        'loginType' => 'The "loginType" field is required.',
        'loginURL' => 'The "loginURL" field is required.',
        'logoutURL' => 'The "logoutURL" field is required.',
        'ipLength' => 'The "ipLength" field is required.',
        'secretKey' => 'The "secretKey" field is required.',
    ],
    'Sso' => [
        'sso1' => [
            'required' => 'The "Sso sso1" field is required.',
            'max' => 'The "Sso sso1" may not be greater than 1 character.',
        ],
        'sso2' => [
            'required' => 'The "Sso sso2" field is required.',
            'max' => 'The "Sso sso2" may not be greater than 1 character.',
        ],
    ],
    'Mkt' => [
        'Mkt1' => 'The "Mkt 1" field is required.',
        'Mkt2' => 'The "Mkt 2" field is required.',
    ],
    'StoreForm' => [
        'frmAttrId' => 'The "frmAttrId" field is required.',
        'pageId' => 'The "pageId" field is required.',
    ],
];
