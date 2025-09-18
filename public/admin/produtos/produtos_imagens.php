<?php
session_start();

if (!isset($_SESSION['usuario_tipo']) || !in_array($_SESSION['usuario_tipo'], [2, 3])) {
    header("Location: ../../index.php");
    exit();
}

$paginaAtual = basename($_SERVER['PHP_SELF']);

require_once __DIR__ . '/../../../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmtProdutos = $conn->query("SELECT COUNT(*) as total FROM produtos");
$totalProdutos = $stmtProdutos->fetch(PDO::FETCH_ASSOC)['total'];

$stmtConfig = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

$nomeEmpresa = !empty($config['nome_empresa']) ? htmlspecialchars($config['nome_empresa']) : 'Minha Empresa';
$corPrincipal = !empty($config['cor_principal']) ? htmlspecialchars($config['cor_principal']) : '#000000';
$logo = !empty($config['logo'])
    ? '../../../app/uploads/logo/' . htmlspecialchars($config['logo'])
    : '../../images/default.png';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Produtos Imagens - <?= $nomeEmpresa ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= $logo ?>">
    <link rel="shortcut icon" href="<?= $logo ?>">
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/painel/nav.php'; ?>

    <?php include 'includes/painel/cards.php'; ?>

    <script src="../js/produtos/imagens/ordem_produto_imagens.js"></script>
    <script src="../js/produtos/imagens/adicionar_produto_imagens.js"></script>
    <script src="../js/produtos/imagens/excluir_produto_imagens.js"></script>
    <script src="../js/produtos/imagens/listar_produto_imagens.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>