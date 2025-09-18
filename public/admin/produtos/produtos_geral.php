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
    <title>Produtos Visão Geral - <?= $nomeEmpresa ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= $logo ?>">
    <link rel="shortcut icon" href="<?= $logo ?>">
    <link href="../../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/painel/nav.php'; ?>

    <?php include 'includes/painel/cards.php'; ?>

    <script src="../js/produtos/geral/formatar_preco_geral.js"></script>
    <script src="../js/produtos/geral/calculo_promocao_geral.js"></script>
    <script src="../js/produtos/geral/formatar_btn_geral.js"></script>
    <script src="../js/produtos/geral/edit_info_produtos_geral.js"></script>
    <script src="../js/produtos/geral/promocao_produtos_geral.js"></script>
    <script src="../js/produtos/geral/listar_produtos_geral.js"></script>
    <script src="../js/produtos/geral/pesquisar_produtos_geral.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
</body>

</html>