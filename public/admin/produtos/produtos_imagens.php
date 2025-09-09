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
    <title>Produtos Imagens - Quebra Galho</title>
    <link rel="icon" href="../../images/logo.png">
    <link rel="stylesheet" href="../../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/imagens/nav.php'; ?>

    <?php include 'includes/imagens/produtos.php'; ?>

    <script src="../js/produtos/imagens/ordem_produto_imagens.js"></script>
    <script src="../js/produtos/imagens/adicionar_produto_imagens.js"></script>
    <script src="../js/produtos/imagens/excluir_produto_imagens.js"></script>
    <script src="../js/produtos/imagens/listar_produto_imagens.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>