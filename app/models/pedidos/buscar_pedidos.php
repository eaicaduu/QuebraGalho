<?php
function buscarPedidosPorPlataforma($conn, $plataforma, $filtroData = null)
{
    $sql = "SELECT * FROM pedidos WHERE plataforma = :plataforma";
    $params = [':plataforma' => $plataforma];

    if ($filtroData) {
        $sql .= " AND DATE(data_entrega) = :data";
        $params[':data'] = $filtroData;
    }

    $sql .= " ORDER BY data_pedido ASC"; 

    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function contarPedidosPorPlataforma($conn, $plataforma, $filtroData = null)
{
    $sql = "SELECT COUNT(*) as total FROM pedidos WHERE plataforma = :plataforma";
    $params = [':plataforma' => $plataforma];

    if ($filtroData) {
        $sql .= " AND DATE(data_entrega) = :data";
        $params[':data'] = $filtroData;
    }

    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    return (int) $stmt->fetchColumn();
}
