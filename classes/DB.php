<?php

namespace classes;
use PDO;
const HOST = 'localhost';
const LOGIN = 'root';
const PASS = '';

const DB = 'WEBtask1';

class DB
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . HOST . ';dbname=' . DB, LOGIN,  PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    }

    public function getDb()
    {
        if ($this->db instanceof PDO)
        {
            return $this->db;
        }
    }
}