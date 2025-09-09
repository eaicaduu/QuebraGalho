document.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-excluir-produto");
    if (!btn) return;

    e.stopPropagation();
    e.preventDefault();

    const id = btn.dataset.id;
    const nome = btn.dataset.nome;

    Swal.fire({
      title: "Excluir Produto",
      text: `Tem certeza que deseja excluir o produto "${nome}"?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc3545",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Sim, excluir",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`../../../app/models/produtos/painel/excluir_produto_painel.php?id=${id}`, {
          method: "GET",
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              Swal.fire(
                "Excluído!",
                "Produto excluído com sucesso.",
                "success"
              ).then(() => location.reload());
            } else {
              Swal.fire(
                "Erro",
                data.message || "Erro ao excluir o produto.",
                "error"
              );
            }
          })
          .catch(() => {
            Swal.fire("Erro", "Erro ao excluir o produto.", "error");
          });
      }
    });
  });
});
