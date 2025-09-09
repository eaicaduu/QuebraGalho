<div class="container-fluid">
  <div class="row">
    <!-- Menu lateral de plataformas -->
    <div class="col-12 col-lg-3">
      <div class="card shadow-sm mb-4">
        <div class="card-header">
          <h5 class="mb-0">Selecionar Plataformas</h5>
        </div>
        <ul class="list-group list-group-flush">

          <!-- Mercado Livre -->
          <li class="list-group-item d-flex align-items-center justify-content-between">
            <label for="switchMercadoLivre" class="d-flex align-items-center gap-3 mb-0" style="cursor: pointer;">
              <img src="../../images/mercado-livre-logo.png"
                alt="Mercado Livre" style="max-height: 30px;">
            </label>
            <div class="form-check form-switch m-0">
              <input name="plataformas[]" value="mercado_livre" class="form-check-input" type="checkbox" role="switch"
                id="switchMercadoLivre">
            </div>
          </li>

          <!-- Magalu -->
          <li class="list-group-item d-flex align-items-center justify-content-between">
            <label for="switchMagalu" class="d-flex align-items-center gap-3" style="cursor: pointer;">
              <img src="../../images/magalu-logo.png" alt="Magalu"
                style="max-height: 30px;">
            </label>
            <div class="form-check form-switch m-0">
              <input name="plataformas[]" value="magalu" class="form-check-input" type="checkbox" role="switch"
                id="switchMagalu">
            </div>
          </li>

          <!-- Shopee -->
          <li class="list-group-item d-flex align-items-center justify-content-between">
            <label for="switchShopee" class="d-flex align-items-center gap-3" style="cursor: pointer;">
              <img src="../../images/shopee-logo.png" alt="Shopee"
                style="max-height: 30px;">
            </label>
            <div class="form-check form-switch m-0">
              <input name="plataformas[]" value="shopee" class="form-check-input" type="checkbox" role="switch"
                id="switchShopee">
            </div>
          </li>

          <!-- Amazon -->
          <li class="list-group-item d-flex align-items-center justify-content-between">
            <label for="switchAmazon" class="d-flex align-items-center gap-3" style="cursor: pointer;">
              <img src="../../images/amazon-logo.png" alt="Amazon"
                style="max-height: 30px;">
            </label>
            <div class="form-check form-switch m-0">
              <input name="plataformas[]" value="amazon" class="form-check-input" type="checkbox" role="switch"
                id="switchAmazon">
            </div>
          </li>

        </ul>
      </div>
    </div>

    <?php include 'includes/produtos.php'; ?>

  </div>
</div>