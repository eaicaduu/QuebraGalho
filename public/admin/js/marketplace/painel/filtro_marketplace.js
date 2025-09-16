document.addEventListener("DOMContentLoaded", () => {

    document.getElementById('btnFiltro').addEventListener('click', function () {
        Swal.fire({
            title: 'Selecionar Plataformas',
            html: `
            <ul class="list-group text-start">
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <label class="d-flex align-items-center gap-3 mb-0" style="cursor: pointer;">
                        <img src="../../images/mercado-livre-logo.png" alt="Mercado Livre" style="max-height: 30px;">
                    </label>
                    <div class="form-check form-switch">
                    <input name="plataformas[]" value="mercado_livre" class="form-check-input" type="checkbox" role="switch"
                    id="switchMercadoLivre"></div>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <label class="d-flex align-items-center gap-3 mb-0" style="cursor: pointer;">
                        <img src="../../images/magalu-logo.png" alt="Magalu" style="max-height: 30px;">
                    </label>
                    <div class="form-check form-switch">
                    <input name="plataformas[]" value="magalu" class="form-check-input" type="checkbox" role="switch"
                    id="switchMagalu"></div>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <label class="d-flex align-items-center gap-3 mb-0" style="cursor: pointer;">
                        <img src="../../images/shopee-logo.png" alt="Shopee" style="max-height: 30px;">
                    </label>
                    <div class="form-check form-switch">
                    <input name="plataformas[]" value="shopee" class="form-check-input" type="checkbox" role="switch"
                    id="switchShopee"></div>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <label class="d-flex align-items-center gap-3 mb-0" style="cursor: pointer;">
                        <img src="../../images/amazon-logo.png" alt="Amazon" style="max-height: 30px;">
                    </label>
                    <div class="form-check form-switch">
                    <input name="plataformas[]" value="amazon" class="form-check-input" type="checkbox" role="switch"
                    id="switchAmazon"></div>
                </li>
            </ul>
        `,
            showCancelButton: true,
            confirmButtonText: 'Aplicar',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                document.getElementById('switchMercadoLivre').checked = localStorage.getItem('mercadoLivreChecked') === 'true';
                document.getElementById('switchMagalu').checked = localStorage.getItem('magaluChecked') === 'true';
                document.getElementById('switchShopee').checked = localStorage.getItem('shopeeChecked') === 'true';
                document.getElementById('switchAmazon').checked = localStorage.getItem('amazonChecked') === 'true';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.setItem('mercadoLivreChecked', document.getElementById('switchMercadoLivre').checked);
                localStorage.setItem('magaluChecked', document.getElementById('switchMagalu').checked);
                localStorage.setItem('shopeeChecked', document.getElementById('switchShopee').checked);
                localStorage.setItem('amazonChecked', document.getElementById('switchAmazon').checked);

            }
        });
    });

});
