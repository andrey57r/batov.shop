<?php

use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arCurrentValues */
Loader::includeModule('iblock');

$arComponentParameters = [
    "PARAMETERS" => [
        "SEF_MODE" => [
            //"models" => [
            //    "NAME" => 'Список моделей',
            //    "DEFAULT" => "#BRAND#/",
            //    "VARIABLES" => [
            //        "BRAND",
            //    ],
            //],
            //"laptops" => [
            //    "NAME" => 'Список ноутбуков',
            //    "DEFAULT" => "#BRAND#/#MODEL#/",
            //    "VARIABLES" => [
            //        "BRAND",
            //        "MODEL",
            //    ],
            //],
            //"element" => [
            //    "NAME" => 'Детальная страница',
            //    "DEFAULT" => "detail/#NOTEBOOK#/",
            //    "VARIABLES" => [
            //        "NOTEBOOK",
            //    ],
            //],
        ],
    ],
];

CIBlockParameters::Add404Settings($arComponentParameters, []);