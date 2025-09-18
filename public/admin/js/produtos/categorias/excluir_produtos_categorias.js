document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("categorias-body");

    if (!container) return;

    container.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-excluir-categoria");
        if (!btn) return;

        const id = btn.dataset.id;
        const nome = btn.dataset.nome;

        const confirm = await Swal.fire({
            icon: "warning",
            title: `Excluir "${nome}"?`,
            text: "Essa ação não pode ser desfeita!",
            showCancelButton: true,
            confirmButtonText: "Sim, excluir",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#dc3545"
        });

        if (!confirm.isConfirmed) return;

        try {
            const formData = new URLSearchParams();
            formData.append("id", id);

            const response = await fetch("../../../app/models/produtos/categorias/excluir_produtos_categorias.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: formData.toString()
            });

            const resultado = await response.json();

            if (resultado.sucesso) {
                Swal.fire({
                    icon: "success",
                    title: "Categoria excluída!",
                    timer: 3000,
                    confirmButtonColor: "#28a745"
                });

                if (window.pesquisarCategorias) {
                    window.pesquisarCategorias();
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: resultado.mensagem || "Não foi possível excluir a categoria.",
                    confirmButtonText: "Ok"
                });
            }

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: "error",
                title: "Erro de conexão!",
                text: "Tente novamente mais tarde.",
                confirmButtonText: "Ok"
            });
        }
    });
});
