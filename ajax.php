<?php
require "vendor/autoload.php";
$typePrice = isset($_POST['type_price']) ? $_POST['type_price'] : "";
$typePrice = ($typePrice == "Розничная цена") ? "price" : "price_whole";

$priceFrom = isset($_POST['price_from']) ? $_POST['price_from'] : 0;
$priceTo = isset($_POST['price_to']) ? $_POST['price_to'] : 0;

$typeCount = isset($_POST['type_count']) ? $_POST['type_count'] : "";
$typeCount = ($typeCount == "Более") ? ">" : "<";
$count = isset($_POST['count']) ? $_POST['count'] : 0;

$formData = [$typePrice, $priceFrom, $priceTo, $typeCount, $count];
$emptyErrors = isEmpty($formData);

$nums = ["price_from" => $priceFrom, "price_to" => $priceTo, "count" => $count];
$validErrors = isValid($nums);

if($emptyErrors || !empty($validErrors))
{
    echo json_encode(["emptyErrors" => $emptyErrors, "validErrors" => $validErrors]);
}
else
{
    $product = new \classes\Product();
    $category = new \classes\Category();
    $products = $product->getFilterProducts($typePrice, $priceFrom, $priceTo, $typeCount, $count);
    $categories = $category->getCategories();
    array_unshift($categories, ["category_id" => 0, "category_name" => "Без категории"]);

    $productByCategories = $product->genProductsByCategories($categories, $products);
    $template = genTemplate($productByCategories);

    echo json_encode(["template" => $template]);
}

function isEmpty($formFields)
{
    $emptyErrors = [];
    foreach ($formFields as $key)
    {
        if(empty($key)) array_push($emptyErrors, "Пусто");
    }
    $emptyErrors = empty($emptyErrors) ? false : true;
    return $emptyErrors;
}

function isValid($nums)
{
    $validErrors = [];
    foreach ($nums as $key => $num)
    {
        if(!is_numeric($num) || $num < 0) array_push($validErrors, $key);
    }
    return $validErrors;
}

function genTemplate($products)
{
    $template = "";

    foreach ($products as $cat => $el) {
        $template .= " <tr>
                            <td class='category' colspan='9'>$cat</td>
                       </tr>";
        foreach ($el as $val) {
            $template .= "<tr class='row' data-id='{$val['product_id']}'> ";

            foreach ($val as $key => $pr) {
                $template .= "<td> $pr </td>";
            }
        }

        $template .= "</tr>";
    }
    return $template;
}