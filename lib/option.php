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
use Batov\Shop\LaptopTable;
use Bitrix\Main\Type\Date;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

Loc::loadMessages(__FILE__);

class OptionTable extends DataManager
{

    public static function getTableName()
    {
        return 'btsp_option';
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
                'title' => Loc::getMessage('BATOV_SHOP_OPTION_NAME'),
                'validation' => fn() => [new Validator\Length(null, 255)]
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
