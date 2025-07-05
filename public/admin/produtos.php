<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM produtos ORDER BY id ASC");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalProdutos = count($produtos);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Produtos - Quebra Galho</title>
    <link rel="icon" href="../images/logo.png">
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/produtos/nav.php'; ?>

    <?php include 'includes/produtos/body.php'; ?>

    <script src="js/produtos/importar_produto.js"></script>
    <script src="js/produtos/adicionar_produto.js"></script>
    <script src="js/produtos/editar_produto.js"></script>
    <script src="js/produtos/excluir_produto.js"></script>
    <script src="js/produtos/pesquisar_produto.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>