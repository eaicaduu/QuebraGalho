<?php 
session_start();
if (isset($_SESSION['usuario_documento'])) {
    header("Location: account.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo.png">
    <link href="bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <?php
    $erroCadastro = isset($_GET['erro']);
    ?>

    <?php include 'includes/conta/cadastro.php'; ?>

    <script src="js/conta/cadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>

</body>

</html>