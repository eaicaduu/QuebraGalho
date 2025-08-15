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

    <?php include 'includes/painel/nav.php'; ?>

    <?php include 'includes/painel/cards.php'; ?>

    <?php include 'includes/painel/calculo.php'; ?>

    <?php include 'includes/painel/adicionar.php'; ?>

    <?php include 'includes/painel/buscar.php'; ?>

    <script src="../js/marketplace/calculo_resultado.js"></script>
    <script src="../js/marketplace/adicionar_calculo.js"></script>
    <script src="../js/marketplace/buscar_produtos.js"></script>
    <script src="../js/marketplace/shopee.js"></script>
    <script src="../js/marketplace/mercadolivre.js"></script>
    <script src="../js/marketplace/magalu.js"></script>
    <script src="../js/marketplace/amazon.js"></script>
    <script src="../../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
