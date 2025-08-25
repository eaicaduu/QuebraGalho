document.addEventListener("DOMContentLoaded", () => {
    const addBtn = document.getElementById("addImageCarousel");
    const fileInput = document.getElementById("imageInput");
    const imagesDiv = document.getElementById("carouselImages");

    function carregarImagens() {
        fetch("../../../app/models/configuracoes/listar_carousel.php")
            .then(res => res.json())
            .then(imagens => {
                imagesDiv.innerHTML = "";
                imagens.forEach(img => {
                    let col = document.createElement("div");
                    col.classList.add("col-md-3", "mb-3", "d-flex", "justify-content-center");
                    col.innerHTML = `
                        <div class="position-relative d-flex align-items-center justify-content-center border rounded-3 bg-white shadow-sm"
                             style="width:240px; height:120px; overflow:hidden;">
                             
                            <img src="../../../app/uploads/carousel/${img.imagem}" 
                                 class="img-fluid h-100 w-100 object-fit-cover"
                                 onerror="this.onerror=null;this.src='../../images/default.png';">

                            <!-- Overlay -->
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 opacity-0 hover-overlay"
                                 style="transition: opacity 0.3s;">
                                <button class="btn btn-primary me-2 editar-btn" data-id="${img.id}" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger excluir-btn" data-id="${img.id}" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    imagesDiv.appendChild(col);
                });

                document.querySelectorAll(".excluir-btn").forEach(btn => {
                    btn.addEventListener("click", () => excluirImagem(btn.dataset.id));
                });

                document.querySelectorAll(".editar-btn").forEach(btn => {
                    btn.addEventListener("click", () => editarImagem(btn.dataset.id));
                });
            });
    }

    carregarImagens();

    addBtn.addEventListener("click", () => {
        fileInput.click();
    });

    fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) {
            let formData = new FormData();
            formData.append("imagem", fileInput.files[0]);

            fetch("../../../app/models/configuracoes/add_carousel.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Adicionada!",
                            text: "A imagem foi adicionada.",
                            icon: "success",
                            confirmButtonColor: "#28a745"
                        }).then(() => {
                            const imgCard = Array.from(imagesDiv.querySelectorAll("img"))
                                .find(img => img.src.includes(data.filename));

                            if (imgCard) {
                                const cardWrapper = imgCard.closest(".col-md-3");

                                cardWrapper.style.opacity = "0";
                                cardWrapper.style.transform = "scale(0.8) translateY(-20px)";

                                cardWrapper.offsetHeight;

                                cardWrapper.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                                cardWrapper.style.opacity = "1";
                                cardWrapper.style.transform = "scale(1) translateY(0)";
                            };
                            carregarImagens();
                        });
                    } else {
                        Swal.fire("Erro", data.message, "error");
                    }
                })
                .catch(err => console.error(err));
        }
    });

    function excluirImagem(id) {
        Swal.fire({
            title: "Tem certeza?",
            text: "Essa imagem será removida do carousel.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Sim, excluir",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                fetch("../../../app/models/configuracoes/del_carousel.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id=" + id
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Excluída!",
                                text: "A imagem foi removida.",
                                icon: "success",
                                confirmButtonColor: "#28a745"
                            }).then(() => {
                                const imgCard = document.querySelector(`[data-id="${id}"]`).closest(".col-md-3");
                                if (imgCard) {
                                    imgCard.style.transition = "all 0.6s ease";
                                    imgCard.style.opacity = "0";
                                    imgCard.style.transform = "scale(0) translateY(-20px)";
                                    setTimeout(() => {
                                        imgCard.remove();
                                    }, 300);
                                }
                            });
                        } else {
                            Swal.fire("Erro", data.message, "error");
                        }
                    });
            }
        });
    }

    function editarImagem(id) {
        Swal.fire({
            title: "Selecione uma nova imagem",
            input: "file",
            inputAttributes: {
                accept: "image/*"
            },
            showCancelButton: true,
            confirmButtonColor: "#0d6efd",
            confirmButtonText: "Atualizar",
            cancelButtonText: "Cancelar",
            preConfirm: (file) => {
                if (!file) {
                    Swal.showValidationMessage("Selecione uma imagem!");
                }
                return file;
            }
        }).then(result => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append("id", id);
                formData.append("imagem", result.value);

                return fetch("../../../app/models/configuracoes/edit_carousel.php", {
                    method: "POST",
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Atualizado!",
                                text: "A imagem foi substituída.",
                                icon: "success",
                                confirmButtonColor: "#28a745"
                            }).then(() => {
                                const imgCard = document.querySelector(`[data-id="${id}"]`).closest(".col-md-3");
                                if (imgCard) {
                                    const img = imgCard.querySelector("img");
                                    if (img) {
                                        img.style.transition = "opacity 0.5s ease";
                                        img.style.opacity = "0";

                                        setTimeout(() => {
                                            img.src = `../../../app/uploads/carousel/${data.novaImagem}`;
                                            img.style.opacity = "1";
                                        }, 500);
                                    }
                                }
                            });
                        } else {
                            Swal.fire("Erro", data.message, "error");
                        }
                    });
            }
        });
    }
});
