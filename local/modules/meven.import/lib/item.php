<?php

namespace Meven\Import;

class Item
{
    const CATALOG = 53;
    const SKU = 54;
    private $item = [];
    private $props = [];

    /**
     * Item constructor.
     * @throws \Bitrix\Main\LoaderException
     *
     */
    public function __construct($type = 'main')
    {
        $this->item['PROPERTY_VALUES'] = [];

        $this->catalogId = self::CATALOG;

        if ($type !== 'main') {
            $this->catalogId = self::SKU;
        }

        \Bitrix\Main\Loader::includeModule('iblock');
        $resProps = \CIBlock::GetProperties($this->catalogId, [], []);
        while ($ob = $resProps->GetNext()) {
            $this->props['PROPERTIES'][$ob['CODE']] = $ob;
        }

        $this->item['MODIFIED_BY'] = 1;
        $this->item['IBLOCK_SECTION_ID'] = false;
        $this->item['IBLOCK_ID'] = $this->catalogId;
    }

    /**
     * Создание элемента
     */
    public function create()
    {
        $elem = new \CIBlockElement;

        if ($productId = $elem->Add($this->item)) {
            return $productId;
        } else {
            \Bitrix\Main\Diag\Debug::writeToFile($elem->LAST_ERROR, '', 'error-add.txt');
        }

        $this->item = [];
    }


    /**
     * @param string $path
     *
     * Добавляет preview картинку из ссылки
     */
    public function setPreviewImage(string $path)
    {
        $this->item['PREVIEW_PICTURE'] = \CFile::MakeFileArray($path);
    }

    /**
     * @param string $name
     *
     * Добавляем элементу название
     */
    public function setName(string $name)
    {
        $this->item['NAME'] = $name;
    }

    /**
     * @param string $path
     *
     * Добавляем detail картинку из ссылки
     */
    public function setDetailImage(string $path)
    {
        $this->item['DETAIL_PICTURE'] = \CFile::MakeFileArray($path);
    }

    /**
     * @param string $article
     *
     * Устанваливаем артикул
     */
    public function setArticle(string $article)
    {
        $this->item['PROPERTY_VALUES']['ARTICLE'] = $article;
    }

    /**
     * @param string $code
     * @param string $value
     *
     * Устанавливает свойства в зависимости от типа
     */
    public function setProperties(string $code, string $value)
    {

        ?><pre><?print_r ($this->props)?></pre><?
        switch ($this->props['PROPERTIES'][$code]['USER_TYPE']):
            case 'directory':
                if (empty($this->props['HIGHLOAD'][$code])) {
                    $prop = new Property();
                    $this->props['HIGHLOAD'][$code] = $prop->getFromHighload($this->props['PROPERTIES'][$code]['USER_TYPE_SETTINGS']["TABLE_NAME"]);
                }

                $this->item['PROPERTY_VALUES'][$code] = $this->props['HIGHLOAD'][$code][$value]['UF_XML_ID'];
                break;

            default:
                $this->item['PROPERTY_VALUES'][$code] = $value;
                break;
        endswitch;
    }
}
