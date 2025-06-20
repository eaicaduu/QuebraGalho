<?php
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/models/produtos.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$products = $product->listAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Ferragem Quebra Galho - Loja Online</title>
    <link rel="icon" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="user-select-none">

    <?php include 'includes/index/nav.php'; ?>

    <?php include 'includes/index/container.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>