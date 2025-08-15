document.addEventListener("DOMContentLoaded", () => {
    const btnCriarUsuario = document.getElementById("btnCriarUsuario");

    btnCriarUsuario.addEventListener("click", () => {
        Swal.fire({
            title: "Criar Usuário",
            html: `
                <input id="swal-nome" class="form-control mb-2" placeholder="Nome">
                <input id="swal-documento" class="form-control mb-2" placeholder="Documento CPF ou CNPJ">
                <input id="swal-email" class="form-control mb-2" placeholder="Email" type="email">
                <select id="swal-tipo" class="form-control">
                    <option value="0">Usuário</option>
                    <option value="1">PJ</option>
                    <option value="2">Funcionário</option>
                    <option value="3">Admin</option>
                </select>
            `,
            didOpen: () => {
                const docInput = document.getElementById("swal-documento");
                docInput.addEventListener("input", (e) => {
                    e.target.value = formatarDocumento(e.target.value);
                });
            },
            showCancelButton: true,
            confirmButtonText: "Criar",
            confirmButtonColor: "#28a745",
            preConfirm: () => {
                const nome = document.getElementById("swal-nome").value.trim();
                const documento = document.getElementById("swal-documento").value.trim();
                const email = document.getElementById("swal-email").value.trim();
                const tipo_usuario = document.getElementById("swal-tipo").value;

                if (!nome || !documento || !email) {
                    Swal.showValidationMessage("Preencha todos os campos obrigatórios");
                    return false;
                }

                return { nome, documento, email, tipo_usuario };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("../../../app/models/usuarios/criar_usuario.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(result.value),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Sucesso", data.message, "success")
                            .then(() => location.reload());
                    } else {
                        Swal.fire("Erro", data.message || "Erro ao criar o usuário", "error");
                    }
                });
            }
        });
    });
});

function formatarDocumento(valor) {
    let doc = valor.replace(/\D/g, "");

    if (doc.length <= 11) { 
        doc = doc.substring(0, 11);
        if (doc.length > 9) {
            return doc.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, "$1.$2.$3-$4");
        } else if (doc.length > 6) {
            return doc.replace(/(\d{3})(\d{3})(\d{0,3})/, "$1.$2.$3");
        } else if (doc.length > 3) {
            return doc.replace(/(\d{3})(\d{0,3})/, "$1.$2");
        } else {
            return doc;
        }
    } else { 
        doc = doc.substring(0, 14);
        if (doc.length > 12) {
            return doc.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, "$1.$2.$3/$4-$5");
        } else if (doc.length > 8) {
            return doc.replace(/(\d{2})(\d{3})(\d{3})(\d{0,4})/, "$1.$2.$3/$4");
        } else if (doc.length > 5) {
            return doc.replace(/(\d{2})(\d{3})(\d{0,3})/, "$1.$2.$3");
        } else if (doc.length > 2) {
            return doc.replace(/(\d{2})(\d{0,3})/, "$1.$2");
        } else {
            return doc;
        }
    }
}
