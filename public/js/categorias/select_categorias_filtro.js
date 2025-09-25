function redirecionarCategoria(select) {
    const categoria = select.value;
    const params = new URLSearchParams(window.location.search);

    if (categoria === "") {
        params.delete('categoria');
    } else {
        params.set('categoria', categoria);
    }
    window.location.search = params.toString();
}

function redirecionarMarca(select) {
    const marca = select.value;
    const url = new URL(window.location.href);
    if (marca) {
        url.searchParams.set('marca', marca);
    } else {
        url.searchParams.delete('marca');
    }
    window.location.href = url.toString();
}