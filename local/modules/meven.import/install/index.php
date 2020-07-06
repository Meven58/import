<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Application;
use Bitrix\Main\EventManager;

Loc::loadMessages(__FILE__);

Class meven_import extends CModule
{
    const MODULE_ID = 'meven.import';
    var $MODULE_ID = 'meven.import';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $strError = '';

    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__)."/version.php");
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("meven.import_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("meven.import_MODULE_DESC");

        $this->PARTNER_NAME = Loc::getMessage("meven.import_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("meven.import_PARTNER_URI");
    }

    function InstallDB($arParams = array())
    {
        return true;
    }

    function UnInstallDB($arParams = array())
    {
        return true;
    }

    function DoInstall()
    {
        $this->InstallEvents();
        RegisterModule(self::MODULE_ID);
    }

    function DoUninstall()
    {
        $this->UnInstallEvents();
        UnRegisterModule(self::MODULE_ID);
    }
}
?>
