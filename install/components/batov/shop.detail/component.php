<?php

declare(strict_types = 1);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Batov\Shop\LaptopTable;
use Batov\Shop\ModelTable;
use Batov\Shop\VendorTable;
use Batov\Shop\LaptopOptionTable;
use Batov\Shop\OptionTable;
use Bitrix\Iblock\Component\Tools;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\UI\Extension;

Extension::load('ui.bootstrap4');
Loader::IncludeModule('batov.shop');
Loader::includeModule('iblock');

if (!isset($arParams['NOTEBOOK']) || empty($arParams['NOTEBOOK'])) {
    Tools::process404(
        '404',
        true,
        true,
        true,
        false
    );
}

$laptop = LaptopTable::getRow([
    'filter' => ['SLUG' => $arParams['NOTEBOOK']],
]);

if (empty($laptop)) {
    Tools::process404(
        '404',
        true,
        true,
        true,
        false
    );
}

$model = ModelTable::getRow([
    'filter' => ['ID' => $laptop['MODEL_ID']],
]);

$vendor = VendorTable::getRow([
    'filter' => ['ID' => $model['VENDOR_ID']],
]);

$laptopOptions = LaptopOptionTable::getList([
    'filter' => [
        'LAPTOP_ID' => $laptop['ID'],
    ],
]);

$optionIds = [];
$rows = $laptopOptions->fetchAll();
foreach ($rows as $row) {
    $optionIds[$row['OPTION_ID']] = $row['OPTION_ID'];
}

if (!empty($optionIds)) {
    $options = [];

    $optionRes = OptionTable::getList([
        'filter' => [
            'ID' => array_values($optionIds),
        ],
    ]);

    $names = [];
    while ($row = $optionRes->fetch()) {
        $names[$row['ID']] = $row['NAME'];
    }

    foreach ($rows as $row) {
        $options[$names[$row['OPTION_ID']]] = $row['VALUE'];
    }

    $arResult['OPTIONS'] = $options;
}

$arResult['MODEL'] = $model;
$arResult['VENDOR'] = $vendor;
$arResult['LAPTOP'] = $laptop;
$arResult['LAPTOP_OPTIONS'] = $laptopOptions;

$this->IncludeComponentTemplate();
