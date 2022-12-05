<?php

declare(strict_types = 1);

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$menu = [
    [
        'parent_menu' => 'global_menu_content',
        'sort' => 100,
        'text' => Loc::getMessage('BATOV_SHOP_MENU_TITLE'),
        'title' => Loc::getMessage('BATOV_SHOP_MENU_TITLE'),
        'url' => 'SHOP_index.php',
        'items_id' => 'menu_references',
    ],
];

return $menu;