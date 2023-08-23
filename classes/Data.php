<?php

namespace classes;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Data
{
    public function getDataFromXls($fileName)
    {
        $spreadsheet = IOFactory::load($fileName);
        $data = $spreadsheet->getActiveSheet()->toArray();

        return $data;
    }

    public function convertToSql($data)
    {
        $category = new Category();
        $product = new Product();
        $categoryId = null;

        foreach ($data as $row)
        {
            $name = $row[0];
            $price = $row[1];
            $priceWhole = (float)$row[2];
            $count1 = (int)$row[3];
            $count2 = (int)$row[4];
            $city = $row[5];

            if($price == 'Стоимость')
            {
                $categoryId = $category->getCategoryIdByName($name);
                if ($categoryId == 0)
                {
                    $category->addCategory($name);
                    echo "Category add";
                }
                continue;
            }

         $product->addProduct($name, $categoryId, $price, $priceWhole, $count1, $count2, $city);

        }
    }

}