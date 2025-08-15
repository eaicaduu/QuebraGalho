document.addEventListener("DOMContentLoaded", () => {


});

function voltarParaModalAdicionar() {
    const modalBuscar = bootstrap.Modal.getInstance(document.getElementById('modalBuscar'));
    if (modalBuscar) modalBuscar.hide();

    const modalAdicionar = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalAdicionar'));
    modalAdicionar.show();
}
