<?php

declare(strict_types = 1);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Batov\Shop\VendorTable;
use Batov\Shop\ModelTable;
use Batov\Shop\LaptopTable;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Iblock\Component\Tools;
use Bitrix\Main\Grid\Options;

Loader::IncludeModule('batov.shop');
Loader::includeModule('iblock');

$gridOptions = new Options('report_list');
$sort = $gridOptions->GetSorting(['sort' => ['NAME' => 'ASC']]);
$navParams = $gridOptions->GetNavParams();

$nav = new PageNavigation('report_list');
$nav->allowAllRecords(true)
    ->setPageSize($navParams['nPageSize'])
    ->initFromUri();

$by = $_REQUEST['by'] ?? 'NAME';
$order = $_REQUEST['order'] ?? 'ASC';
$isLaptopsList = false;

if (isset($arParams['BRAND']) && !empty($arParams['BRAND'])) {
    $vendor = VendorTable::getRow([
        'filter' => ['SLUG' => $arParams['BRAND']],
    ]);

    if (empty($vendor)) {
        Tools::process404(
            '404',
            true,
            true,
            true,
            false
        );
    }

    if (isset($arParams['MODEL']) && !empty($arParams['MODEL'])) {
        $isLaptopsList = true;

        $model = ModelTable::getRow([
            'filter' => [
                'VENDOR_ID' => $vendor['ID'],
                'SLUG' => $arParams['MODEL'],
            ],
        ]);

        if (empty($model)) {
            Tools::process404(
                '404',
                true,
                true,
                true,
                false
            );
        }

        $res = LaptopTable::getList([
            'filter' => ['MODEL_ID' => $model['ID']],
            'order' => [strtoupper($by) => $order],
            'count_total' => true,
            'offset' => $nav->getOffset(),
            'limit' => $nav->getLimit(),
        ]);

        $arResult['COLUMNS'] = [
            [
                'id' => 'YEAR',
                'name' => GetMessage('BATOV_SHOP_COMPONENT_COLUMN_YEAR'),
                'sort' => 'YEAR',
                'default' => true,
            ],
            [
                'id' => 'PRICE',
                'name' => GetMessage('BATOV_SHOP_COMPONENT_COLUMN_PRICE'),
                'sort' => 'PRICE',
                'default' => true,
            ],
        ];
    } else {
        $res = ModelTable::getList([
            'filter' => ['VENDOR_ID' => $vendor['ID']],
            'order' => [strtoupper($by) => $order],
            'count_total' => true,
            'offset' => $nav->getOffset(),
            'limit' => $nav->getLimit(),
        ]);
    }
} else {
    $res = VendorTable::getList([
        'order' => [strtoupper($by) => $order],
        'count_total' => true,
        'offset' => $nav->getOffset(),
        'limit' => $nav->getLimit(),
    ]);
}

$nav->setRecordCount($res->getCount());

while ($row = $res->fetch()) {
    $columns = [];

    if ($isLaptopsList) {
        $path = str_replace($vendor['SLUG'] . '/' . $model['SLUG'], 'detail', $APPLICATION->GetCurPage());
        $link = '<a href="' . $path . $row['SLUG'] . '/">' . $row['NAME'] . '</a>';
        $columns['NAME'] = $link;
        $columns['YEAR'] = $row['YEAR'];
        $columns['PRICE'] = $row['PRICE'];

    } else {
        $link = '<a href="' . $APPLICATION->GetCurPage() . $row['SLUG'] . '/">' . $row['NAME'] . '</a>';
        $columns['NAME'] = $link;
    }

    $list[] = [
        'data' => $row,
        'columns' => $columns,
    ];
}

$arResult['LIST'] = $list;
$arResult['NAV'] = $nav;

$this->IncludeComponentTemplate();
