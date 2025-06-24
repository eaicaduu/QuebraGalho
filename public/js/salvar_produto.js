document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-favorito").forEach(btn => {
    const productId = btn.getAttribute("data-id");
    const icon = btn.querySelector("i");

    if (!isLoggedIn && localStorage.getItem(`favorito_${productId}`)) {
      icon.classList.add("text-danger");
    }

    btn.addEventListener("click", () => {
      icon.classList.add("heart-animate");

      setTimeout(() => {
        icon.classList.remove("heart-animate");
      }, 300);

      if (isLoggedIn) {
        const formData = new FormData();
        formData.append("produto_id", productId);

        fetch("../app/models/favoritos/salvar_favorito.php", {
          method: "POST",
          body: formData,
        })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              icon.classList.toggle("text-danger");
            } else {
              alert(data.message || "Erro ao salvar nos favoritos.");
            }
          });
      } else {
        if (localStorage.getItem(`favorito_${productId}`)) {
          localStorage.removeItem(`favorito_${productId}`);
          icon.classList.remove("text-danger");
        } else {
          localStorage.setItem(`favorito_${productId}`, "true");
          icon.classList.add("text-danger");
        }
      }
    });
  });
});
