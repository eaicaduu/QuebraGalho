<?php
session_start();

if (!isset($_SESSION['usuario_tipo']) || !in_array($_SESSION['usuario_tipo'], [2, 3])) {
    header("Location: ../../index.php");
    exit();
}

require_once __DIR__ . '/../../../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("
    SELECT c.id, c.nome, c.oferta, 
           GROUP_CONCAT(p.nome SEPARATOR ', ') AS produtos_nome
    FROM categorias c
    LEFT JOIN produtos p ON p.categoria_id = c.id
    GROUP BY c.id, c.nome, c.oferta
    ORDER BY c.id ASC
");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Produos Categorias - Quebra Galho</title>
    <link rel="icon" href="../../images/logo.png">
    <link rel="stylesheet" href="../../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/categorias/nav.php'; ?>

    <?php include 'includes/categorias/body.php'; ?>

    <script src="js/categorias.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>