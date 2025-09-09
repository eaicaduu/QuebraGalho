document.addEventListener("DOMContentLoaded", () => {

    document.body.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-remover-midia");
        if (!btn) return;

        const midiaId = btn.dataset.id;

        if (!midiaId) return;

        try {
            const formData = new FormData();
            formData.append("midia_id", midiaId);

            const res = await fetch("../../../app/models/produtos/imagens/excluir_produto_imagens.php", {
                method: "POST",
                body: formData
            });

            const data = await res.json();

            if (data.success) {
                const wrapper = btn.closest("div.position-relative");
                if (wrapper) {
                    wrapper.style.transition = "all 0.5s ease";
                    wrapper.style.opacity = "0";
                    wrapper.style.transform = "scale(0) translateY(-20px)";

                    setTimeout(() => {
                        wrapper.remove();
                    }, 500);
                }

                Swal.fire({
                    title: "Sucesso!",
                    text: data.tipo === "video" ? "Vídeo removido!" : "Imagem removida!",
                    icon: "success",
                    confirmButtonColor: "#28a745"
                }).then(() => {
                    const container = document.querySelector("#midias-produto-" + btn.dataset.produto);
                    const totalMidias = container ? container.querySelectorAll("div.position-relative").length : 0;
                    if (totalMidias > 4) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: data.message || 'Não foi possível remover a mídia'
                });
            }

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro na requisição AJAX'
            });
        }
    });
});
