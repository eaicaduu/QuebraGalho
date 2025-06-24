<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../../app/config/database.php';
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM usuarios ORDER BY id DESC");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatarCPF($cpf)
{
    $cpf = preg_replace('/\D/', '', $cpf);
    if (strlen($cpf) === 11) {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }
    return $cpf;
}

$totalUsuarios = count($usuarios);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Usuários - Quebra Galho</title>
    <link rel="icon" href="../images/logo.png">
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/usuarios/nav.php'; ?>

    <?php include 'includes/usuarios/body.php'; ?>

    <script src="js/usuarios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>