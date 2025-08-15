document.addEventListener("DOMContentLoaded", () => {
  const linksCarrinho = document.querySelectorAll(".js-link-carrinho");

  linksCarrinho.forEach(link => {

    link.addEventListener("click", (event) => {
      if (typeof isLoggedIn !== "undefined" && isLoggedIn) {
        window.location.href = "carrinho.php";
      } else {
        event.preventDefault(); 
        
        Swal.fire({
          icon: "warning",
          title: "Ops!",
          text: "Acesse sua conta para ver ou editar os produtos do seu carrinho.",
          confirmButtonText: "Entrar",
          confirmButtonColor: "#28a745",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
        }).then((result) => {
          if (result.isConfirmed) {
            sessionStorage.setItem("paginaAnterior", window.location.href);
            window.location.href = "login.php";
          }
        });
      }
    });

    if (typeof totalCarrinho !== "undefined" && totalCarrinho > 0) {
      const iconDiv = link.querySelector(".position-relative");

      if (iconDiv && !iconDiv.querySelector(".carrinho-contador-badge")) {
        const badge = document.createElement("span");
        
        badge.className = "carrinho-contador-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger";
        badge.textContent = totalCarrinho;
        
        iconDiv.appendChild(badge);
      }
    }
  });
});