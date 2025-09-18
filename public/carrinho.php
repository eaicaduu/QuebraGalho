<?php
require_once __DIR__ . '/../app/config/database.php';
session_start();

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['usuario_id'])) {
  header('Location: login.php');
  exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmtConfig = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

$logo = !empty($config['logo'])
  ? '../app/uploads/logo/' . htmlspecialchars($config['logo'])
  : 'images/default.png';


$stmt = $conn->prepare("SELECT * FROM carrinho WHERE usuario_id = ? AND status = 0");
$stmt->execute([$usuario_id]);
$itens_carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Carrinho - Quebra Galho</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?= $logo ?>">
  <link rel="shortcut icon" href="<?= $logo ?>">
  <link href="bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

  <?php include 'includes/carrinho/nav.php'; ?>

  <?php include 'includes/carrinho/carrinho.php'; ?>

  <script src="js/carrinho/produtos_carrinho.js"></script>
  <script src="js/carrinho/excluir_carrinho.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
</body>

</html>