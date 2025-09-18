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

$stmt = $conn->prepare("
    SELECT c.id, c.nome, c.oferta, 
           GROUP_CONCAT(p.nome SEPARATOR ', ') AS produtos_nome
    FROM categorias c
    LEFT JOIN produtos p ON p.categoria_id = c.id
    GROUP BY c.id, c.nome, c.oferta
    ORDER BY c.id ASC
");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtCategorias = $conn->query("SELECT COUNT(*) as total FROM categorias");
$totalCategorias = $stmtCategorias->fetch(PDO::FETCH_ASSOC)['total'];

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
    <title>Produtos Categorias - <?= $nomeEmpresa ?></title>
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

    <script src="../js/produtos/categorias/listar_produtos_categorias.js"></script>
    <script src="../js/produtos/categorias/excluir_produtos_categorias.js"></script>
    <script src="../js/produtos/categorias/oferta_produtos_categorias.js"></script>
    <script src="../js/produtos/categorias/edit_nome_produtos_categorias.js"></script>
    <script src="../js/produtos/categorias/check_switch_produtos_categorias.js"></script>
    <script src="../js/produtos/categorias/pesquisar_produtos_categorias.js"></script>
    <script src="../js/produtos/categorias/adicionar_produtos_categorias.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>