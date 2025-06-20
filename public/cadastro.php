<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro - Quebra Galho</title>
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="css/cadastro.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <?php 
$erroCadastro = isset($_GET['erro']);
?>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm p-4">

            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-decoration-none text-dark me-3 p-0" onclick="history.back()">
                        <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem;"></i>
                    </button>
                    <h5 class="mb-0">Crie sua conta</h5>
                </div>
                <i id="errorIcon" class="bi bi-exclamation-circle-fill text-danger"
                    style="font-size: 1.5rem; display: none;" title="Há divergência nos campos"></i>
            </div>


            <form id="cadastroForm">

                <div class="mb-3">
                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome completo">
                </div>

                <div class="mb-3">
                    <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF" maxlength="14">
                </div>


                <div class="mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="E-mail">
                </div>

                <div class="mb-3 position-relative">
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha">
                    <i class="bi bi-eye toggle-password"
                        style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer;"></i>
                </div>

                <div class="mb-3 position-relative">
                    <input type="password" name="confirmarSenha" id="confirmarSenha" class="form-control"
                        placeholder="Confirmar senha">
                    <i class="bi bi-eye toggle-password"
                        style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer;"></i>
                </div>


                <button type="submit" id="submitButton" class="btn btn-success w-100 mb-3">Cadastrar</button>

                <div class="text-center" id="loginLink">
                    <a href="login.php" class="text-decoration-none text-dark">Já tem conta? <strong>Fazer
                            login</strong></a>
                </div>

            </form>


        </div>
    </div>

    <script src="js/cadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>