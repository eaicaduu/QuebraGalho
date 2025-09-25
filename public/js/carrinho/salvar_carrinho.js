document.addEventListener("DOMContentLoaded", () => {
  const selectQuantidade = document.getElementById("selectQuantidade");
  const btnEditarQuantidade = document.getElementById("btnEditarQuantidade");
  const quantidadeTexto = document.getElementById("quantidadeTexto");
  const icon = btnEditarQuantidade.querySelector("i");

  async function adicionarAoCarrinho(idProduto, quantidade = 1, precoUnitario = 0) {
    try {
      const resposta = await fetch("../app/models/carrinho/salvar_carrinho.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `produto_id=${encodeURIComponent(idProduto)}&quantidade=${encodeURIComponent(quantidade)}&preco_unitario=${encodeURIComponent(precoUnitario)}`
      });

      const resultado = await resposta.json();

      function atualizarBadge(numero) {
        const badges = [document.getElementById("badgeCarrinho"), document.getElementById("badgeCarrinhoXL")];

        badges.forEach(badge => {
          if (!badge) return;
          badge.textContent = numero;
          badge.classList.remove("badge-animate");
          void badge.offsetWidth;
          badge.classList.add("badge-animate");
        });
      }

      if (resultado.sucesso) {
        atualizarBadge(resultado.total);
        Swal.fire({
          title: resultado.mensagem,
          html: `
          <div class="d-flex align-items-center" style="gap: 10px;">
            <div class="position-relative">
            <img src="${resultado.produto.imagem}" alt="${resultado.produto.nome}" 
                 style="width:50px; height:50px; object-fit:cover; border-radius:50%; border: 3px solid #28a745;">
        </div>
        <div style="flex:1; overflow:hidden;">
            <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                ${resultado.produto.nome}
            </div>
            <small>
              Cód: ${resultado.produto.cod_sku} -
              ${resultado.produto.quantidade} 
              ${resultado.produto.quantidade > 1 ? 'Unidades' : 'Unidade'}
            </small>
            </div>
          </div>
          `,
          showCancelButton: true,
          confirmButtonText: 'Finalizar Compra',
          cancelButtonText: 'Continuar Comprando',
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#0d6efd',
          icon: 'success',
          customClass: { popup: 'p-3' }
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = 'carrinho.php';
          }
        });

      } else {
        console.error("Erro:", resultado.mensagem);
      }
    } catch (err) {
      console.error("Erro na requisição:", err);
    }
  }

  document.querySelectorAll(".btn-carrinho").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.stopPropagation();

      if (!isLoggedIn) {
        Swal.fire({
          icon: "warning",
          title: "Faça login",
          text: "Você precisa estar logado para adicionar ao carrinho.",
          confirmButtonText: "Fazer login",
          confirmButtonColor: "#28a745",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "login.php";
          }
        });
        return;
      }
      const idProduto = btn.getAttribute("data-id");
      const quantidade = selectQuantidade ? selectQuantidade.value : 1;
      const precoUnitario = btn.getAttribute("data-preco");

      adicionarAoCarrinho(idProduto, quantidade, precoUnitario);
    });
  });

  btnEditarQuantidade.addEventListener("click", () => {
    if (!selectQuantidade || !quantidadeTexto) return;

    if (selectQuantidade.style.display === "none" || selectQuantidade.style.display === "") {
      selectQuantidade.style.display = "inline-block";
      quantidadeTexto.style.display = "none";
      icon.classList.add("d-none");
    } else {
      selectQuantidade.style.display = "none";
      quantidadeTexto.style.display = "inline";
      icon.classList.remove("d-none");
    }
  });

  selectQuantidade.addEventListener("change", () => {
    const valor = selectQuantidade.value;
    quantidadeTexto.innerHTML = `<strong>${valor} unidade${valor > 1 ? "s" : ""}</strong>`;
    selectQuantidade.style.display = "none";
    quantidadeTexto.style.display = "inline";
    icon.classList.remove("d-none");
  });
});
