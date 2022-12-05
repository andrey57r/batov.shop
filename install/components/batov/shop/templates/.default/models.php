<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent(
    'batov:shop.list',
    '.default',
    [
        'BRAND' => $arResult['VARIABLES']['BRAND'],
    ],
    $component
);