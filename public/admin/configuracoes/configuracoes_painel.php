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

$nome_empresa    = $config['nome_empresa']    ?? '';
$cor_principal= $config['cor_principal']?? '#000000';
$telefone     = $config['telefone']     ?? '';
$telefone_secundario     = $config['telefone_secundario']     ?? '';
$email        = $config['email']        ?? '';
$endereco     = $config['endereco']     ?? '';
$logo         = $config['logo']         ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Configurações - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../images/logo.png">
    <link href="../../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/painel/nav.php'; ?>

    <?php include 'includes/painel/cards.php'; ?>

    <script src="../js/configuracoes/painel/edit_config_painel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
</body>

</html>