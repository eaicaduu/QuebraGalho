<?php
require_once __DIR__ . '/../../marketplace/mercadolivre/obterTokenML.php';

function sincronizarMercadoLivre($conn)
{
    $client_id = '6214520474866255';
    $client_secret = 'JkbLxodu2xOeMwePtJRBSysijUuuPoqd';

    $access_token = obterTokenComCacheML($client_id, $client_secret, $conn);
    if (!$access_token)
        return;

    $user_id = '766192095';
    $url = "https://api.mercadolibre.com/orders/search?seller=$user_id&sort=date_desc&status=paid";

    $orders = json_decode(file_get_contents_curl($url, $access_token), true);

    if (!isset($orders['results']) || count($orders['results']) === 0)
        return;

    foreach ($orders['results'] as $order) {
        $pedido = extrairDadosPedido($order, $access_token);
        inserirOuAtualizarPedido($conn, $pedido);
    }
}

function file_get_contents_curl($url, $access_token)
{
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Authorization: Bearer $access_token"]
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function extrairDadosPedido($order, $access_token)
{
    $pedido = [];
    $pedido['order_id'] = $order['id'] ?? null;
    $item = $order['order_items'][0] ?? [];

    $pedido['plataforma'] = 'Mercado Livre';
    $pedido['cliente'] = $order['buyer']['nickname'] ?? 'Desconhecido';
    $pedido['produto_nome'] = $item['item']['title'] ?? '-';
    $pedido['produto_sku'] = $item['item']['seller_sku'] ?? null;
    $pedido['quantidade'] = $item['quantity'] ?? 1;
    $pedido['valor_unitario'] = $item['unit_price'] ?? 0;
    $pedido['valor_total'] = $order['total_amount'] ?? 0;
    $pedido['status'] = 'processando';
    $pedido['data_pedido'] = isset($order['date_created']) ? date('Y-m-d H:i:s', strtotime($order['date_created'])) : null;
    $pedido['data_entrega'] = null;
    $pedido['endereco'] = $pedido['cidade'] = $pedido['estado'] = $pedido['cep'] = $pedido['codigo_rastreio'] = null;

    if (isset($order['shipping']['id'])) {
        $shipping = json_decode(file_get_contents_curl(
            "https://api.mercadolibre.com/shipments/{$order['shipping']['id']}",
            $access_token
        ), true);
        $pedido['identificador_envio'] = $shipping['id'] ?? null;

        if ($shipping) {
            $pedido['endereco'] = $shipping['receiver_address']['address_line'] ?? null;
            $pedido['cidade'] = $shipping['receiver_address']['city']['name'] ?? null;
            $pedido['estado'] = $shipping['receiver_address']['state']['name'] ?? null;
            $pedido['cep'] = $shipping['receiver_address']['zip_code'] ?? null;
            $pedido['codigo_rastreio'] = $shipping['tracking_number'] ?? null;

            if (($shipping['status'] ?? '') === 'delivered') {
                $pedido['status'] = 'entregue';
            } elseif (($shipping['status'] ?? '') === 'shipped') {
                $pedido['status'] = 'enviado';
            }

            $sla = json_decode(file_get_contents_curl(
                "https://api.mercadolibre.com/shipments/{$order['shipping']['id']}/sla",
                $access_token
            ), true);

            if ($sla && isset($sla['expected_date'])) {
                $pedido['data_entrega'] = date('Y-m-d H:i:s', strtotime($sla['expected_date']));
            }
        }
    }

    return $pedido;
}

function inserirOuAtualizarPedido($conn, $pedido)
{
    $stmt = $conn->prepare("SELECT id FROM pedidos WHERE order_id = ?");
    $stmt->execute([$pedido['order_id']]);
    $pedido_db = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pedido_db) {
        $stmt_insert = $conn->prepare("
    INSERT INTO pedidos (
        order_id, plataforma, cliente, endereco, cidade, estado, cep,
        produto_nome, produto_sku, quantidade, valor_unitario, valor_total,
        status, codigo_rastreio, identificador_envio, data_pedido, data_entrega
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )
");
        $stmt_insert->execute([
            $pedido['order_id'],
            $pedido['plataforma'],
            $pedido['cliente'],
            $pedido['endereco'],
            $pedido['cidade'],
            $pedido['estado'],
            $pedido['cep'],
            $pedido['produto_nome'],
            $pedido['produto_sku'],
            $pedido['quantidade'],
            $pedido['valor_unitario'],
            $pedido['valor_total'],
            $pedido['status'],
            $pedido['codigo_rastreio'],
            $pedido['identificador_envio'],
            $pedido['data_pedido'],
            $pedido['data_entrega']
        ]);
    } else {
        $stmt_update = $conn->prepare("
            UPDATE pedidos SET
                cliente = ?, plataforma = ?, endereco = ?, cidade = ?, estado = ?, cep = ?,
                produto_nome = ?, produto_sku = ?, quantidade = ?,
                valor_unitario = ?, valor_total = ?, status = ?, codigo_rastreio = ?, identificador_envio = ?,
                data_entrega = ?
            WHERE order_id = ?
        ");
        $stmt_update->execute([
            $pedido['cliente'],
            $pedido['plataforma'],
            $pedido['endereco'],
            $pedido['cidade'],
            $pedido['estado'],
            $pedido['cep'],
            $pedido['produto_nome'],
            $pedido['produto_sku'],
            $pedido['quantidade'],
            $pedido['valor_unitario'],
            $pedido['valor_total'],
            $pedido['status'],
            $pedido['codigo_rastreio'],
            $pedido['identificador_envio'],
            $pedido['data_entrega'],
            $pedido['order_id']
        ]);
    }
}
