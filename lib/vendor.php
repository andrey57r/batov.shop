<?php

declare(strict_types=1);

namespace Batov\Shop;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\Type\Date;
use Batov\Shop\OptionTable;

Loc::loadMessages(__FILE__);

class VendorTable extends DataManager
{

    public static function getTableName()
    {
        return 'btsp_vendor';
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
                'title' => Loc::getMessage('BATOV_SHOP_VENDOR_NAME'),
                'validation' => fn() => [new Validator\Length(null, 255)],
            ]),
            new StringField('SLUG', [
                'required' => true,
                'title' => Loc::getMessage('BATOV_SHOP_VENDOR_SLUG'),
                'validation' => fn() => [new Validator\Length(null, 255)],
            ]),
            new DatetimeField('UPDATED_AT', [
                'required' => true,
                'default_value' => new Date()
            ]),
            new DatetimeField('CREATED_AT', [
                'required' => true,
                'default_value' => new Date()
            ]),
        ];
    }
}
