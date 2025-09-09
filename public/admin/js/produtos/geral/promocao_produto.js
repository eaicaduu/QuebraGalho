document.addEventListener("DOMContentLoaded", () => {
    const tabelaBody = document.getElementById("produtos-body");

    tabelaBody.querySelectorAll(".produto-item").forEach(card => {
        const checkbox = card.querySelector(".promocao-produto");
        const promoPercentual = card.querySelector(".desconto-percentual");
        const precoPromo = card.querySelector(".preco-promocional");

        if (checkbox && checkbox.checked) {
            if (promoPercentual) promoPercentual.style.display = "block";
            if (precoPromo) precoPromo.style.display = "block";
        } else {
            if (promoPercentual) promoPercentual.style.display = "none";
            if (precoPromo) precoPromo.style.display = "none";
        }
    });

    tabelaBody.addEventListener("change", (e) => {
        if (!e.target.classList.contains("promocao-produto")) return;

        const card = e.target.closest(".produto-item");
        const promoPercentual = card.querySelector(".desconto-percentual");
        const precoPromo = card.querySelector(".preco-promocional");

        if (e.target.checked) {
            if (promoPercentual) promoPercentual.style.display = "block";
            if (precoPromo) precoPromo.style.display = "block";
        } else {
            if (promoPercentual) promoPercentual.style.display = "none";
            if (precoPromo) precoPromo.style.display = "none";
        }
    });
});
