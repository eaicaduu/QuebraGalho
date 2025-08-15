document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-carrinho").forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      e.stopPropagation();
      const idProduto = btn.getAttribute("data-id");
      const quantidade = selectQuantidade.value;
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
      try {
        const [resposta] = await Promise.all([
          fetch("../app/models/carrinho/salvar_carrinho.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `produto_id=${encodeURIComponent(
              idProduto
            )}&quantidade=${encodeURIComponent(quantidade)}`,
          }),
          new Promise((resolve) => setTimeout(resolve, 500)),
        ]);

        const resultado = await resposta.json();

        if (resultado.sucesso) {
          const totalAtualizado = resultado.total || 0;

          let badge = document.getElementById("carrinho-contador");
          const iconDiv = document.querySelector(
            "#linkCarrinho .position-relative"
          );

          if (!badge && iconDiv) {
            badge = document.createElement("span");
            badge.id = "carrinho-contador";
            badge.className =
              "position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger";
            iconDiv.appendChild(badge);
          }

          if (badge) {
            badge.textContent = totalAtualizado;
            badge.style.display = totalAtualizado > 0 ? "inline-block" : "none";
          }

          const offcanvasEl = document.getElementById("offcanvasCarrinho");
          const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
          offcanvas.show();

          const confirmBox = document.getElementById("carrinho-adicionado");
          if (confirmBox) confirmBox.classList.remove("d-none");
        } else {
          Swal.fire(
            "Erro",
            resultado.mensagem || "Não foi possível adicionar ao carrinho.",
            "error"
          );
        }
      } catch (err) {
        console.error(err);
        Swal.fire("Erro", "Erro de conexão ao adicionar ao carrinho.", "error");
      }
    });
  });

  const btnEditarQuantidade = document.getElementById("btnEditarQuantidade");
  const quantidadeTexto = document.getElementById("quantidadeTexto");
  const selectQuantidade = document.getElementById("selectQuantidade");
  const icon = btnEditarQuantidade.querySelector("i");

  btnEditarQuantidade.addEventListener("click", () => {
    if (
      selectQuantidade.style.display === "none" ||
      selectQuantidade.style.display === ""
    ) {
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
    quantidadeTexto.innerHTML = `<strong>${valor} unidade${
      valor > 1 ? "s" : ""
    }</strong>`;
    selectQuantidade.style.display = "none";
    quantidadeTexto.style.display = "inline";
    icon.classList.remove("d-none");
  });
});
