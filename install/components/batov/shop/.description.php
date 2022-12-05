<?php

declare(strict_types = 1);

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    'NAME' => GetMessage('BATOV_SHOP_COMPONENT_COMPLEX_NAME'),
    'DESCRIPTION' => GetMessage('BATOV_SHOP_COMPONENT_COMPLEX_DESCRIPTION'),
    'PATH' => [
        'ID' => 'Shop',
        'NAME' => GetMessage('BATOV_SHOP_COMPONENT_NAME'),
    ],
];
