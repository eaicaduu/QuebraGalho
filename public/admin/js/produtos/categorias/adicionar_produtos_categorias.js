document.addEventListener("DOMContentLoaded", () => {
    const btnAdd = document.getElementById("addproduct");
    const container = document.getElementById("categorias-body");

    if (!btnAdd || !container) return;

    btnAdd.addEventListener("click", async () => {
        const { value: nomeCategoria } = await Swal.fire({
            title: "Nova Categoria",
            input: "text",
            inputLabel: "Digite o nome da categoria",
            showCancelButton: true,
            confirmButtonText: "Adicionar",
            confirmButtonColor: "#28a745",
            cancelButtonText: "Cancelar",
            inputValidator: (value) => {
                if (!value || value.trim().length < 2) {
                    return "Digite pelo menos 2 caracteres!";
                }
            }
        });

        if (!nomeCategoria) return;

        try {
            const formData = new URLSearchParams();
            formData.append("nome", nomeCategoria.trim());

            const response = await fetch("../../../app/models/produtos/categorias/adicionar_produtos_categorias.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: formData.toString()
            });

            const resultado = await response.json();

            if (resultado.sucesso) {
                Swal.fire({
                    icon: "success",
                    title: "Categoria adicionada!",
                    text: `A categoria "${nomeCategoria}" foi adicionada com sucesso.`,
                    timer: 3000,
                    confirmButtonColor: "#28a745"
                }).then(() => {
                    if (typeof window.pesquisarCategorias === "function") {
                        window.pesquisarCategorias();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: resultado.mensagem || "Não foi possível adicionar a categoria.",
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
