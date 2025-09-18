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
  });
});