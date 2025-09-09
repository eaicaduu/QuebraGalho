<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

if (!isset($_SESSION['usuario_documento'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$documento = $_SESSION['usuario_documento'];

$stmt = $db->prepare("SELECT * FROM usuarios WHERE documento = :documento");
$stmt->bindParam(':documento', $documento);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$paginaAtual = 'conta';
$basePath = 'account/';
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Minha Conta - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo.png">
    <link href="bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="user-select-none">

    <?php include 'account/includes/account/nav.php'; ?>

    <?php include 'account/includes/account/card.php'; ?>

    <script>
        const userData = {
            nome: "<?php echo addslashes($user['nome']); ?>",
            email: "<?php echo addslashes($user['email']); ?>"
        };
    </script>
    <script src="js/conta/account.js"></script>
    <script src="bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>