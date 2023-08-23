<?php

namespace classes;
require_once 'DB.php';

class Category
{
    private DB $db;
    private $connect;

    public function __construct()
    {
        $this->db = new DB();
        $this->connect = $this->db->getDb();
    }

    public function getCategories()
    {
        $sql = "SELECT * FROM Categories";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $categories;
    }
    public function getCategoryIdByName($name)
    {
        $sql = "SELECT category_id FROM Categories  WHERE category_name = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$name]);
        $categoryId = $stmt->fetchColumn();

        return $categoryId;
    }

    public function addCategory($name)
    {
        $sql = "INSERT INTO Categories (category_name) VALUES (?)";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$name]);
    }
}