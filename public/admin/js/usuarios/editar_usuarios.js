document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".btn-editar-usuario").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const nome = btn.dataset.nome;
            const cpf = btn.dataset.cpf;
            const email = btn.dataset.email;
            const tipo = btn.dataset.tipo;

            Swal.fire({
                title: "Editar",
                html: `
          <input id="swal-nome" class="form-control mb-2" placeholder="Nome" value="${nome}">
          <input id="swal-cpf" class="form-control mb-2" placeholder="CPF" value="${cpf}" disabled>
          <input id="swal-email" class="form-control mb-2" placeholder="Email" value="${email}">
          <select id="swal-tipo" class="form-control">
          <option value="0" ${tipo == 0 ? "selected" : ""}>Normal</option>
          <option value="1" ${tipo == 1 ? "selected" : ""}>PJ</option>
          <option value="2" ${tipo == 2 ? "selected" : ""}>Funcionário</option>
          <option value="3" ${tipo == 3 ? "selected" : ""}>Administrador</option>
          </select>
        `,
                showCancelButton: true,
                confirmButtonText: "Salvar",
                confirmButtonColor: "#28a745",
                preConfirm: () => {
                    const nome = document.getElementById("swal-nome").value.trim();
                    const email = document.getElementById("swal-email").value.trim();
                    const tipo = document.getElementById('swal-tipo').value;

                    if (!nome || !email) {
                        Swal.showValidationMessage("Preencha todos os campos obrigatórios");
                        return false;
                    }

                    return { id, nome, email, tipo };
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("../../app/models/usuarios/editar_usuario.php", {
                        method: "POST",
                        body: JSON.stringify(result.value),
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire(
                                    "Sucesso",
                                    "Usuário atualizado com sucesso.",
                                    "success"
                                ).then(() => location.reload());
                            } else {
                                Swal.fire(
                                    "Erro",
                                    data.message || "Erro ao atualizar o usuário",
                                    "error"
                                );
                            }
                        });
                }
            });
        });
    });
});