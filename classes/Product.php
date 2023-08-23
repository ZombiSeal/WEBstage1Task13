<?php

namespace classes;
require_once 'DB.php';
class Product
{
    private DB $db;
    private $connect;

    public function __construct()
    {
        $this->db = new DB();
        $this->connect = $this->db->getDb();

    }
    public function getProducts()
    {
        $sql = "SELECT * FROM Products ORDER BY category_id";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $products;
    }
    public function getFilterProducts($typePrice, $priceFrom, $priceTo, $typeCount, $count)
    {
        $sql = "SELECT * FROM Products 
                WHERE ($typePrice BETWEEN :priceFrom AND :priceTo) 
                  AND (count1 + count2) $typeCount :count ";
        $stmt = $this->connect->prepare($sql);
        $params = ["priceFrom" => $priceFrom, "priceTo" => $priceTo, "count" => $count];
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function addProduct($name, $categoryId, $price, $priceWhole, $count1, $count2, $city)
    {
        $sql = "INSERT INTO Products (name, category_id, price, price_whole, count1, count2, city) VALUE (:name, :categoryId, :price, :priceWhole, :count1, :count2, :city)";
        $stmt = $this->connect->prepare($sql);
        $params = [
            "name" => $name,
            "categoryId" => $categoryId,
            "price" => (float)$price,
            "priceWhole" => (float)$priceWhole,
            "count1" => (int)$count1,
            "count2" => (int)$count2,
            "city" => $city,
        ];

        $stmt->execute($params);
    }

    public function getSumCountById($id)
    {
        $sql = "SELECT (count1 + count2) as sum FROM Products WHERE product_id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchColumn();
        return $result;
    }
    public function updateNote($id, $note)
    {
        $sql = "UPDATE Products SET note = :note WHERE product_id = :id";
        $stmt = $this->connect->prepare($sql);
        $params = [
            "note" => $note,
            "id" => $id
        ];
        $stmt->execute($params);
    }

    public function getAvg($field)
    {
        $sql = "SELECT AVG($field) as avg FROM Products";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $avg = $stmt->fetchColumn();
        return $avg;

    }
    public function getMax($field)
    {
        $sql = "SELECT MAX($field) as max FROM Products";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $avg = $stmt->fetchColumn();
        return $avg;
    }

    public function getMin($field)
    {
        $sql = "SELECT MIN($field) as min FROM Products";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $avg = $stmt->fetchColumn();
        return $avg;
    }

    public function genProductsByCategories($categories, $products)
    {
        $productByCategories = [];
        foreach ($categories as $val)
        {
            $id = $val["category_id"];
            $productByCategories[$val["category_name"]] = [];

            foreach ($products as $item)
            {
                if($id == $item["category_id"])
                {
                    array_push($productByCategories[$val["category_name"]], $item);
                }

            }
        }
        return $productByCategories;
    }
}