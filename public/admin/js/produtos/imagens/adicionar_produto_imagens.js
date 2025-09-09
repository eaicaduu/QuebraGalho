document.getElementById("produtos-body").addEventListener("change", async (e) => {
    const input = e.target.closest(".upload-midia");
    if (!input) return;

    const produtoId = input.closest(".produto-item").dataset.produtoId;
    const files = input.files;
    if (!files.length) return;

    const formData = new FormData();
    formData.append("produto_id", produtoId);
    for (let i = 0; i < files.length; i++) formData.append("midias[]", files[i]);

    const res = await fetch("../../../app/models/produtos/imagens/adicionar_produto_imagens.php", {
        method: "POST",
        body: formData
    });
    const data = await res.json();
    if (data.success) {
        const container = document.querySelector("#midias-produto-" + produtoId);
        data.midias.forEach(midia => {
            const wrapper = document.createElement("div");
            wrapper.classList.add("position-relative", "flex-shrink-0");
            wrapper.style.width = "120px";
            wrapper.style.height = "120px";
            wrapper.style.opacity = "0";
            wrapper.style.transform = "scale(0.8) translateY(-20px)";

            let element = document.createElement(midia.tipo === "video" ? "video" : "img");
            element.src = midia.url;
            if (midia.tipo === "video") element.controls = true;
            element.classList.add("w-100", "h-100", "object-fit-cover", "rounded");
            wrapper.appendChild(element);

            const btnRemover = document.createElement("button");
            btnRemover.className = "btn btn-danger btn-sm position-absolute top-0 end-0 m-1 btn-remover-midia";
            btnRemover.dataset.id = midia.id;
            btnRemover.dataset.produto = produtoId;
            btnRemover.innerHTML = '<i class="bi bi-trash"></i>';
            wrapper.appendChild(btnRemover);

            const addButton = container.querySelector("div.position-relative:last-child");
            container.insertBefore(wrapper, addButton);

            wrapper.offsetHeight;
            wrapper.style.transition = "opacity 0.5s ease, transform 0.5s ease";
            wrapper.style.opacity = "1";
            wrapper.style.transform = "scale(1) translateY(0)";
        });
        const totalMidias = container.querySelectorAll("div.position-relative").length;
        let mensagem = "";
        if (data.midia === "video") {
            mensagem = "Vídeo adicionado!";
        } else {
            mensagem = "Imagem adicionada!";
        }

        let mensagemLimite = "";
        if (totalMidias == 6) {
            mensagemLimite = "Você atingiu o limite de 5 imagens ou vídeos.";
        }

        Swal.fire({
            title: "Sucesso!",
            html: mensagem + (mensagemLimite ? "<br><small>" + mensagemLimite + "</small>" : ""),
            icon: "success",
            confirmButtonColor: "#28a745"
        }).then(() => {
            if (totalMidias >= 6) {
                location.reload();
            }
        });
    } else {
        Swal.fire({ icon: 'error', title: 'Erro', text: data.message || 'Erro ao enviar mídia' });
    }
});
