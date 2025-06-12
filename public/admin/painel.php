<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo - Quebra Galho</title>
    <link rel="icon" href="../images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/nav.php'; ?>

    <!-- CONTEÚDO -->
    <div class="container">
        <h1 class="mb-4">Bem-vindo ao Painel Administrativo!</h1>

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-2">Produtos</h5>
                        <a href="#" class="btn btn-primary mt-2">Gerenciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-check" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-2">Pedidos</h5>
                        <a href="#" class="btn btn-primary mt-2">Gerenciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-clipboard-data" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-2">Estoque</h5>
                        <a href="#" class="btn btn-primary mt-2">Gerenciar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mais áreas -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-people" style="font-size: 3rem;"></i>
                        <h5 class="card-title mt-2">Usuários</h5>
                        <a href="#" class="btn btn-primary mt-2">Gerenciar</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS (opcional, caso queira dropdown etc) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>