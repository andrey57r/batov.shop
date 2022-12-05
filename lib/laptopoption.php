<?php

declare(strict_types=1);

namespace Batov\Shop;

use Batov\Shop\LaptopTable;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\Entity\StringField;

Loc::loadMessages(__FILE__);

class LaptopOptionTable extends DataManager
{

    public static function getTableName()
    {
        return 'btsp_laptop_option';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField('ID', [
                'autocomplete' => true,
                'primary' => true,
            ]),
            new IntegerField('LAPTOP_ID', [
                'primary' => true
            ]),
            new Reference(
                'LAPTOP',
                LaptopTable::class,
                Join::on('this.LAPTOP_ID', 'ref.ID')
            ),
            new IntegerField('OPTION_ID', [
                'primary' => true
            ]),
            new Reference(
                'OPTION',
                OptionTable::class,
                Join::on('this.OPTION_ID', 'ref.ID')
            ),
            new StringField('VALUE', [
                'required' => true,
                'title' => Loc::getMessage('BATOV_SHOP_LAPTOPOPTION_NAME'),
                'validation' => fn() => [new Validator\Length(null, 255)],
            ]),

        ];
    }
}
