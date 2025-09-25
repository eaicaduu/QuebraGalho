<div class="container mt-3 mt-lg-0">
    <div class="p-4 bg-body-secondary border rounded-3 shadow-sm">
        <div class="row g-3 align-items-center">
            <div class="form-check form-switch">
                <input class="form-check-input"
                    type="checkbox"
                    id="modoSiteSwitch"
                    name="modo_site"
                    value="1"
                    <?php if ($modo_site == 1) echo "checked"; ?>>
                <label class="form-check-label" for="modoSiteSwitch">
                    <?php echo ($modo_site == 1) ? "E-commerce" : "Landing Page"; ?>
                </label>
            </div>
            <div>
                <button type="button"
                    id="btn-salvar-config"
                    class="btn btn-secondary"
                    disabled
                    data-bs-toggle="tooltip"
                    data-bs-placement="top">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>