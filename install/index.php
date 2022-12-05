<?php

declare(strict_types = 1);

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Batov\Shop\VendorTable;
use Batov\Shop\ModelTable;
use Batov\Shop\LaptopTable;
use Batov\Shop\OptionTable;
use Batov\Shop\LaptopOptionTable;
use Batov\Shop\ModelOptionTable;
use Batov\Shop\Import;

Loc::loadMessages(__FILE__);

class batov_shop extends CModule
{
    public function __construct()
    {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_ID = str_replace('_', '.', get_class($this));
        $this->MODULE_NAME = Loc::getMessage('BATOV_SHOP_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('BATOV_SHOP_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('BATOV_SHOP_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('BATOV_SHOP_MODULE_PARTNER_URI');
    }

    public function doInstall(): void
    {
        global $USER, $APPLICATION, $step;

        if (!CheckVersion(ModuleManager::getVersion('main'), '14.00.00')) {
            $APPLICATION->ThrowException(Loc::getMessage('BATOV_SHOP_INSTALL_ERROR_VERSION'));
        }

        if ($USER->IsAdmin()) {
            $step = (int)$step;
            if ($step < 2) {
                $APPLICATION->IncludeAdminFile(Loc::getMessage("BATOV_SHOP_INSTALL_TITLE"), __DIR__ . "/step1.php");
            } elseif ($step === 2) {
                if (!IsModuleInstalled($this->MODULE_ID)) {
                    ModuleManager::registerModule($this->MODULE_ID);

                    $this->installDB(isset($_REQUEST['clear_db']) && $_REQUEST['clear_db'] === 'Y');
                    $this->installFiles();

                    $GLOBALS["errors"] = $this->errors;
                    $APPLICATION->IncludeAdminFile(Loc::getMessage("BATOV_SHOP_INSTALL_TITLE"), __DIR__ . "/step2.php");
                }
            }
        }
    }

    public function doUninstall(): void
    {
        global $USER, $APPLICATION, $step;

        if ($USER->IsAdmin()) {
            $step = (int)$step;
            if ($step < 2) {
                $APPLICATION->IncludeAdminFile(Loc::getMessage("BATOV_SHOP_UNINSTALL_TITLE"), __DIR__ . "/unstep1.php");
            } elseif ($step === 2) {
                if (!isset($_REQUEST['savedata']) || $_REQUEST['savedata'] !== 'Y') {
                    $this->uninstallDB();
                }

                ModuleManager::unRegisterModule($this->MODULE_ID);

                $GLOBALS["errors"] = $this->errors;
                $APPLICATION->IncludeAdminFile(
                    Loc::getMessage("BATOV_SHOP_UNINSTALL_TITLE"),
                    __DIR__ . "/unstep2.php"
                );
            }
        }
    }

    public function installDB(bool $clearDb = false): void
    {
        if (!Loader::includeModule($this->MODULE_ID)) {
            return;
        }

        if ($clearDb) {
            $this->uninstallDB();
            $this->createTables();
            $this->importData();
        }
    }

    public function installEvents(): void
    {
        EventManager::getInstance()->registerEventHandler(
            "main",
            "OnBeforeEndBufferContent",
            $this->MODULE_ID,
            "Falbar\ToTop\Main",
            "appendScriptsToPage"
        );
    }

    public function installFiles(): void
    {
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/batov.shop/install/components", $_SERVER["DOCUMENT_ROOT"]."/local/components", True, True);
    }

    public function uninstallDB(): void
    {
        if (!Loader::includeModule($this->MODULE_ID)) {
            return;
        }

        foreach ($this->getTables() as $cl) {
            if (Application::getConnection()->isTableExists(
                Base::getInstance($cl)->getDBTableName()
            )) {
                $connection = Application::getInstance()->getConnection();
                $connection->dropTable($cl::getTableName());
            }
        }
    }

    private function importData(): void
    {
        (new Import())->main();
    }

    private function createTables(): void
    {
        array_map(static fn($cl) => $cl::getEntity()->createDbTable(), $this->getTables());
    }

    private function getTables(): array
    {
        return [
            VendorTable::class,
            ModelTable::class,
            LaptopTable::class,
            OptionTable::class,
            LaptopOptionTable::class,
            ModelOptionTable::class,
        ];
    }

}