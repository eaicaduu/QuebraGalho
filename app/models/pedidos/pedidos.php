<?php
require_once __DIR__ . '/ml_pedidos.php';
$plataforma = $_GET['plataforma'] ?? '';
$pedidos = [];

if ($plataforma == 'mercado_livre') {
$pedidos = obterPedidosML();
}

if ($plataforma == 'ecommerce') {
$pedidos = [];
}

if ($plataforma == 'shopee') {
$pedidos = [];
}

if ($plataforma == 'amazon') {
$pedidos = [];
}

header('Content-Type: application/json');
echo json_encode($pedidos);
