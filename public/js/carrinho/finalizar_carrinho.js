document.querySelectorAll(`.btnfinalizarcarrinho-sm, .btnfinalizarcarrinho-xl`).addEventListener("click", () => {
    const carrinho = [];
    alert("teste");
    document.querySelectorAll(".item-carrinho").forEach(item => {
        const id = item.dataset.id;
        const nome = item.querySelector("span:first-child").textContent;
        const quantidade = parseInt(item.querySelector(`#quantidade-${id}`).textContent);
        const valor_unitario = parseFloat(item.dataset.precoUnit);
        const subtotal = parseFloat(item.dataset.subtotal);

        carrinho.push({ id, nome, quantidade, valor_unitario, subtotal });
    });

    fetch("../app/models/carrinho/finalizar_carrinho.php.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ carrinho })
    }).then(() => {
        window.location.href = "frete.php";
    });
});