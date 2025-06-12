<?php
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';

$database = new Database();
$db = $database->getConnection();

$productController = new ProductController($db);
$products = $productController->list();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/logo.png">
    <title>Ferragem Quebra Galho - Loja Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="user-select-none">

    <?php include 'includes/index/nav.php'; ?>

    <!-- Container principal -->
    <div class="container">
        <h1 class="text-center mb-4">Nossos Produtos</h1>

        <div class="row">
            <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <!-- Imagem do produto (no futuro podemos implementar) -->
                    <img src="https://via.placeholder.com/300x200?text=Produto" class="card-img-top"
                        alt="<?php echo htmlspecialchars($row['name']); ?>">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="text-success fw-bold">R$ <?php echo number_format($row['price'], 2, ',', '.'); ?></p>

                        <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>