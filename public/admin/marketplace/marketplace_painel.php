<?php
session_start();

if (!isset($_SESSION['usuario_tipo']) || !in_array($_SESSION['usuario_tipo'], [2, 3])) {
    header("Location: ../../index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Marketplace - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../images/logo.png">
    <link href="../../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/nav.php'; ?>

    <?php include 'includes/cards.php'; ?>

    <?php include 'includes/calculo.php'; ?>

    <?php include 'includes/adicionar.php'; ?>

    <?php include 'includes/buscar.php'; ?>

    <script src="../js/marketplace/painel/calculo_resultado.js"></script>
    <script src="../js/marketplace/painel/adicionar_calculo.js"></script>
    <script src="../js/marketplace/shopee/shopee.js"></script>
    <script src="../js/marketplace/mercadolivre/listar_marketplace_mercadolivre.js"></script>
    <script src="../js/marketplace/magalu/magalu.js"></script>
    <script src="../js/marketplace/amazon/amazon.js"></script>
    <script src="../../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
