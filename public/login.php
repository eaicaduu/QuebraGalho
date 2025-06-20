<?php 
session_start();
if (isset($_SESSION['usuario_cpf'])) {
    header("Location: account.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/logo.png">
    <title>Login - Quebra Galho</title>
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
            <div class="mb-4 d-flex align-items-center">
                <button class="btn btn-link text-decoration-none text-dark me-3 p-0" onclick="history.back()">
                    <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem;"></i>
                </button>
                <h5 class="mb-0">Insira os seus dados de acesso:</h5>
            </div>

            <form id="loginForm">

                <input maxlength="14" placeholder="CPF" name="cpf" id="cpf" class="form-control mb-3" autofocus
                    value="<?php echo isset($_COOKIE['remember_cpf']) ? htmlspecialchars($_COOKIE['remember_cpf']) : ''; ?>">

                <div class="mb-3 position-relative">
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" value="<?php 
                     if (isset($_COOKIE['remember_senha'])) { 
                     $chave = 'minha-chave-secreta';
                     echo htmlspecialchars(openssl_decrypt($_COOKIE['remember_senha'], 'AES-128-ECB', $chave));
                     }
                    ?>">
                    <i class="bi bi-eye" id="toggle-password"
                        style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer;"></i>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            <a class="text-decoration-none text-dark">Lembrar-me</a>
                        </label>
                    </div>
                    <div>
                        <a href="senha.php" class="text-decoration-none text-dark" style="cursor: default;">Esqueci
                            minha senha</a>
                    </div>
                </div>

                <button type="submit" id="submitButton" class="btn btn-warning w-100 mb-3">Entrar </button>

                <div class="text-center" id="cadastroLink">
                    <a href="cadastro.php" class="text-decoration-none text-dark">Ainda não tem conta?
                        <strong>Cadastre-se</strong></a>
                </div>

            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/login.js"></script>
</body>

</html>