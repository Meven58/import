<?php
use Meven\Import\Item;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

Bitrix\Main\Loader::includeModule('meven.import');

$item = new Item();
$item->setPreviewImage('https://kubatura13.ru/upload/iblock/5f0/5f03fa519e92178987edfe13f10d1477.jpg');
$item->setDetailImage('https://kubatura13.ru/upload/iblock/5f0/5f03fa519e92178987edfe13f10d1477.jpg');
$item->setName('Тестовый товар');
$item->setArticle('Артикул1');
$id = $item->create();

if ($id > 0) {
    $product = new \Meven\Import\Product($id);
    $product->setType('product');
    $product->create();
}


$itemSku1 = new Item('sku');
$itemSku1->setPreviewImage('https://kubatura13.ru/upload/iblock/5f0/5f03fa519e92178987edfe13f10d1477.jpg');
$itemSku1->setDetailImage('https://kubatura13.ru/upload/iblock/5f0/5f03fa519e92178987edfe13f10d1477.jpg');
$itemSku1->setName('Тестовый товар');
$itemSku1->setArticle('Артикул1');
$itemSku1->setProperties('COLOR', "Синий");
$itemSku2->setProperties('SIZE', "L");
$itemSku1->setProperties('CML2_LINK', $id);
$idSku1 = $itemSku1->create();

if ($idSku1 > 0) {
    $product = new \Meven\Import\Product($idSku1);
    $product->setType('sku');
    $product->setQuantity(1000);
    $product->setPrice(1000);
    $product->create();
}

$itemSku2 = new Item('sku');
$itemSku2->setPreviewImage('https://kubatura13.ru/upload/iblock/5f0/5f03fa519e92178987edfe13f10d1477.jpg');
$itemSku2->setDetailImage('https://kubatura13.ru/upload/iblock/5f0/5f03fa519e92178987edfe13f10d1477.jpg');
$itemSku2->setName('Тестовый товар два');
$itemSku2->setArticle('Артикул2');
$itemSku2->setProperties('COLOR', "Синий");
$itemSku2->setProperties('SIZE', "XL");
$itemSku2->setProperties('CML2_LINK', $id);
$idSku2 = $itemSku2->create();

if ($idSku2 > 0) {
    $product = new \Meven\Import\Product($idSku2);
    $product->setType('sku');
    $product->setQuantity(1000);
    $product->setPrice(1000);
    $product->create();
}
