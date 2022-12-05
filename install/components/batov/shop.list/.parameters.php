<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loader::includeModule('iblock');
Loc::loadMessages(__FILE__);

$arComponentParameters = [
    'PARAMETERS' => [
        'BRAND' => [
            'PARENT' => 'BASE',
            'NAME' => GetMessage('BATOV_SHOP_COMPONENT_BRAND_SLUG'),
            'TYPE' => 'STRING',
        ],
        'MODEL' => [
            'PARENT' => 'BASE',
            'NAME' => GetMessage('BATOV_SHOP_COMPONENT_MODEL_SLUG'),
            'TYPE' => 'STRING',
        ],
    ],
];

CIBlockParameters::Add404Settings($arComponentParameters, []);