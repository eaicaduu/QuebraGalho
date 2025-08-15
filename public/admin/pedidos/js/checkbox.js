document.addEventListener('DOMContentLoaded', () => {
    const plataformas = ['ecommerce', 'mercado_livre', 'shopee', 'amazon'];
    const storageKey = 'filtrosPedidosSelecionados';
    const url = new URL(window.location.href);
    const temFiltroNaURL = url.searchParams.has('plataforma[]');

    if (!temFiltroNaURL) {
        const salvo = localStorage.getItem('filtrosPedidosSelecionados');
        if (salvo) {
            try {
                const selecionados = JSON.parse(salvo);
                if (Array.isArray(selecionados) && selecionados.length > 0) {
                    const form = document.getElementById('filtroPlataformas');
                    selecionados.forEach(valor => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'plataforma[]';
                        input.value = valor;
                        form.appendChild(input);
                    });
                    form.submit();
                }
            } catch { }
        }
    }

    function salvarFiltros() {
        const selecionados = plataformas.filter(plataforma => {
            const checkbox = document.getElementById(plataforma);
            return checkbox && checkbox.checked;
        });
        localStorage.setItem(storageKey, JSON.stringify(selecionados));
    }

    function carregarFiltros() {
        const salvo = localStorage.getItem(storageKey);
        if (salvo) {
            try {
                const selecionados = JSON.parse(salvo);
                plataformas.forEach(plataforma => {
                    const checkbox = document.getElementById(plataforma);
                    if (checkbox) {
                        checkbox.checked = selecionados.includes(plataforma);
                    }
                });
            } catch {
            }
        }
    }

    function atualizarVisibilidade() {
        plataformas.forEach(plataforma => {
            const checkbox = document.getElementById(plataforma);
            const containerPedidos = document.getElementById(`pedidos_${plataforma}`);

            if (checkbox && containerPedidos) {
                containerPedidos.style.display = checkbox.checked ? 'block' : 'none';
            }


        });
    }

    function onChangeCheckbox() {
        atualizarVisibilidade();
        salvarFiltros();
    }

    carregarFiltros();
    atualizarVisibilidade();

    plataformas.forEach(plataforma => {
        const checkbox = document.getElementById(plataforma);
        if (checkbox) {
            checkbox.addEventListener('change', onChangeCheckbox);
        }
    });
});
