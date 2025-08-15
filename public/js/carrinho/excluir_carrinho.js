document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-remover-carrinho").forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      e.preventDefault();
      const id = btn.getAttribute("data-id");

      Swal.fire({
        title: "Remover item?",
        text: "Você tem certeza que deseja remover este produto do carrinho?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sim, remover",
        cancelButtonText: "Cancelar",
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            const formData = new FormData();
            formData.append("produto_id", id);

            const response = await fetch(
              "../app/models/carrinho/remover_carrinho.php",
              {
                method: "POST",
                body: formData,
                credentials: "include",
              }
            );

            const data = await response.json();

            if (data.success) {
              Swal.fire(
                "Removido!",
                "Produto removido do carrinho.",
                "success"
              ).then(() => {
                location.reload();
              });
            } else {
              Swal.fire(
                "Erro",
                data.mensagem || "Erro ao remover o produto.",
                "error"
              );
            }
          } catch (err) {
            Swal.fire("Erro", "Erro de conexão com o servidor.", "error");
          }
        }
      });
    });
  });
});
