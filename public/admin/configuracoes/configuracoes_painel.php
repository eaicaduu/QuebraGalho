<?php
session_start();

if (!isset($_SESSION['usuario_tipo']) || !in_array($_SESSION['usuario_tipo'], [2, 3])) {
    header("Location: ../../index.php");
    exit();
}

$paginaAtual = 'principal';

require_once __DIR__ . '/../../../app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $stmt->fetch(PDO::FETCH_ASSOC);

$nome_empresa        = $config['nome_empresa'] ?? 'Minha Empresa';
$cor_principal       = $config['cor_principal'] ?? '#000000';
$telefone            = $config['telefone'] ?? '';
$telefone_secundario = $config['telefone_secundario'] ?? '';
$email               = $config['email'] ?? '';
$endereco            = $config['endereco'] ?? '';
$maps                = $config['maps'] ?? '';
$descricao           = $config['descricao'] ?? '';
$facebook            = $config['facebook'] ?? '';
$instagram           = $config['instagram'] ?? '';
$whatsapp            = $config['whatsapp'] ?? '';
$ultima_alteracao = $config['atualizado_em'] ?? null;
$logo                = !empty($config['logo'])
    ? '../../../app/uploads/logo/' . htmlspecialchars($config['logo'])
    : '../../images/default.png';


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Configurações - <?= $nome_empresa ?></title>
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

    <script src="../js/configuracoes/painel/formatar_config_painel.js"></script>
    <script src="../js/configuracoes/painel/edit_config_painel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
</body>

</html>