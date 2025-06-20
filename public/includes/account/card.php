<div class="container mt-2">
    <div class="card shadow-sm">
        <div class="card-body">
            <form id="formAccount">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control"
                        value="<?php echo htmlspecialchars($user['nome']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF:</label>
                    <input type="text" id="cpf" class="form-control"
                        value="<?php echo htmlspecialchars($user['cpf']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="nova_senha" class="form-label">Nova senha:</label>
                    <input type="password" name="nova_senha" id="nova_senha" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="confirmar_senha" class="form-label">Confirmar nova senha:</label>
                    <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-secondary" id="btnSalvar" disabled>Salvar Alterações</button>

                    <a href="logout.php" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                </div>


            </form>
        </div>
    </div>
</div>