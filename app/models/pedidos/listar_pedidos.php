<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/buscar_pedidos.php';

$db = new Database();
$conn = $db->getConnection();

$filtroData = isset($_GET['data']) ? $_GET['data'] : null;

$produtos_mercadolivre = buscarPedidosPorPlataforma($conn, 'Mercado Livre', $filtroData);
$produtos_shopee = buscarPedidosPorPlataforma($conn, 'Shopee', $filtroData);
$produtos_magalu = buscarPedidosPorPlataforma($conn, 'Magalu', $filtroData);
$produtos_amazon = buscarPedidosPorPlataforma($conn, 'Amazon', $filtroData);
$produtos_ecommerce = buscarPedidosPorPlataforma($conn, 'Ecommerce', $filtroData);

$result = array_merge(
    $produtos_mercadolivre,
            $produtos_shopee,
            $produtos_magalu,
            $produtos_amazon,
            $produtos_ecommerce
);

ob_start();
foreach ($result as $pedido) {
    include __DIR__ . "/card_pedidos.php";
}
$html = ob_get_clean();

$totalPedidos = contarPedidosPorPlataforma($conn, 'Mercado Livre', $filtroData)
    + contarPedidosPorPlataforma($conn, 'Shopee', $filtroData)
    + contarPedidosPorPlataforma($conn, 'Magalu', $filtroData)
    + contarPedidosPorPlataforma($conn, 'Amazon', $filtroData)
    + contarPedidosPorPlataforma($conn, 'Ecommerce', $filtroData);

echo json_encode([
    'html' => $html,
    'totalPedidos' => $totalPedidos,
]);