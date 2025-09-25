document.querySelectorAll(".btn-quantidade-xl, .btn-quantidade-sm").forEach(btn => {
    const novoBtn = btn.cloneNode(true);
    btn.replaceWith(novoBtn);

    novoBtn.addEventListener("click", async () => {
        const carrinhoId = novoBtn.dataset.id;
        const action = novoBtn.dataset.action;

        const spansQtd = document.querySelectorAll(`#quantidade-${carrinhoId}`);

        try {
            const resposta = await fetch("../app/models/carrinho/quantidade_carrinho.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `carrinho_id=${carrinhoId}&action=${action}`
            });

            const dados = await resposta.json();

            if (dados.quantidade !== undefined) {
                spansQtd.forEach(span => {
                    span.classList.remove("quantidade-pop");
                    void span.offsetWidth;
                    span.textContent = dados.quantidade;
                    span.classList.add("quantidade-pop");
                });

                document.querySelectorAll(`.btn-quantidade[data-id="${carrinhoId}"][data-action="decrement"]`)
                    .forEach(btnMenos => {
                        btnMenos.disabled = dados.quantidade <= 1;
                        btnMenos.classList.toggle("btn-primary", dados.quantidade > 1);
                        btnMenos.classList.toggle("bg-secondary", dados.quantidade <= 1);
                    });

                document.querySelectorAll(`.btn-quantidade[data-id="${carrinhoId}"][data-action="increment"]`)
                    .forEach(btnMais => {
                        btnMais.disabled = dados.quantidade >= dados.max;
                        btnMais.classList.toggle("btn-primary", dados.quantidade < dados.max);
                        btnMais.classList.toggle("bg-secondary", dados.quantidade >= dados.max);
                    });

                document.querySelectorAll(`.item-carrinho-md[data-preco-unit][data-subtotal],
                                                  .item-carrinho-sm[data-preco-unit][data-subtotal]`)
                    .forEach(itemDiv => {
                        if (itemDiv.querySelector(`#quantidade-${carrinhoId}`)) {
                            const subtotalEl = itemDiv.querySelector(".subtotal");

                            if (subtotalEl) {
                                const precoOriginal = parseFloat(itemDiv.dataset.precoUnit);

                                const precoParaCalculo =
                                    itemDiv.dataset.promocao == "1" && itemDiv.dataset.precoPromocional
                                        ? parseFloat(itemDiv.dataset.precoPromocional)
                                        : precoOriginal;

                                itemDiv.dataset.subtotal = precoParaCalculo * dados.quantidade;
                            }

                            const maxQtd = parseInt(itemDiv.dataset.maxQtd);
                            const disponiveis = Math.max(0, maxQtd - dados.quantidade);
                            const disponivelEl = itemDiv.querySelectorAll(".quantidade-sm, .quantidade-xl");
                            if (disponivelEl) {
                                disponivelEl.textContent = `Mais ${disponiveis} disponíveis`;
                            }
                        }
                    });

                atualizarResumo();
            }
        } catch (e) {
            console.error("Erro:", e);
        }
    });
}); 