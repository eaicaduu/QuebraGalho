<div class="col-12 col-md-6 mb-3">
    <div class="card shadow-sm border-0 h-100">
        <div class="d-flex flex-column flex-md-row align-items-center p-2 gap-3">

            <?php if (!empty($usuario['imagem_perfil'])): ?>
                <img src="../../../app/<?= htmlspecialchars($usuario['imagem_perfil']) ?>"
                    alt="<?= htmlspecialchars($usuario['nome']) ?>"
                    class="img-fluid rounded-start pe-none"
                    style="width:80px;height:80px;object-fit:cover;">
            <?php else: ?>
                <div class="d-flex justify-content-center align-items-center bg-light rounded-start"
                    style="width:80px;height:80px;">
                    <i class="bi bi-person-fill text-secondary fs-2"></i>
                </div>
            <?php endif; ?>

            <div class="flex-grow-1 w-100">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <h6 class="mb-1 fw-bold"><?= htmlspecialchars($usuario['nome']) ?></h6>
                    <small class="text-muted">
                        <strong>CPF:</strong>
                        <?= preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $usuario['documento']) ?>
                    </small>
                </div>

                <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>

                <?php
                $tipoUsuario = (int)$usuario['tipo_usuario'];
                $tipoNome = ["Usuário", "PJ", "Funcionário", "Administrador"][$tipoUsuario] ?? "Desconhecido";
                $badge = ["secondary", "warning", "primary", "success"][$tipoUsuario] ?? "dark";
                ?>
                <span class="badge bg-<?= $badge ?>"><?= $tipoNome ?></span>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted">
                        Criado em <?= date("d/m/Y", strtotime($usuario['criado_em'])) ?>
                    </small>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary btn-editar-usuario"
                            data-id="<?= $usuario['id'] ?>"
                            data-nome="<?= htmlspecialchars($usuario['nome']) ?>"
                            data-cpf="<?= htmlspecialchars($usuario['documento']) ?>"
                            data-email="<?= htmlspecialchars($usuario['email']) ?>"
                            data-tipo="<?= $tipoUsuario ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-excluir-usuario"
                            data-id="<?= $usuario['id'] ?>"
                            data-nome="<?= htmlspecialchars($usuario['nome']) ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>