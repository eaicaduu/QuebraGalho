<!DOCTYPE html>
<html>

<head>
    <title>Produtos - Quebra Galho</title>
</head>

<body>
    <h1>Produtos disponíveis</h1>

    <ul>
        <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
        <li>
            <?php echo htmlspecialchars($row['name']) . " - R$ " . number_format($row['price'], 2, ',', '.'); ?>
        </li>
        <?php endwhile; ?>
    </ul>
</body>

</html>