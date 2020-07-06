<?php

namespace Meven\Import;

class Product
{
    private $product = [];
    private $price = 0;

    public function __construct($id)
    {
        \Bitrix\Main\Loader::includeModule('catalog');

        $this->product = [
            'ID' => $id,
            'AVAILABLE' => 'Y',
        ];

        //$result = \Bitrix\Catalog\Model\Product::update($id, $product);
    }

    public function setQuantity(int $quantity)
    {
        $this->product['QUANTITY'] = $quantity;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function create()
    {
        \Bitrix\Catalog\Model\Product::add($this->product);

        $this->updatePrice($this->product['ID']);
    }

    public function setType($type = 'product')
    {
        if ($type === 'product') {
            $this->product['TYPE'] = \Bitrix\Catalog\ProductTable::TYPE_SKU;
        } else {
            $this->product['TYPE'] = \Bitrix\Catalog\ProductTable::TYPE_OFFER;
        }
    }

    protected function updatePrice(int $id)
    {
        $dbPrice = \Bitrix\Catalog\Model\Price::getList([
            "filter" => [
                "PRODUCT_ID" => $id
            ]
        ]);

        $price = [
            'PRODUCT_ID' => $id,
            'PRICE' => $this->price,
            'CURRENCY' => "RUB",
            'CATALOG_GROUP_ID' => 1,
            'QUANTITY_FROM' => false,
            'QUANTITY_TO' => false
        ];

        if ($arPrice = $dbPrice->fetch()) {
            \CPrice::Update($arPrice["ID"], $price);
        } else {
            \CPrice::Add($price);
        }
    }
}
