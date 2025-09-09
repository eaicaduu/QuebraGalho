document.addEventListener("DOMContentLoaded", () => {
    const tabelaBody = document.getElementById("produtos-body");

    function getVisibleInput(card, selector) {
        const inputs = card.querySelectorAll(selector);
        for (let input of inputs) {
            if (input.offsetParent !== null) return input;
        }
        return null;
    }

    function checarMudancas(card) {
        const salvarBtn = card.querySelector(".salvar-produto");
        if (!salvarBtn) return;

        const nomeAtual = getVisibleInput(card, ".nome-produto")?.value || "";
        const descAtual = getVisibleInput(card, ".desc_curta")?.value || "";
        const precoAtual = getVisibleInput(card, ".preco-produto")?.value || "";
        const statusAtual = getVisibleInput(card, ".status-produto")?.value || "";
        const promocaoInput = getVisibleInput(card, ".promocao-produto");
        const promocaoAtual = promocaoInput ? promocaoInput.checked : false;
        const destaqueInput = getVisibleInput(card, ".destaque-produto");
        const destaqueAtual = destaqueInput ? destaqueInput.checked : false;
        const descontoPercentualInput = getVisibleInput(card, ".desconto-percentual");
        const descontoPercentualAtual = descontoPercentualInput ? descontoPercentualInput.value : "";
        const precoPromoInput = getVisibleInput(card, ".preco-promocional");
        const precoPromoAtual = precoPromoInput ? precoPromoInput.value : "";

        const nomeOrig = getVisibleInput(card, ".nome-produto")?.getAttribute("value") || "";
        const descOrig = getVisibleInput(card, ".desc_curta")?.getAttribute("value") || "";
        const precoOrig = getVisibleInput(card, ".preco-produto")?.getAttribute("value") || "";
        const promocaoOrig = promocaoInput ? promocaoInput.defaultChecked : false;
        const destaqueOrig = destaqueInput ? destaqueInput.defaultChecked : false;
        const statusSelect = getVisibleInput(card, ".status-produto");
        const statusOrig = statusSelect?.querySelector("option[selected]")?.value || "";
        const descontoPercentualOrig = descontoPercentualInput ? descontoPercentualInput.defaultValue : "";
        const precoPromoOrig = precoPromoInput ? precoPromoInput.defaultValue : "";

        const mudou = (
            nomeAtual !== nomeOrig ||
            descAtual !== descOrig ||
            precoAtual !== precoOrig ||
            promocaoAtual !== promocaoOrig ||
            destaqueAtual !== destaqueOrig ||
            descontoPercentualAtual !== descontoPercentualOrig ||
            precoPromoAtual !== precoPromoOrig ||
            statusAtual !== statusOrig
        );

        if (mudou) {
            salvarBtn.disabled = false;
            salvarBtn.classList.remove("btn-secondary");
            salvarBtn.classList.add("btn-success");
        } else {
            salvarBtn.disabled = true;
            salvarBtn.classList.remove("btn-success");
            salvarBtn.classList.add("btn-secondary");
        }
    }

    tabelaBody.addEventListener("input", (e) => {
        const card = e.target.closest(".produto-item");
        if (!card) return;
        checarMudancas(card);
    });

    tabelaBody.addEventListener("change", (e) => {
        const card = e.target.closest(".produto-item");
        if (!card) return;
        checarMudancas(card);
    });

});
