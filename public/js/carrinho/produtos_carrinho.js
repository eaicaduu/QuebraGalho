document.addEventListener("DOMContentLoaded", () => {

    const inicializarSelecaoProdutos = () => {
        const selecionarTodos = document.getElementById("selecionarTodos");
        if (selecionarTodos) {
            selecionarTodos.addEventListener("change", () => {
                const checked = selecionarTodos.checked;
                document.querySelectorAll(".seletor-produto-xl, .seletor-produto-sm").forEach(chk => chk.checked = checked);
                atualizarResumo();
            });
        }

        document.querySelectorAll(".seletor-produto-xl, .seletor-produto-sm").forEach(chk => {
            chk.addEventListener("change", () => {
                if (selecionarTodos) {
                    const allChecked = [...document.querySelectorAll(".seletor-produto-xl, .seletor-produto-sm")].every(c => c.checked);
                    selecionarTodos.checked = allChecked;
                }
                atualizarResumo();
            });
        });
    };

    inicializarSelecaoProdutos();
    atualizarResumo();
});
