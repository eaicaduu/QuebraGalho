document.addEventListener("DOMContentLoaded", () => {
    const tabelaBody = document.getElementById("produtos-body");

    function formatarNumeroBR(valor) {
        if (isNaN(valor) || valor == null) valor = 0;
        let partes = parseFloat(valor).toFixed(2).split(".");
        partes[0] = partes[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1");
        return "R$" + partes.join(",");
    }

    function formatarPrecoBR(input) {
        if (!input) return 0;
        let valor = input.value.replace(/[^\d]/g, "");
        if (!valor) {
            input.value = "";
            return 0;
        }
        valor = (parseInt(valor, 10) / 100).toFixed(2);
        let partes = valor.split(".");
        partes[0] = partes[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1");
        input.value = "R$" + partes.join(",");
        return parseFloat(valor);
    }

    function calcularPercentual(card) {
        const precoInput = card.querySelector(".preco-produto");
        const precoPromoInput = card.querySelector(".preco-promocional");
        const descontoPercentualInput = card.querySelector(".desconto-percentual");
        if (!precoInput || !precoPromoInput || !descontoPercentualInput) return;

        let precoOriginal = parseFloat(precoInput.value.replace(/\D/g, "")) / 100 || 0;
        let precoPromo = parseFloat(precoPromoInput.value.replace(/\D/g, "")) / 100 || 0;

        if (precoOriginal > 0) {
            let desconto = ((precoOriginal - precoPromo) / precoOriginal) * 100;
            desconto = Math.max(0, Math.min(100, desconto));
            descontoPercentualInput.value = desconto.toFixed(2);
        }
    }

    function calcularPrecoPromocional(card, atualizarInput = true) {
        const precoInput = card.querySelector(".preco-produto");
        const descontoPercentualInput = card.querySelector(".desconto-percentual");
        if (!precoInput || !descontoPercentualInput) return;

        let precoOriginal = parseFloat(precoInput.value.replace(/\D/g, "")) / 100 || 0;
        let desconto = parseFloat(descontoPercentualInput.value.replace(",", ".")) || 0;
        desconto = Math.max(0, Math.min(100, desconto));

        if (atualizarInput) descontoPercentualInput.value = desconto.toFixed(2);

        let precoPromoInput = card.querySelector(".preco-promocional");
        if (!precoPromoInput) {
            precoPromoInput = document.createElement("input");
            precoPromoInput.type = "text";
            precoPromoInput.className = "form-control form-control-sm ms-2 w-25 preco-promocional";
            precoPromoInput.placeholder = "Preço promo";
            precoInput.insertAdjacentElement("afterend", precoPromoInput);
        }

        let precoPromo = precoOriginal * (1 - desconto / 100);
        precoPromoInput.value = formatarNumeroBR(precoPromo);

    }

    tabelaBody.addEventListener("input", (e) => {
        const card = e.target.closest(".produto-item");
        if (!card) return;

        if (e.target.classList.contains("preco-produto") || e.target.classList.contains("preco-promocional")) {
            formatarPrecoBR(e.target);
        }

        if (e.target.classList.contains("preco-promocional")) {
            calcularPercentual(card);
        }

        if (e.target.classList.contains("desconto-percentual")) {
            calcularPrecoPromocional(card, false);
        }
    });
});
