<div class="modal fade show d-block" id="modalAcesso" tabindex="-1" aria-hidden="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="form-acesso">
        <div class="modal-header">
          <h5 class="modal-title">Acesso Restrito</h5>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
          </div>
          <div id="erro-senha" class="text-danger mt-2" style="display:none;"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn-acesso" class="btn btn-secondary w-100" disabled>Entrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
