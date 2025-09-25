<?php
session_start();

if (!isset($_SESSION['usuario_tipo']) || !in_array($_SESSION['usuario_tipo'], [2, 3])) {
    header("Location: ../../index.php");
    exit();
}

require_once __DIR__ . '/../../../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmtConfig = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

$nomeEmpresa = !empty($config['nome_empresa']) ? htmlspecialchars($config['nome_empresa']) : 'Minha Empresa';
$logo = !empty($config['logo'])
    ? '../../../app/uploads/logo/' . htmlspecialchars($config['logo'])
    : '../../images/default.png';


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Usuários - <?= $nomeEmpresa ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= $logo ?>">
    <link rel="shortcut icon" href="<?= $logo ?>">
    <link href="../../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/nav.php'; ?>

    <?php include 'includes/usuarios.php'; ?>

    <script src="../js/usuarios/excluir_usuarios.js"></script>
    <script src="../js/usuarios/editar_usuarios.js"></script>
    <script src="../js/usuarios/pesquisar_usuarios.js"></script>
    <script src="../js/usuarios/exportar_usuarios.js"></script>
    <script src="../js/usuarios/criar_usuarios.js"></script>
    <script src="../js/usuarios/listar_usuarios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
</body>

</html>