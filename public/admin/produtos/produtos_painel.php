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
    <title>Painel Produtos - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../images/logo.png">
    <link href="../../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/painel/nav.php'; ?>

    <?php include 'includes/painel/cards.php'; ?>

    <script src="../js/produtos/painel/listar_produto_painel.js"></script>
    <script src="../js/produtos/painel/pesquisar_produto_painel.js"></script>
    <script src="../js/produtos/painel/excluir_produto_painel.js"></script>
    <script src="../js/produtos/painel/importar_produto_painel.js"></script>
    <script src="../js/produtos/painel/salvar_produto_painel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>