<?php
require_once __DIR__ . '/../app/config/database.php';
session_start();

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM produtos WHERE status = 1 ORDER BY id ASC LIMIT 12");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM categorias");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalCarrinho = 0;
$carrinho = [];

if (isset($_SESSION['usuario_id'])) {

    $stmt = $conn->prepare("SELECT * FROM carrinho WHERE usuario_id = :uid");
    $stmt->bindValue(':uid', $_SESSION['usuario_id']);
    $stmt->execute();
    $carrinho = $stmt->fetchAll();

    $totalCarrinho = count($carrinho);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Quebra Galho Ferragem - Loja Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo.png">
    <link href="bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">

</head>


<style>
</style>

<body class="user-select-none">

    <?php include 'includes/index/nav/nav-sm.php'; ?>
    <?php include 'includes/index/nav/nav-xl.php'; ?>

    <?php include 'includes/index/favoritos.php'; ?>

    <?php include 'includes/produto/carrinho.php'; ?>

    <?php include 'includes/index/categorias.php'; ?>

    <?php include 'includes/index/body.php'; ?>

    <?php include 'includes/index/footer.php'; ?>

    <script>
        const isLoggedIn = <?= isset($_SESSION['usuario_documento']) ? 'true' : 'false' ?>;
        const totalCarrinho = <?= $totalCarrinho ?>;
    </script>
    <script src="js/conta/link.js"></script>
    <script src="js/carrinho/excluir_carrinho.js"></script>
    <script src="js/carrinho/buscar_carrinho.js"></script>
    <script src="js/favoritos/salvar_favoritos.js"></script>
    <script src="js/favoritos/buscar_favoritos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
</body>

</html>