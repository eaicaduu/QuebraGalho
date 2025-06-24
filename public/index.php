<?php
require_once __DIR__ . '/../app/config/database.php';
session_start();

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM produtos WHERE status = 1 ORDER BY id DESC");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT id, nome FROM categorias");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    <?php include 'includes/index/categorias.php'; ?>

    <?php include 'includes/index/banner.php'; ?>

    <?php include 'includes/index/body.php'; ?>

    <?php include 'includes/index/footer.php'; ?>

    <script>
        const isLoggedIn = <?= isset($_SESSION['usuario_cpf']) ? 'true' : 'false' ?>;
    </script>
    <script src="js/salvar_produto.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>