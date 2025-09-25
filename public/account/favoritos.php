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

$usuarioId = $_SESSION['usuario_id'];

$stmt = $conn->prepare("
    SELECT f.id AS favorito_id, f.usuario_id, f.produto_id,
           p.id, p.nome, p.desc_curta, p.preco, p.preco_promocional,
           p.imagem_principal, p.promocao, p.desconto_percentual,
           p.avaliacao_media, p.quantidade_avaliacoes
    FROM favoritos f
    INNER JOIN produtos p ON f.produto_id = p.id
    WHERE f.usuario_id = :usuario_id
");
$stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
$stmt->execute();
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);


$paginaAtual = 'favoritos';
$basePath = '';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Favoritos - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= $logo ?>">
    <link rel="shortcut icon" href="<?= $logo ?>">
    <link href="../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/favoritos/nav.php'; ?>

    <?php include 'includes/favoritos/card.php'; ?>

    <script src="../js/favoritos/salvar_favoritos.js"></script>
    <script src="../bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>

</body>

</html>