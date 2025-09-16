<div class="col-12 col-lg-9">
    <form id="form-configuracoes" enctype="multipart/form-data">
        <div class="row g-3">

            <div class="col-12 col-md-6">
                <label for="nome_empresa" class="form-label">Nome da Empresa</label>
                <input type="text" class="form-control" id="nome_empresa" name="nome_empresa"
                    value="<?= htmlspecialchars($nome_empresa) ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= htmlspecialchars($email) ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="telefone" class="form-label">Telefone 1</label>
                <input type="text" class="form-control" id="telefone" name="telefone"
                    value="<?= htmlspecialchars($telefone) ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="telefone_secundario" class="form-label">Telefone 2</label>
                <input type="text" class="form-control" id="telefone_secundario" name="telefone_secundario"
                    value="<?= htmlspecialchars($telefone_secundario) ?>">
            </div>

            <div class="col-12 col-md-2 d-flex flex-column">
                <label for="cor_principal" class="form-label">Cor Principal</label>
                <input type="color" class="form-control form-control-color" id="cor_principal" name="cor_principal"
                    value="<?= htmlspecialchars($cor_principal) ?>">
            </div>

            <div class="col-12">
                <label for="endereco" class="form-label">Endereço</label>
                <textarea class="form-control" id="endereco" name="endereco"
                    rows="2"><?= htmlspecialchars($endereco) ?></textarea>
            </div>

            <div class="col-12 col-md-6">
                <label for="logo" class="form-label">Logo da Loja</label>
                <div class="d-flex align-items-center gap-3">
                    <input type="file" class="form-control" id="logo" name="logo" style="max-width: 70%;">

                    <?php if ($logo): ?>
                        <img id="preview_logo" src="../../../app/uploads/logo/<?= htmlspecialchars($logo) ?>"
                            alt="Logo" style="max-height:50px;">
                    <?php else: ?>
                        <img id="preview_logo" src="" alt="Logo"
                            style="max-height:50px; display:none;">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="button" id="btn-salvar-config" class="btn btn-success">Salvar Configurações</button>
        </div>
    </form>
</div>