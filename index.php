<?php
require 'vendor/autoload.php';

use classes\Category;
use classes\Data;
use classes\Product;

$data = new Data();
$category = new Category();
$product = new Product();

$dataXls = $data->getDataFromXls('pricelist.xls');
unset($dataXls[0]);
//$data->convertToSql($dataXls);


$allSum = 0;
$avgPrice = round($product->getAvg("price"), 3);
$avgPriceWhole = round($product->getAvg("price_whole"), 3);
$maxPrice = $product->getMax("price");
$minPriceWhole = $product->getMin("price_whole");

$products = $product->getProducts();
$categories = $category->getCategories();
array_unshift($categories, ["category_id" => 0, "category_name" => "Без категории"]);

$productByCategories = $product->genProductsByCategories($categories, $products);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>task1</title>
</head>
<body>

<?php

foreach ($products as $item){
    $sum = $product->getSumCountById($item["product_id"]);
    if ($sum < 20)
    {
        $note = "Осталось мало!! Срочно докупите!!!";
        $product->updateNote($item["product_id"], $note);
    }

    $allSum += $sum;
}

?>
<div class="top">
    <p>Всего товаров на складах: <?=$allSum?></p>
    <p>Средняя розничная цена: <?=$avgPrice?></p>
    <p>Средняя оптовая цена:  <?=$avgPriceWhole?></p>
</div>

<form action=""  method="post" id="filter" class="form">
    <div>
        <select id="type-price" name="type_price">
            <option selected="" value="Розничная цена">Розничная цена</option>
            <option value="Оптовая цена">Оптовая цена</option>
        </select>
        <p class="error type_price_err"></p>
    </div>

    <label for="from">от</label>
    <div>
        <input id="from" name="price_from" type="text" value="1000">
        <p class="error price_from_err"></p>
    </div>


    <label for="to">до</label>
    <div>
        <input id="to" name="price_to" type="text" value="3000">
        <p class="error price_to_err"></p>
    </div>
    <p>рублей и на складе</p>

    <div>
        <select id="type-count" name="type_count">
            <option selected="" value="Более">Более</option>
            <option value="Менее">Менее</option>
        </select>
        <p class="error type_count_err"></p>
    </div>

    <div>
        <input name="count" type="text" value="20">
        <p class="error count_err"></p>
    </div>


    <p>штук</p>
    <input id="filter-sub" class="submit" type="submit" value="Показать товары">
</form>

<table>
    <tr>
        <th>id товара</th>
        <th>Наименование товара</th>
        <th>id категории</th>
        <th>Стоимость, руб</th>
        <th>Стоимость опт, руб</th>
        <th>Наличие на складе 1, шт</th>
        <th>Наличие на складе 2, шт</th>
        <th>Страна производства</th>
        <th>Примечание</th>
    </tr>


    <?php foreach ($productByCategories as $cat => $el): ?>
    <tr>
        <td class="category" colspan="9"><?=$cat?></td>
    </tr>

    <?php foreach ($el as $val): ?>
    <tr class="row" data-id="<?=$val['product_id']?>">
    <?php
        foreach ($val as $key => $pr):
            $color = "black";
            if($key == "price" && $pr == $maxPrice) $color = "red";
            if ($key == "price_whole" && $pr == $minPriceWhole) $color = "green";
            ?>
                <td style="color:<?=$color?>">
                    <?=$pr?>
                </td>
        <?php
        endforeach;
        endforeach;
        ?>
        </tr>

    <?php endforeach; ?>

</table>
<script src="ajax.js"></script>

</body>

</html>

