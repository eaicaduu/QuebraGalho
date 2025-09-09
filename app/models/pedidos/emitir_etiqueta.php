<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../marketplace/mercadolivre/obterTokenML.php';

$db = new Database();
$conn = $db->getConnection();

$identificador_envio = $_GET['identificador_envio'] ?? null;
$plataforma = $_GET['plataforma'] ?? null;

if (!$identificador_envio) {
    die("Identificador inválido");
}

if (!$plataforma) {
    die("Plataforma inválida");
}


switch (strtolower($plataforma)) {
    case 'mercado livre':
        $access_token = obterTokenComCacheML('6214520474866255', 'JkbLxodu2xOeMwePtJRBSysijUuuPoqd', $conn);

        $url = "https://api.mercadolibre.com/shipment_labels?shipment_ids=$identificador_envio&response_type=pdf";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            die("Erro ao obter etiqueta");
        }

        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename=etiqueta_$identificador_envio.pdf");
        echo $response;
        break;
    case 'shopee':
        // lógica para etiqueta da Shopee
        break;
    case 'amazon':
        // lógica para etiqueta da Amazon
        break;
    case 'ecommerce':
        // lógica para etiqueta do Ecommerce próprio
        break;
    default:
        die("Plataforma não suportada");
}
