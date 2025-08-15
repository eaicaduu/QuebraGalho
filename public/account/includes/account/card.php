<div class="container-fluid py-4 ps-lg-4">
    <div class="row g-4">
        <?php include 'account/includes/menu-desktop.php'; ?>

        <div class="col-12 col-lg-6 mx-auto">
            <div class="card shadow-sm p-4 h-100 d-flex flex-column">

                <div class="d-flex align-items-center gap-3 w-100 mb-3 flex-wrap">
                    <div class="position-relative" style="width: 48px; height: 48px;">
                        <div class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center bg-secondary position-relative"
                            style="width: 48px; height: 48px;">

                            <?php if (!empty($user['imagem_perfil'])): ?>
                                <img src="../app/<?php echo htmlspecialchars($user['imagem_perfil']); ?>"
                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute;"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div style="display: none; width: 100%; height: 100%;"
                                    class="d-flex justify-content-center align-items-center">
                                    <i class="bi bi-person-add" style="color: white; font-size: 1.5rem;"></i>
                                </div>
                            <?php else: ?>
                                <i class="bi bi-person" style="color: white; font-size: 1.5rem;"></i>
                            <?php endif; ?>
                        </div>

                        <label for="editarFotoInput"
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-25 rounded-circle"
                            style="cursor: pointer;">
                            <i class="bi bi-pencil-fill text-white opacity-0" style="font-size: 1rem;"></i>
                        </label>

                        <input type="file" id="editarFotoInput" name="nova_foto" class="d-none" accept="image/*">
                    </div>

                    <h5 class="mb-0">
                        Bem-vindo(a), <?php echo htmlspecialchars(explode(' ', trim($user['nome']))[0]); ?>!
                    </h5>
                </div>

                <form id="formPerfil">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <label for="nome" class="form-label"><strong>Nome:</strong></label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                value="<?php echo htmlspecialchars($user['nome']); ?>" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label"><strong>E-mail:</strong></label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="telefone" class="form-label"><strong>Telefone:</strong></label>
                            <input type="text" class="form-control" id="telefone" name="telefone" maxlength="15"
                                oninput="this.value = this.value.replace(/\D/g, '').replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3')"
                                value="<?php echo htmlspecialchars($user['telefone'] ?? ''); ?>">
                        </div>

                        <div class="col-12 col-md-5">
                            <label for="data_nascimento" class="form-label"><strong>Data de Nascimento:</strong></label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                                value="<?php echo !empty($user['data_nascimento']) ? date('Y-m-d', strtotime($user['data_nascimento'])) : ''; ?>">
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-start">
                        <button id="btnSalvar" class="btn btn-secondary" disabled>
                            <i class="bi bi-floppy-fill me-1"></i> Salvar
                        </button>

                        <?php if (isset($user['tipo_usuario']) && in_array($user['tipo_usuario'], [2, 3])): ?>
                            <a href="admin/painel.php" class="btn btn-dark">
                                <i class="bi bi-tools me-1"></i> Painel administrador
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>