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
        'NOTEBOOK' => [
            'PARENT' => 'BASE',
            'NAME' => GetMessage('BATOV_SHOP_COMPONENT_LAPTOP_SLUG'),
            'TYPE' => 'STRING',
        ],
    ],
];

CIBlockParameters::Add404Settings($arComponentParameters, []);