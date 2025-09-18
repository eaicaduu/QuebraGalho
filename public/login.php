<?php
session_start();

if (isset($_SESSION['usuario_documento'])) {
    header("Location: account.php");
    exit();
}

require_once __DIR__ . '/../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmtConfig = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

$nomeEmpresa = !empty($config['nome_empresa']) ? htmlspecialchars($config['nome_empresa']) : 'Minha Empresa';
$logo = !empty($config['logo'])
    ? '../app/uploads/logo/' . htmlspecialchars($config['logo'])
    : 'images/default.png';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - <?= $nomeEmpresa ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= $logo ?>">
    <link rel="shortcut icon" href="<?= $logo ?>">
    <link href="bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/conta/login.php'; ?>

    <script src="bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
    <script src="js/conta/login.js"></script>
</body>

</html>