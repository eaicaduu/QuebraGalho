<?php
require_once '../../../config/database.php';
require_once 'obterTokenML.php';

$db = new Database();
$conn = $db->getConnection();

$client_id = '6214520474866255';
$client_secret = 'JkbLxodu2xOeMwePtJRBSysijUuuPoqd';

$access_token = obterTokenComCacheML($client_id, $client_secret, $conn);
if (!$access_token) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao obter token']);
    exit;
}

$user_id = '766192095';

$user_items_url = "https://api.mercadolibre.com/users/$user_id/items/search";
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $user_items_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ["Authorization: Bearer $access_token"],
]);
$response = curl_exec($curl);
curl_close($curl);
$items = json_decode($response, true);

if (!isset($items['results']) || count($items['results']) == 0) {
    echo json_encode(['message' => 'Nenhum produto encontrado']);
    exit;
}

function getSellerSKUFromAttributes(array $attributes): ?string
{
    foreach ($attributes as $attribute) {
        if (isset($attribute['id']) && $attribute['id'] === 'SELLER_SKU') {
            return $attribute['value_name'] ?? null;
        }
    }
    return null;
}

foreach ($items['results'] as $item_id) {
    $item_url = "https://api.mercadolibre.com/items/$item_id";
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $item_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Authorization: Bearer $access_token"],
    ]);
    $item_response = curl_exec($curl);
    curl_close($curl);
    $item_data = json_decode($item_response, true);

    if (!isset($item_data['id']) || isset($item_data['error']))
        continue;

    $seller_sku = null;
    if (isset($item_data['attributes']) && is_array($item_data['attributes'])) {
        $seller_sku = getSellerSKUFromAttributes($item_data['attributes']);
    }

    $pictures = isset($item_data['pictures']) ? json_encode($item_data['pictures']) : null;
    $seller_address = isset($item_data['seller_address']) ? json_encode($item_data['seller_address']) : null;
    $shipping = isset($item_data['shipping']) ? json_encode($item_data['shipping']) : null;

    $seller_id = $item_data['seller_id'] ?? null;

    $seller_power_seller_status = null;
    $seller_registration_date = null;
    if ($seller_id) {
        $seller_url = "https://api.mercadolibre.com/users/$seller_id";
        $curl_seller = curl_init();
        curl_setopt_array($curl_seller, [
            CURLOPT_URL => $seller_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Authorization: Bearer $access_token"],
        ]);
        $seller_response = curl_exec($curl_seller);
        curl_close($curl_seller);
        $seller_data = json_decode($seller_response, true);
        if ($seller_data && !isset($seller_data['error'])) {
            $seller_power_seller_status = $seller_data['power_seller_status'] ?? null;
            $seller_registration_date = isset($seller_data['registration_date']) ? date('Y-m-d H:i:s', strtotime($seller_data['registration_date'])) : null;
        }
    }

    $stmt = $conn->prepare("SELECT id FROM produtos_ml WHERE id = ?");
    $stmt->execute([$item_data['id']]);
    $produto_db = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto_db) {
        $stmt_insert = $conn->prepare("
            INSERT INTO produtos_ml (
                id, site_id, title, category_id, price, currency_id, available_quantity, sold_quantity,
                buying_mode, listing_type_id, start_time, stop_time, `condition`, permalink, thumbnail,
                pictures, video_id, warranty, catalog_product_id, domain_id, seller_address, shipping,
                seller_id, seller_power_seller_status, seller_registration_date, accepts_mercadopago, seller_sku, last_update
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, NOW()
            )
        ");
        $stmt_insert->execute([
            $item_data['id'] ?? null,
            $item_data['site_id'] ?? null,
            $item_data['title'] ?? null,
            $item_data['category_id'] ?? null,
            $item_data['price'] ?? null,
            $item_data['currency_id'] ?? null,
            $item_data['available_quantity'] ?? null,
            $item_data['sold_quantity'] ?? null,
            $item_data['buying_mode'] ?? null,
            $item_data['listing_type_id'] ?? null,
            isset($item_data['start_time']) ? date('Y-m-d H:i:s', strtotime($item_data['start_time'])) : null,
            isset($item_data['stop_time']) ? date('Y-m-d H:i:s', strtotime($item_data['stop_time'])) : null,
            $item_data['condition'] ?? null,
            $item_data['permalink'] ?? null,
            $item_data['thumbnail'] ?? null,
            $pictures,
            $item_data['video_id'] ?? null,
            $item_data['warranty'] ?? null,
            $item_data['catalog_product_id'] ?? null,
            $item_data['domain_id'] ?? null,
            $seller_address,
            $shipping,
            $seller_id,
            $seller_power_seller_status,
            $seller_registration_date,
            $item_data['accepts_mercadopago'] ? 1 : 0,
            $seller_sku
        ]);
    } else {
        $stmt_update = $conn->prepare("
            UPDATE produtos_ml SET
                site_id = ?,
                title = ?,
                category_id = ?,
                price = ?,
                currency_id = ?,
                available_quantity = ?,
                sold_quantity = ?,
                buying_mode = ?,
                listing_type_id = ?,
                start_time = ?,
                stop_time = ?,
                `condition` = ?,
                permalink = ?,
                thumbnail = ?,
                pictures = ?,
                video_id = ?,
                warranty = ?,
                catalog_product_id = ?,
                domain_id = ?,
                seller_address = ?,
                shipping = ?,
                seller_id = ?,
                seller_power_seller_status = ?,
                seller_registration_date = ?,
                accepts_mercadopago = ?,
                seller_sku = ?,
                last_update = NOW()
            WHERE id = ?
        ");
        $stmt_update->execute([
            $item_data['site_id'] ?? null,
            $item_data['title'] ?? null,
            $item_data['category_id'] ?? null,
            $item_data['price'] ?? null,
            $item_data['currency_id'] ?? null,
            $item_data['available_quantity'] ?? null,
            $item_data['sold_quantity'] ?? null,
            $item_data['buying_mode'] ?? null,
            $item_data['listing_type_id'] ?? null,
            isset($item_data['start_time']) ? date('Y-m-d H:i:s', strtotime($item_data['start_time'])) : null,
            isset($item_data['stop_time']) ? date('Y-m-d H:i:s', strtotime($item_data['stop_time'])) : null,
            $item_data['condition'] ?? null,
            $item_data['permalink'] ?? null,
            $item_data['thumbnail'] ?? null,
            $pictures,
            $item_data['video_id'] ?? null,
            $item_data['warranty'] ?? null,
            $item_data['catalog_product_id'] ?? null,
            $item_data['domain_id'] ?? null,
            $seller_address,
            $shipping,
            $seller_id,
            $seller_power_seller_status,
            $seller_registration_date,
            $item_data['accepts_mercadopago'] ? 1 : 0,
            $seller_sku,
            $item_data['id']
        ]);
    }
}

echo json_encode(['message' => 'Sincronização concluída']);
