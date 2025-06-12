<?php
class Product {
    private $conn;
    private $table = "products";

    public function __construct($db){
        $this->conn = $db;
    }

    public function listAll(){
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}