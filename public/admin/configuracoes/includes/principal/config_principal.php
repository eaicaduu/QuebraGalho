<div class="container mt-3 mt-lg-0">
    <form id="form-configuracoes" enctype="multipart/form-data">
        <div class="p-4 bg-body-secondary border rounded-3 shadow-sm">
            <div class="row g-3 align-items-center">

                <div class="row g-3 align-items-center">
                    <div class="col-12 col-lg-4">
                        <label for="nome_empresa" class="form-label">Nome da Empresa</label>
                        <input type="text" class="form-control" id="nome_empresa" name="nome_empresa"
                            value="<?= htmlspecialchars($nome_empresa) ?>">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="email" class="form-label">Email da Empresa</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?= htmlspecialchars($email) ?>">
                    </div>

                    <div class="col-12 col-lg-2">
                        <label for="cor_principal" class="form-label w-100">Cor Principal</label>
                        <input type="color" class="form-control form-control-color" id="cor_principal" name="cor_principal"
                            value="<?= htmlspecialchars($cor_principal) ?>">
                    </div>
                </div>

                <div class="col-12 col-lg-2">
                    <label for="telefone" class="form-label">Telefone (WhatsApp)</label>
                    <input type="text" class="form-control telefone" id="telefone" name="telefone"
                        value="<?= htmlspecialchars($telefone) ?>">
                </div>

                <div class="col-12 col-lg-2">
                    <label for="telefone_secundario" class="form-label">Telefone (Ligação)</label>
                    <input type="text" class="form-control telefone" id="telefone_secundario" name="telefone_secundario"
                        value="<?= htmlspecialchars($telefone_secundario) ?>">
                </div>

                <div class="col-12 col-lg-6">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($endereco) ?>"></input>
                </div>

                <div class="col-12 col-lg-6">
                    <label for="maps" class="form-label">Link Google Maps</label>
                    <input type="url" class="form-control" id="maps" name="maps"
                        value="<?= htmlspecialchars($maps) ?>">
                </div>

                <div class="col-12">
                    <label for="descricao" class="form-label">Descrição da Empresa</label>
                    <textarea class="form-control" id="descricao" name="descricao"
                        rows="2"><?= htmlspecialchars($descricao) ?></textarea>
                </div>

                <div class="col-12 col-md-3">
                    <label for="facebook" class="form-label">Link Facebook</label>
                    <input type="url" class="form-control" id="facebook" name="facebook"
                        value="<?= htmlspecialchars($facebook) ?>">
                </div>

                <div class="col-12 col-md-3">
                    <label for="instagram" class="form-label">Link Instagram</label>
                    <input type="url" class="form-control" id="instagram" name="instagram"
                        value="<?= htmlspecialchars($instagram) ?>">
                </div>

                <div class="col-12 col-md-3">
                    <label for="whatsapp" class="form-label">Número WhatsApp</label>
                    <input type="text" class="form-control telefone" id="whatsapp" name="whatsapp"
                        value="<?= htmlspecialchars($whatsapp) ?>">
                </div>

                <div class="row g-3 align-items-center">
                    <div class="col-12 col-md-2">
                        <img id="preview_logo" class="mx-3 pe-none"
                            src="<?= !empty($logo) ? '../../../app/uploads/logo/' . htmlspecialchars($logo) : '' ?>"
                            alt="Logo" style="max-height:80px; <?= empty($logo) ? 'display:none;' : '' ?>">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="logo" class="form-label">Selecionar Logo</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="file" class="form-control" id="logo" name="logo" style="max-width: 70%;">
                        </div>
                    </div>

                    <div class="col-12 col-md-4 d-flex justify-content-end">
                        <button type="button"
                            id="btn-salvar-config"
                            class="btn btn-secondary"
                            disabled
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Última alteração: <?= $ultima_alteracao ? date('d/m/Y H:i', strtotime($ultima_alteracao)) : 'Ainda não alterado' ?>">
                            Salvar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>