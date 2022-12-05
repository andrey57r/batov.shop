<?php

declare(strict_types = 1);

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Iblock\Component\Tools;
use Bitrix\Main\Loader;

class ComplexComponent extends CBitrixComponent
{

    public function executeComponent()
    {
        Loader::includeModule('iblock');

        $componentPage = $this->sefMode();

        if (!$componentPage) {
            Tools::process404(
                $this->arParams['MESSAGE_404'],
                ($this->arParams['SET_STATUS_404'] === 'Y'),
                ($this->arParams['SET_STATUS_404'] === 'Y'),
                ($this->arParams['SHOW_404'] === 'Y'),
                $this->arParams['FILE_404']
            );
        }

        $this->IncludeComponentTemplate($componentPage);
    }

    protected function sefMode(): string
    {
        $arDefaultVariableAliases404 = [];

        $arDefaultUrlTemplates404 = [
            'element' => 'detail/#NOTEBOOK#/',
            'models' => '#BRAND#/',
            'laptops' => '#BRAND#/#MODEL#/',
        ];

        $arVariables = [];

        $engine = new CComponentEngine($this);

        $engine->addGreedyPart('#SECTION_CODE_PATH#');
        $engine->addGreedyPart('#SMART_FILTER_PATH#');
        $engine->setResolveCallback(['CIBlockFindTools', 'resolveComponentEngine']);

        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates(
            $arDefaultUrlTemplates404,
            $this->arParams['SEF_URL_TEMPLATES']
        );
        $arVariableAliases = CComponentEngine::makeComponentVariableAliases(
            $arDefaultVariableAliases404,
            $this->arParams['VARIABLE_ALIASES']
        );

        $componentPage = $engine->guessComponentPath(
            $this->arParams['SEF_FOLDER'],
            $arUrlTemplates,
            $arVariables
        );

        if (empty($componentPage)) {
            $componentPage = 'vendors';
        }

        CComponentEngine::initComponentVariables(
            $componentPage,
            $this->arComponentVariables,
            $arVariableAliases,
            $arVariables
        );
        $this->arResult = [
            'VARIABLES' => $arVariables,
            'ALIASES' => $arVariableAliases,
        ];

        return $componentPage;
    }

}