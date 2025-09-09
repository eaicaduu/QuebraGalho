<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/plataformas/mercadolivre_pedidos.php';
require_once __DIR__ . '/plataformas/shopee_pedidos.php';
require_once __DIR__ . '/plataformas/magalu_pedidos.php';
require_once __DIR__ . '/plataformas/amazon_pedidos.php';

$db = new Database();
$conn = $db->getConnection();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    sincronizarMercadoLivre($conn);
    sincronizarShopee($conn);
    sincronizarMagalu($conn);
    sincronizarAmazon($conn);

    echo json_encode(["success" => true, "message" => "Pedidos atualizados"]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
