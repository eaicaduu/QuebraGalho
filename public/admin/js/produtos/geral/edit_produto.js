document.addEventListener("DOMContentLoaded", () => {

    function getVisibleInput(card, selector) {
        const inputs = card.querySelectorAll(selector);
        for (let input of inputs) {
            if (input.offsetParent !== null) return input;
        }
        return null;
    }

    document.getElementById("produtos-body").addEventListener("click", async (e) => {
        const btn = e.target.closest(".salvar-produto");
        if (!btn) return;

        const card = btn.closest(".produto-item");

        const produtoId = card.dataset.produtoId;
        const nomeInput = getVisibleInput(card, ".nome-produto");
        const descInput = getVisibleInput(card, ".desc_curta");
        const precoInput = getVisibleInput(card, ".preco-produto");
        const promoCheckbox = getVisibleInput(card, ".promocao-produto");
        const destaqueCheckbox = getVisibleInput(card, ".destaque-produto");
        const statusInput = getVisibleInput(card, ".status-produto");
        const descontoPercentualInput = getVisibleInput(card, ".desconto-percentual");
        const precoPromoInput = getVisibleInput(card, ".preco-promocional");

        let preco = precoInput?.value || "";

        preco = preco.replace(/\s/g, "")
            .replace("R$", "")
            .replace(/\./g, "")
            .replace(",", ".");

        preco = parseFloat(preco).toFixed(2);

        const descontoPercentual = descontoPercentualInput ? descontoPercentualInput.value.replace(",", ".") : 0;
        const precoPromocional = precoPromoInput ? precoPromoInput.value.replace("R$", "").replace(/\./g, "").replace(",", ".") : 0;

        const nome = nomeInput?.value;
        const desc_curta = descInput?.value;
        const status = statusInput?.value;
        const promocao = promoCheckbox.checked ? 1 : 0;
        const destaque = destaqueCheckbox.checked ? 1 : 0;

        console.log(descontoPercentual);
        try {
            const formData = new FormData();
            formData.append("id", produtoId);
            formData.append("nome", nome);
            formData.append("desc_curta", desc_curta);
            formData.append("preco", preco);
            formData.append("status", status);
            formData.append("promocao", promocao);
            formData.append("destaque", destaque);
            formData.append("desconto_percentual", descontoPercentual);
            formData.append("preco_promocional", precoPromocional);

            const res = await fetch("../../../app/models/produtos/geral/edit_produto.php", {
                method: "POST",
                body: formData
            });

            const data = await res.json();
            if (data.success) {
                Swal.fire({
                    title: "Salvo!",
                    text: "A alteração foi salva.",
                    icon: "success",
                    confirmButtonColor: "#28a745"
                }).then(() => {
                    btn.disabled = true;
                    btn.classList.remove("btn-success");
                    btn.classList.add("btn-secondary");
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: data.error || 'Erro ao atualizar produto.',
                });
            }
        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro na requisição.',
            });
        }
    });

    document.getElementById("produtos-body").addEventListener("click", async (e) => {
        const btn = e.target.closest(".alterar-imagem");
        if (!btn) return;

        const card = btn.closest(".produto-item");
        const produtoId = card.dataset.produtoId;

        Swal.fire({
            title: 'Alterar imagem',
            text: 'Escolha a origem da nova imagem:',
            icon: 'question',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Imagem da Galeria',
            denyButtonText: 'Imagem da Web',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: "btn btn-primary",
                denyButton: "btn btn-success",
                cancelButton: "btn btn-secondary"
            },
        }).then(async (result) => {
            if (result.isConfirmed) {
                const inputFile = document.createElement("input");
                inputFile.type = "file";
                inputFile.accept = "image/*";
                inputFile.click();

                inputFile.addEventListener("change", async () => {
                    const file = inputFile.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append("id", produtoId);
                    formData.append("imagem", file);

                    try {
                        const res = await fetch("../../../app/models/produtos/geral/edit_produto.php", {
                            method: "POST",
                            body: formData
                        });
                        const data = await res.json();

                        if (data.success) {
                            card.querySelector(".produto-imagem").src = data.novaImagemUrl + "?t=" + new Date().getTime();
                            Swal.fire({
                                title: "Sucesso!",
                                text: "A imagem foi alterada.",
                                icon: "success",
                                confirmButtonColor: "#28a745"
                            });
                        } else {
                            Swal.fire("Erro", data.error || "Erro ao atualizar imagem.", "error");
                        }
                    } catch (err) {
                        console.error(err);
                        Swal.fire("Erro", "Erro na requisição.", "error");
                    }
                });

            } else if (result.isDenied) {
                const { value: url } = await Swal.fire({
                    title: 'URL da imagem',
                    input: 'url',
                    inputPlaceholder: 'Cole o link da imagem aqui',
                    showCancelButton: true,
                    confirmButtonText: 'Usar imagem',
                    confirmButtonColor: '#28a745'
                });

                if (url) {
                    try {
                        const formData = new FormData();
                        formData.append("id", produtoId);
                        formData.append("imagem", url);

                        const res = await fetch("../../../app/models/produtos/geral/edit_produto.php", {
                            method: "POST",
                            body: formData
                        });
                        const data = await res.json();

                        if (data.success) {
                            card.querySelector(".produto-imagem").src = data.novaImagemUrl + "?t=" + new Date().getTime();
                            Swal.fire("Sucesso!", "A imagem foi alterada.", "success");
                        } else {
                            Swal.fire("Erro", data.error || "Erro ao atualizar imagem.", "error");
                        }
                    } catch (err) {
                        console.error(err);
                        Swal.fire("Erro", "Erro na requisição.", "error");
                    }
                }
            }
        });
    });
});