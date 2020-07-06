<?php

namespace Meven\Import;

use \Bitrix\Highloadblock\HighloadBlockTable;

class Property
{

    public function __construct()
    {
        \Bitrix\Main\Loader::IncludeModule('highloadblock');
    }

    public function getFromHighload(string $name)
    {
        $result = [];

        $entity = $this->getHighloadId($name);

        $res = $entity::getList([
            'select' => ['*'],
        ]);
        while ($el = $res->fetch()) {
            $result[$el['UF_NAME']] = $el;
        }

        return $result;
    }

    public function getHighloadId(string $name)
    {
        $hlblock = HighloadBlockTable::getList([
            'filter' => ['=TABLE_NAME' => $name]
        ])->fetch();
        if(!$hlblock){
            throw new \Exception('[04072017.1331.1]');
        }

        $hlClassName = (HighloadBlockTable::compileEntity($hlblock))->getDataClass();

        return $hlClassName;
    }
}
