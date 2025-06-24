<?php
require_once __DIR__ . '/../app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$categoria_id = $_GET['categoria'] ?? null;

$produtos = [];
$categoria_nome = '';

if ($categoria_id) {
    $stmtCat = $conn->prepare("SELECT nome FROM categorias WHERE id = ?");
    $stmtCat->execute([$categoria_id]);
    $categoria = $stmtCat->fetch(PDO::FETCH_ASSOC);

    if ($categoria) {
        $categoria_nome = $categoria['nome'];
        $stmt = $conn->prepare("
            SELECT p.id, p.nome, p.descricao, p.preco, p.imagem
            FROM produtos p
            INNER JOIN categoria_produto cp ON cp.produto_id = p.id
            WHERE cp.categoria_id = ?
        ");
        $stmt->execute([$categoria_id]);
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $categoria_nome = 'Categoria não encontrada';
    }
} else {
    $categoria_nome = 'Categoria não especificada';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Produtos - <?= htmlspecialchars($categoria_nome) ?></title>
    <link rel="icon" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include 'includes/produtos/nav.php'; ?>

    <?php include 'includes/produtos/body.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>