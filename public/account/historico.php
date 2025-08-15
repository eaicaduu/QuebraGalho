<?php
session_start();
require_once __DIR__ . '/../../app/config/database.php';

if (!isset($_SESSION['usuario_documento'])) {
    header("Location: ../login.php");
    exit();
}

$paginaAtual = 'historico';
$basePath = '';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Histórico de Compras - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/logo.png">
    <link href="../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/historico/nav.php'; ?>

    <?php include 'includes/historico/card.php'; ?>

    <script src="../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>

</body>

</html>