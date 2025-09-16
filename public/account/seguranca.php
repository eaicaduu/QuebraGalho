<?php
session_start();

if (!isset($_SESSION['usuario_documento'])) {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmtConfig = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

$logo = !empty($config['logo'])
    ? '../../app/uploads/logo/' . htmlspecialchars($config['logo'])
    : '../images/default.png';


$documento = $_SESSION['usuario_documento'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE documento = :documento");
$stmt->bindParam(':documento', $documento);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$paginaAtual = 'seguranca';
$basePath = '';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Segurança</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= $logo ?>">
    <link rel="shortcut icon" href="<?= $logo ?>">
    <link href="../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/seguranca/nav.php'; ?>

    <?php include 'includes/seguranca/card.php'; ?>

    <script src="../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>

</body>

</html>