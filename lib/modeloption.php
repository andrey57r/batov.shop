<?php

declare(strict_types=1);

namespace Batov\Shop;

use Batov\Shop\ModelTable;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Fields\Relations\Reference;

Loc::loadMessages(__FILE__);

class ModelOptionTable extends DataManager
{

    public static function getTableName()
    {
        return 'btsp_model_option';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField('ID', [
                'autocomplete' => true,
                'primary' => true,
            ]),
            new IntegerField('MODEL_ID', [
                'primary' => true
            ]),
            new Reference(
                'MODEL',
                ModelTable::class,
                Join::on('this.MODEL_ID', 'ref.ID')
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
                'title' => Loc::getMessage('BATOV_SHOP_MODELOPTION_NAME'),
                'validation' => fn() => [new Validator\Length(null, 255)],
            ]),

        ];
    }
}
