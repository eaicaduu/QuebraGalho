<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

if (!isset($_SESSION['usuario_cpf'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$cpf = $_SESSION['usuario_cpf'];

$stmt = $db->prepare("SELECT nome, cpf, email, perm_admin FROM usuarios WHERE cpf = :cpf");
$stmt->bindParam(':cpf', $cpf);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Minha Conta - Ferragem</title>
    <link rel="stylesheet" href="css/account.css">
    <link rel="icon" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/account/nav.php'; ?>
    <?php include 'includes/account/card.php'; ?>

    <script>
    const userData = {
        nome: "<?php echo addslashes($user['nome']); ?>",
        email: "<?php echo addslashes($user['email']); ?>"
    };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/account.js"></script>
</body>

</html>