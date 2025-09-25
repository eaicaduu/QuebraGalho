document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("categorias-body");
    if (!container) return;

    container.addEventListener("change", async (e) => {
        const checkbox = e.target.closest(".editable-status");
        if (!checkbox) return;

        const id = checkbox.dataset.id;
        const status = checkbox.checked ? 1 : 0;

        try {
            const response = await fetch("../../../app/models/produtos/categorias/atualizar_status_produtos_categorias.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${id}&status=${status}`
            });

            const resultado = await response.json();

            if (resultado.sucesso) {
                Swal.fire({
                    icon: "success",
                    title: "Atualizado!",
                    text: `A categoria foi ${status === 1 ? "ativada" : "desativada"} com sucesso.`,
                    timer: 3000,
                    confirmButtonColor: "#28a745"
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: "Não foi possível atualizar o status.",
                    confirmButtonText: "Ok"
                });
                checkbox.checked = !checkbox.checked;
            }
        } catch (error) {
            console.error("Erro:", error);
            Swal.fire({
                icon: "error",
                title: "Erro de conexão!",
                text: "Tente novamente mais tarde.",
                confirmButtonText: "Ok"
            });
            checkbox.checked = !checkbox.checked;
        }
    });
});
