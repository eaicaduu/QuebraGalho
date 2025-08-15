document.addEventListener("DOMContentLoaded", () => {
  const favoritosLista = document.getElementById("favoritos-lista");
  const offcanvasElement = document.getElementById("offcanvasFavoritos");

  async function atualizarContadorFavoritos() {
    let total = 0;

    if (typeof isLoggedIn !== "undefined" && isLoggedIn) {
      try {
        const response = await fetch("../app/models/favoritos/contar_favoritos.php", {
          method: "GET",
          credentials: "include"
        });
        const data = await response.json();
        total = data.total || 0;
      } catch (error) {
        console.error("Erro ao contar favoritos:", error);
      }
    } else {
      total = contarFavoritosLocal();
    }

    const favoritosIcon = document.querySelector('[data-bs-target="#offcanvasFavoritos"] .position-relative');
    const spanExistente = document.getElementById("favoritos-contador");

    if (total > 0) {
      if (!spanExistente && favoritosIcon) {
        const badge = document.createElement("span");
        badge.id = "favoritos-contador";
        badge.className = "position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger";
        badge.textContent = total;
        favoritosIcon.appendChild(badge);
      } else if (spanExistente) {
        spanExistente.textContent = total;
        spanExistente.style.display = "inline";
      }
    } else if (spanExistente) {
      spanExistente.remove();
    }
  }

  function contarFavoritosLocal() {
    let count = 0;
    for (let i = 0; i < localStorage.length; i++) {
      if (localStorage.key(i).startsWith("favorito_")) {
        count++;
      }
    }
    return count;
  }

  offcanvasElement.addEventListener("show.bs.offcanvas", () => {
    favoritosLista.innerHTML = `<p class="text-muted">Carregando favoritos...</p>`;

    if (isLoggedIn) {
      fetch("../app/models/favoritos/buscar_favoritos.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ logado: true }),
      })
        .then((res) => res.json())
        .then((data) => renderizarFavoritos(data.produtos || []))
        .catch(() => {
          favoritosLista.innerHTML = `<p class="text-danger">Erro ao carregar os favoritos.</p>`;
        });
    } else {
      const favoritos = [];
      for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith("favorito_")) {
          favoritos.push(key.replace("favorito_", ""));
        }
      }

      if (favoritos.length === 0) {
        favoritosLista.innerHTML = `<p class="text-muted">Nenhum item salvo ainda.</p>`;
        return;
      }

      fetch("../app/models/favoritos/obter_favoritos.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ids: favoritos }),
      })
        .then((res) => res.json())
        .then((data) => renderizarFavoritos(data.produtos || []))
        .catch(() => {
          favoritosLista.innerHTML = `<p class="text-danger">Erro ao carregar os favoritos.</p>`;
        });
    }
  });

  function renderizarFavoritos(produtos) {
    if (!produtos.length) {
      favoritosLista.innerHTML = `<p class="text-muted">Nenhum item salvo ainda.</p>`;
      return;
    }

    favoritosLista.innerHTML = "";
    produtos.forEach((produto) => {
      favoritosLista.innerHTML += `
        <div class="card mb-3 position-relative card-favorito" data-id="${produto.id}" style="cursor: pointer; opacity: 1; transition: opacity 0.3s ease;">
          <div class="row g-0">
            <div class="col-4">
              <img src="../app/models/${produto.imagem || "../../public/images/default.png"}"
                class="img-fluid rounded-start pe-none" alt="${produto.nome}">
            </div>
            <div class="col-8">
              <div class="card-body">
                <h6 class="card-title mb-1" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                  ${produto.nome}
                </h6>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="text-muted small">Marca: ${produto.fornecedor}</span>
                  <span class="text-muted small">Código: ${produto.id}</span>
                </div>
                <span class="fw-bold text-dark">R$ ${parseFloat(produto.preco).toFixed(2).replace(".", ",")}</span>
              </div>
            </div>
          </div>
          <button class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-2 btn-remover-favorito"
            data-id="${produto.id}" title="Remover dos favoritos">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      `;
    });

    document.querySelectorAll(".card-favorito").forEach((card) => {
      card.addEventListener("click", (e) => {
        if (e.target.closest(".btn-remover-favorito")) return;

        const id = card.getAttribute("data-id");
        if (id) {
          window.location.href = `produto.php?id=${id}`;
        }
      });
    });

    document.querySelectorAll(".btn-remover-favorito").forEach((btn) => {
      btn.addEventListener("click", async (e) => {
        e.stopPropagation();
        const id = btn.getAttribute("data-id");
        localStorage.removeItem(`favorito_${id}`);

        if (isLoggedIn) {
          const formData = new FormData();
          formData.append("produto_id", id);

          await fetch("../app/models/favoritos/remover_favoritos.php", {
            method: "POST",
            body: formData,
            credentials: "include",
          });
        }

        await atualizarContadorFavoritos();

        const btnFavorito = document.querySelector(`.btn-favorito[data-id="${id}"] i`);
        if (btnFavorito) btnFavorito.classList.remove("text-danger");

        const card = btn.closest(".card");
        card.classList.add("opacity-0");

        setTimeout(() => {
          card.remove();
          if (document.querySelectorAll("#favoritos-lista .card").length === 0) {
            favoritosLista.innerHTML = `<p class="text-muted">Nenhum item salvo ainda.</p>`;
          }
        }, 300);
      });
    });
  }

  atualizarContadorFavoritos();
  window.atualizarContadorFavoritos = atualizarContadorFavoritos;
});
