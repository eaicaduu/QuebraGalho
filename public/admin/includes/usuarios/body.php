<div class="container-fluid mt-2">
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Criado em</th>
                    <th style="width: 150px;">Ações</th>
                </tr>
            </thead>
            <tbody>

                <tr id="linha-nenhum-usuario" style="display: none;">
                    <td colspan="7" class="text-center text-muted">Nenhum usuário encontrado.</td>
                </tr>

                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id']) ?></td>
                            <td><?= htmlspecialchars($usuario['nome']) ?></td>
                            <td><?= htmlspecialchars(formatarCPF($usuario['cpf'])) ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                            <td>
                                <?php if ($usuario['perm_admin'] == 1): ?>
                                    <span class="badge bg-success">Sim</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Não</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($usuario['criado_em'])) ?></td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-primary btn-editar-usuario" data-id="<?= $usuario['id'] ?>"
                                        data-nome="<?= htmlspecialchars($usuario['nome'], ENT_QUOTES) ?>"
                                        data-cpf="<?= $usuario['cpf'] ?>"
                                        data-email="<?= htmlspecialchars($usuario['email'], ENT_QUOTES) ?>"
                                        data-admin="<?= $usuario['perm_admin'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger btn-excluir-usuario" data-id="<?= $usuario['id'] ?>"
                                        data-nome="<?= htmlspecialchars($usuario['nome'], ENT_QUOTES) ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhum usuário cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>