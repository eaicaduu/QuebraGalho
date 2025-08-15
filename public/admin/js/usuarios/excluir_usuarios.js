document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".btn-excluir-usuario").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const nome = btn.dataset.nome;

            Swal.fire({
                title: `Excluir ${nome}?`,
                text: "Esta ação não poderá ser desfeita.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("../../app/models/usuarios/excluir_usuario.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id }),
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire(
                                    "Excluído",
                                    "Usuário removido com sucesso.",
                                    "success"
                                ).then(() => location.reload());
                            } else {
                                Swal.fire("Erro", data.message || "Erro ao excluir", "error");
                            }
                        });
                }
            });
        });
    });
});