<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../marketplace/obterTokenML.php';

function encontrarDataHoraLimiteAgencia(array $detalhes_envio): string
{
    $deadline = $detalhes_envio['shipping_option']['estimated_delivery_time']['date']
        ?? $detalhes_envio['lead_time']['estimated_handling_limit_date']
        ?? $detalhes_envio['status_history']['date_handling']
        ?? null;

    if ($deadline) {
        try {
            $date = new DateTime($deadline, new DateTimeZone('America/Sao_Paulo'));
            $meses = [1 => 'jan', 2 => 'fev', 3 => 'mar', 4 => 'abr', 5 => 'mai', 6 => 'jun', 7 => 'jul', 8 => 'ago', 9 => 'set', 10 => 'out', 11 => 'nov', 12 => 'dez'];

            $dia = $date->format('j');
            $mes_nome = $meses[(int) $date->format('n')];
            $hora = $date->format('H:i');

            return "$dia de $mes_nome às $hora";
        } catch (Exception $e) {
            return 'Data inválida';
        }
    }

    return 'N/A';
}

function limitarPalavras(string $texto, int $limite = 5, string $sufixo = '...'): string
{
    $palavras = explode(' ', $texto);

    if (count($palavras) > $limite) {
        return implode(' ', array_slice($palavras, 0, $limite)) . $sufixo;
    }

    return $texto;
}

function obterPedidosML()
{
    $client_id = '6214520474866255';
    $client_secret = 'JkbLxodu2xOeMwePtJRBSysijUuuPoqd';

    $db = new Database();
    $conn = $db->getConnection();

    $access_token = obterTokenComCacheML($client_id, $client_secret, $conn);
    if (!$access_token) {
        return [];
    }

    $user_id = '766192095';
    $url = "https://api.mercadolibre.com/orders/search?seller=$user_id&sort=date_desc&status=paid";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $access_token"
        ],
    ]);
    $response = curl_exec($curl);
    curl_close($curl);

    $orders = json_decode($response, true);
    $pedidos_ml = [];

    if (isset($orders['results']) && count($orders['results']) > 0) {
        foreach ($orders['results'] as $order) {
            $item = $order['order_items'][0] ?? [];
            $shipping_id = $order['shipping']['id'] ?? null;
            $data_envio = 'N/A';

            if ($shipping_id) {
                $url_envio = "https://api.mercadolibre.com/shipments/" . $shipping_id;

                $curl_envio = curl_init();
                curl_setopt_array($curl_envio, [
                    CURLOPT_URL => $url_envio,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => ["Authorization: Bearer $access_token"],
                ]);
                $response_envio = curl_exec($curl_envio);
                curl_close($curl_envio);

                $detalhes_envio = json_decode($response_envio, true);

                if ($detalhes_envio) {
                    $data_envio = encontrarDataHoraLimiteAgencia($detalhes_envio);
                }
            }

            $pedidos_ml[] = [
                'id' => substr($order['id'], -6),
                'plataforma' => 'Mercado Livre',
                'cliente' => $order['buyer']['nickname'] ?? 'Desconhecido',
                'produto_nome' => limitarPalavras($item['item']['title'] ?? '-'),
                'sku' => $item['item']['seller_sku'] ?? 'N/A',
                'data_envio' => $data_envio,
                'email_cliente' => $order['buyer']['email'] ?? '-',
                'telefone_cliente' => '-',
                'endereco' => '-',
                'cidade' => '-',
                'estado' => '-',
                'cep' => '-',
                'quantidade' => $item['quantity'] ?? 1,
                'valor_unitario' => $item['unit_price'] ?? 0,
                'valor_total' => $order['total_amount'] ?? 0,
                'forma_pagamento' => '-',
                'status_envio' => $order['shipping']['id'] ?? 'unknown',
                'codigo_rastreio' => '-',
                'observacoes' => '-',
                'data_pedido' => $order['date_created'],
                'data_entrega' => null
            ];
        }
    }
    return $pedidos_ml;
}
