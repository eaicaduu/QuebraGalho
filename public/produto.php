<?php
session_start();

require_once __DIR__ . '/../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$produtoId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($produtoId <= 0) {
    echo "<p>Produto inválido.</p>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$produtoId]);
$produtos = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produtos) {
    echo "<p>Produto não encontrado.</p>";
    exit;
}

$carrinho = [];
$totalCarrinho = 0;

if (isset($_SESSION['usuario_id'])) {
    $usuarioId = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("SELECT * FROM carrinho WHERE usuario_id = :uid");
    $stmt->bindValue(':uid', $usuarioId);
    $stmt->execute();
    $carrinho = $stmt->fetchAll();


    $totalCarrinho = count($carrinho);
}

$imagemSrc = (!isset($produtos['imagem_principal']) || trim($produtos['imagem_principal']) === '')
    ? "images/default.png"
    : "../app/" . $produtos['imagem_principal'];
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($produtos['nome']) ?> - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo.png">
    <link href="bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/index/nav/nav-sm.php'; ?>
    <?php include 'includes/index/nav/nav-xl.php'; ?>

    <?php include 'includes/index/favoritos.php'; ?>

    <?php include 'includes/produto/carrinho.php'; ?>

    <?php include 'includes/produto/produto.php'; ?>

    <script>
        const isLoggedIn = <?= isset($_SESSION['usuario_documento']) ? 'true' : 'false' ?>;
        const totalCarrinho = <?= $totalCarrinho ?>;
    </script>
    <script src="js/conta/link.js"></script>
    <script src="js/carrinho/excluir_carrinho.js"></script>
    <script src="js/carrinho/buscar_carrinho.js"></script>
    <script src="js/carrinho/salvar_carrinho.js"></script>
    <script src="js/favoritos/buscar_favoritos.js"></script>
    <script src="js/favoritos/salvar_favoritos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>