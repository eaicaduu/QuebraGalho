<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $product;

    public function __construct($db){
        $this->product = new Product($db);
    }

    public function list(){
        return $this->product->listAll();
    }
}