function redirecionarCategoria(select) {
    const categoria = select.value;
    if (categoria) {
        window.location.href = "categoria.php?categoria=" + encodeURIComponent(categoria);
    } else {
        window.location.href = "categoria.php";
    }
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