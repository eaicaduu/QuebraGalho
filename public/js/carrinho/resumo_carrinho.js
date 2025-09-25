window.atualizarResumo = function () {
    let total = 0;
    let totalItens = 0;

    const processados = new Set();

    document.querySelectorAll(".item-carrinho-md, .item-carrinho-sm").forEach(item => {
        const checkbox = item.querySelector(".seletor-produto-md, .seletor-produto-sm");
        const spanQtd = item.querySelector(".quantidade-produto-md, .quantidade-produto-sm");

        const carrinhoId = item.querySelector("[data-id]")?.dataset.id;

        if (carrinhoId && !processados.has(carrinhoId)) {
            if (checkbox && checkbox.checked && spanQtd) {
                const qtd = parseInt(spanQtd.textContent);

                const subtotalItem = parseFloat(item.dataset.subtotal);

                total += subtotalItem;
                totalItens += qtd;
            }
            processados.add(carrinhoId);
        }
    });

    const totalFinal = document.getElementById("totalFinal-md");
    if (totalFinal) {
        totalFinal.textContent = total.toFixed(2).replace(".", ",");
    }

    const itensSpan = document.getElementById("totalItens-md");
    if (itensSpan) {
        itensSpan.textContent = totalItens;
    }

    const itensSpanSm = document.getElementById("totalItens-sm");
    if (itensSpanSm) {
        itensSpanSm.textContent = totalItens;
    }
};
