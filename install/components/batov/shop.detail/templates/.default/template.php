<?php

declare(strict_types = 1);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

?>

<div class="container">
    <h1><?php echo $arResult['LAPTOP']['NAME']; ?></h1>
</div>


<div class="container">
    <div class="row">
        <div class="col-3">
            <img alt="" src="https://via.placeholder.com/200">
        </div>
        <div class="col-9">

            <table class="table">
                <tr>
                    <td><?php echo GetMessage('BATOV_SHOP_OPTION_VENDOR'); ?></td>
                    <td><?php echo $arResult['VENDOR']['NAME'] ?></td>
                </tr>
                <tr>
                    <td><?php echo GetMessage('BATOV_SHOP_OPTION_MODEL'); ?></td>
                    <td><?php echo $arResult['MODEL']['NAME'] ?></td>
                </tr>
                <tr>
                    <td><?php echo GetMessage('BATOV_SHOP_OPTION_YEAR'); ?></td>
                    <td><?php echo $arResult['LAPTOP']['YEAR'] ?></td>
                </tr>
                <tr>
                    <td><?php echo GetMessage('BATOV_SHOP_OPTION_PRICE'); ?></td>
                    <td><strong><?php echo $arResult['LAPTOP']['PRICE'] ?>€</strong></td>
                </tr>
                <?php foreach ($arResult['OPTIONS'] as $name => $value): ?>
                    <tr>
                        <td><?php echo GetMessage('BATOV_SHOP_OPTION_' . strtoupper($name)); ?></td>
                        <td><?php echo $value; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</div>


