document.addEventListener("DOMContentLoaded", () => {
  function atualizarContadorFavoritos() {
    let contador = 0;
    for (let i = 0; i < localStorage.length; i++) {
      if (localStorage.key(i).startsWith("favorito_")) {
        contador++;
      }
    }

    const badge = document.getElementById("favoritos-contador");
    if (badge) {
      if (contador > 0) {
        badge.textContent = contador;
        badge.style.display = "inline";
      } else {
        badge.style.display = "none";
      }
    }
  }

  document.querySelectorAll(".btn-favorito").forEach((btn) => {
    const productId = btn.getAttribute("data-id");
    const icon = btn.querySelector("i");

    if (localStorage.getItem(`favorito_${productId}`)) {
      icon.classList.add("text-danger");
    }

    btn.addEventListener("click", () => {
      icon.classList.add("heart-animate");

      setTimeout(() => {
        icon.classList.remove("heart-animate");
      }, 300);

      const key = `favorito_${productId}`;
      const estaSalvoLocal = !!localStorage.getItem(key);

      if (isLoggedIn) {
        const formData = new FormData();
        formData.append("produto_id", productId);

        if (estaSalvoLocal) {
          formData.append("remover", "true");
        }

        fetch("../app/models/favoritos/salvar_favoritos.php", {
          method: "POST",
          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success || data.message === "Usuário não autenticado.") {
              toggleLocalFavorito(productId, icon);
            } else {
              alert(data.message || "Erro ao salvar nos favoritos.");
            }
          })
          .catch(() => {
            alert("Erro de comunicação com o servidor.");
          });
      } else {
        toggleLocalFavorito(productId, icon);
      }
    });
  });

  function toggleLocalFavorito(productId, icon) {
    const key = `favorito_${productId}`;
    if (localStorage.getItem(key)) {
      localStorage.removeItem(key);
      icon.classList.remove("text-danger");
    } else {
      localStorage.setItem(key, "true");
      icon.classList.add("text-danger");
    }
    atualizarContadorFavoritos();
  }
});
