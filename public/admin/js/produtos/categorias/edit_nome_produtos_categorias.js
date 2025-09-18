document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("categorias-body");
    if (!container) return;

    container.addEventListener("input", (e) => {
        const input = e.target.closest(".editable-nome");
        if (!input) return;

        const btnSalvar = container.querySelector(`.btn-salvar-nome[data-id='${input.dataset.id}']`);
        if (btnSalvar) btnSalvar.classList.remove("d-none");
    });

    container.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-salvar-nome");
        if (!btn) return;

        const id = btn.dataset.id;
        const input = container.querySelector(`.editable-nome[data-id='${id}']`);
        const nome = input.value.trim();

        if (!nome) {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: "O nome da categoria não pode ficar vazio.",
                confirmButtonText: "Ok"
            });
            return;
        }

        try {
            const response = await fetch("../../../app/models/produtos/categorias/edit_nome_produtos_categorias.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${id}&nome=${encodeURIComponent(nome)}`
            });

            const resultado = await response.json();

            if (resultado.sucesso) {
                Swal.fire({
                    icon: "success",
                    title: "Atualizado!",
                    text: "O nome da categoria foi atualizado com sucesso.",
                    timer: 2000,
                    confirmButtonColor: "#28a745"
                });

                btn.classList.add("d-none");
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: "Não foi possível atualizar o nome.",
                    confirmButtonText: "Ok"
                });
            }
        } catch (error) {
            console.error("Erro:", error);
            Swal.fire({
                icon: "error",
                title: "Erro de conexão!",
                text: "Tente novamente mais tarde.",
                confirmButtonText: "Ok"
            });
        }
    });
});
