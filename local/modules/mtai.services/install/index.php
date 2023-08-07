<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class MTai_Services extends CModule
{
    var $MODULE_ID = "mtai.services";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $errors;

    function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = Loc::getMessage("MT_MODULE_INSTALL_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("MT_MODULE_INSTALL_DESCRIPTION");
    }

    function DoInstall()
    {
        $this->InstallEvents();
        \Bitrix\Main\ModuleManager::RegisterModule("mtai.services");
        return true;
    }

    function DoUninstall()
    {
        $this->UnInstallEvents();
        \Bitrix\Main\ModuleManager::UnRegisterModule("mtai.services");
        return true;
    }

    function InstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();

        $eventManager->registerEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            'mtai.services',
            \MTai\Services\Rest\ServiceRegister::class,
            'onRestServiceBuildDescription'
        );

        return true;
    }

    function UnInstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();

        $eventManager->unRegisterEventHandler(
            'rest',
            'OnRestServiceBuildDescription',
            'mtai.services',
            \MTai\Services\Rest\ServiceRegister::class,
            'onRestServiceBuildDescription'
        );

        return true;
    }
}