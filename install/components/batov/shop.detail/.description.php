<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    'NAME' => GetMessage('BATOV_SHOP_COMPONENT_DETAIL_NAME'),
    'DESCRIPTION' => GetMessage('BATOV_SHOP_COMPONENT_DETAIL_DESCRIPTION'),
    'PATH' => [
        'ID' => 'Shop',
        'NAME' => GetMessage('BATOV_SHOP_COMPONENT_NAME'),
    ],
];
