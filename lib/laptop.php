<?php

declare(strict_types=1);

namespace Batov\Shop;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Batov\Shop\VendorTable;
use Bitrix\Main\Type\Date;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

Loc::loadMessages(__FILE__);

class LaptopTable extends DataManager
{

    public static function getTableName()
    {
        return 'btsp_laptop';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField('ID', [
                'autocomplete' => true,
                'primary' => true,
            ]),
            new StringField('NAME', [
                'required' => true,
                'title' => Loc::getMessage('BATOV_SHOP_LAPTOP_NAME'),
                'validation' => fn() => [new Validator\Length(null, 255)],
            ]),
            new IntegerField('MODEL_ID'),
            new Reference(
                'MODEL',
                VendorTable::class,
                Join::on('this.MODEL_ID', 'ref.ID')
            ),
            (new ManyToMany('OPTIONS', OptionTable::class))
                ->configureTableName('btsp_laptop_option'),
            new IntegerField('YEAR', [
                'required' => true,
                'default_value' => new Date(null, 'Y'),
            ]),
            new IntegerField('PRICE', [
                'required' => true,
            ]),
            new StringField('SLUG', [
                'required' => true,
                'title' => Loc::getMessage('BATOV_SHOP_LAPTOP_SLUG'),
                'validation' => fn() => [new Validator\Length(null, 255)],
            ]),
            new DatetimeField('UPDATED_AT', [
                'required' => true,
                'default_value' => new Date(),
            ]),
            new DatetimeField('CREATED_AT', [
                'required' => true,
                'default_value' => new Date(),
            ]),
        ];
    }
}
