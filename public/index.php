<?php
session_start();

if (!isset($_SESSION['config'])) {
    header("Location: ../index.php");
    exit;
}

$config = $_SESSION['config'] ?? [];
$modo_site = $config['modo_site'] ?? 1;

if ($modo_site == 0) {
    include __DIR__ . '/includes/index/acesso.php';
}

require_once __DIR__ . '/../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM produtos WHERE status = 1 AND destaque = 0 ORDER BY id ASC LIMIT 12");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM produtos WHERE status = 1 AND destaque = 1");
$stmt->execute();
$destaques = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM categorias WHERE status = 1");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT imagem FROM carousel ORDER BY id DESC");
$imagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalCarrinho = 0;
$carrinho = [];
$usuario = null;

if (isset($_SESSION['usuario_id'])) {

    $stmt = $conn->prepare("SELECT * FROM carrinho WHERE usuario_id = :id");
    $stmt->bindValue(':id', $_SESSION['usuario_id']);
    $stmt->execute();
    $carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalCarrinho = count($carrinho);

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id LIMIT 1");
    $stmt->bindValue(':id', $_SESSION['usuario_id']);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $usuario['nome'] = htmlspecialchars($usuario['nome']);
        $usuario['imagem_perfil'] = !empty($usuario['imagem_perfil'])
            ?  '../app/' . htmlspecialchars($usuario['imagem_perfil'])
            : 'images/default.png';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= $config['nomeEmpresa'] ?></title>
    <meta name="description" content="A Quebra Galho Ferragem oferece os melhores produtos em ferramentas, elétrica, hidráulica e construção. Atendimento rápido, produtos de qualidade e os melhores preços da região.">
    <meta name="keywords" content="ferragem, materiais de construção, ferramentas, elétrica, hidráulica, parafusos, porcas, pregos, cimento, tinta, construção, loja de ferragens">
    <meta name="author" content="Quebra Galho Ferragem">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="Quebra Galho Ferragem">
    <meta property="og:description" content="Tudo para sua obra ou reforma em um só lugar. Ferragens, materiais elétricos e hidráulicos com os melhores preços.">
    <meta property="og:url" content="https://quebragalhoferragem.com.br/">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <link rel="canonical" href="https://quebragalhoferragem.com.br/">
    <link rel="icon" type="image/png" href="<?= $config['logo'] ?>">
    <link rel="shortcut icon" href="<?= $config['logo'] ?>">
    <link href="bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>


<style>
</style>

<body style="user-select: none; background-color: <?= $config['corPrincipal'] ?>;">

    <?php include 'includes/index/nav/nav-xl.php'; ?>
    <?php include 'includes/index/nav/menu-sm.php'; ?>
    <?php include 'includes/index/nav/nav-sm.php'; ?>

    <?php include 'includes/index/categorias.php'; ?>

    <?php include 'includes/index/carousel.php'; ?>

    <?php include 'includes/index/destaques.php'; ?>

    <?php include 'includes/index/produtos.php'; ?>

    <?php include 'includes/index/footer.php'; ?>

    <script>
        const isLoggedIn = <?= isset($_SESSION['usuario_documento']) ? 'true' : 'false' ?>;
    </script>
    <script src="js/conta/link.js"></script>
    <script src="js/index/acesso.js"></script>
    <script src="js/categorias/categorias.js"></script>
    <script src="js/carrinho/buscar_carrinho.js"></script>
    <script src="js/favoritos/salvar_favoritos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>