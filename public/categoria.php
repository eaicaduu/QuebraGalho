    <?php
    require_once __DIR__ . '/../app/config/database.php';
    session_start();

    $db = new Database();
    $conn = $db->getConnection();

    $categoria_id = $_GET['categoria'] ?? null;
    $marca_id = $_GET['marca'] ?? null;

    $stmtConfig = $conn->query("SELECT * FROM configuracao LIMIT 1");
    $config = $stmtConfig->fetch(PDO::FETCH_ASSOC);
    $nomeEmpresa = !empty($config['nome_empresa']) ? htmlspecialchars($config['nome_empresa']) : 'Minha Empresa';
    $logo = !empty($config['logo'])
        ? '../app/uploads/logo/' . htmlspecialchars($config['logo'])
        : 'images/default.png';

    $stmtCategorias = $conn->query("SELECT id, nome FROM categorias ORDER BY nome ASC");
    $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

    $stmtMarcas = $conn->query("SELECT DISTINCT marca FROM produtos WHERE marca IS NOT NULL AND marca != '' ORDER BY marca ASC");
    $marcas = $stmtMarcas->fetchAll(PDO::FETCH_ASSOC);
    
    $produtos = [];
    $categoria_nome = '';

    if ($categoria_id) {
        $stmtCat = $conn->prepare("SELECT nome FROM categorias WHERE id = ?");
        $stmtCat->execute([$categoria_id]);
        $categoria = $stmtCat->fetch(PDO::FETCH_ASSOC);

        if ($categoria) {
            $categoria_nome = $categoria['nome'];
            $stmt = $conn->prepare("
                SELECT *
                FROM produtos
                WHERE categoria_id = ?
                AND status = 1
            ");
            $stmt->execute([$categoria_id]);
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $categoria_nome = 'Categoria não encontrada';
        }
    } else {
        $categoria_nome = 'Categoria não especificada';
    }

    $totalCarrinho = 0;
    $carrinho = [];
    $usuario = null;

    if (isset($_SESSION['usuario_id'])) {

        $stmt = $conn->prepare("SELECT * FROM carrinho WHERE usuario_id = :id");
        $stmt->bindValue(':id', $_SESSION['usuario_id']);
        $stmt->execute();
        $carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalCarrinho = count($carrinho);

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $_SESSION['usuario_id']);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $usuario['nome'] = htmlspecialchars($usuario['nome']);
            $usuario['imagem_perfil'] = !empty($usuario['imagem_perfil'])
                ?  '../app/' . htmlspecialchars($usuario['imagem_perfil'])
                : 'images/default.png';
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8" />
        <title><?= htmlspecialchars($categoria_nome) . ' - ' . $nomeEmpresa ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="<?= $logo ?>">
        <link rel="shortcut icon" href="<?= $logo ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    </head>

    <body>

        <?php include 'includes/index/nav/nav-xl.php'; ?>
        <?php include 'includes/index/nav/menu-sm.php'; ?>
        <?php include 'includes/index/nav/nav-sm.php'; ?>

        <?php include 'includes/categoria/produtos.php'; ?>

        <script src="js/conta/link.js"></script>
        <script src="js/categorias/select_categorias_filtro.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>