document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-editar-usuario").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;
      const nome = btn.dataset.nome;
      const cpf = btn.dataset.cpf;
      const email = btn.dataset.email;
      const admin = btn.dataset.admin;

      Swal.fire({
        title: "Editar",
        html: `
          <input id="swal-nome" class="form-control mb-2" placeholder="Nome" value="${nome}">
          <input id="swal-cpf" class="form-control mb-2" placeholder="CPF" value="${cpf}" disabled>
          <input id="swal-email" class="form-control mb-2" placeholder="Email" value="${email}">
          <select id="swal-admin" class="form-control">
            <option value="0" ${admin == 0 ? "selected" : ""}>Usuário</option>
            <option value="1" ${admin == 1 ? "selected" : ""}>Admin</option>
          </select>
        `,
        showCancelButton: true,
        confirmButtonText: "Salvar",
        confirmButtonColor: "#28a745",
        preConfirm: () => {
          const nome = document.getElementById("swal-nome").value.trim();
          const email = document.getElementById("swal-email").value.trim();
          const perm_admin = document.getElementById("swal-admin").value;

          if (!nome || !email) {
            Swal.showValidationMessage("Preencha todos os campos obrigatórios");
            return false;
          }

          return { id, nome, email, perm_admin };
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

  document.querySelectorAll(".btn-excluir-usuario").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;
      const nome = btn.dataset.nome;

      Swal.fire({
        title: `Excluir ${nome}?`,
        text: "Esta ação não poderá ser desfeita.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("../../app/models/usuarios/excluir_usuario.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id }),
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.success) {
                Swal.fire(
                  "Excluído",
                  "Usuário removido com sucesso.",
                  "success"
                ).then(() => location.reload());
              } else {
                Swal.fire("Erro", data.message || "Erro ao excluir", "error");
              }
            });
        }
      });
    });
  });

  const searchInput = document.getElementById("searchUsuario");

  searchInput.addEventListener("input", function () {
    const termo = this.value.toLowerCase();
    const linhas = document.querySelectorAll(
      "table tbody tr:not(#linha-nenhum-usuario)"
    );

    let encontrou = false;

    linhas.forEach((linha) => {
      const texto = linha.innerText.toLowerCase();
      const visivel = texto.includes(termo);
      linha.style.display = visivel ? "" : "none";
      if (visivel) encontrou = true;
    });

    const linhaNenhum = document.getElementById("linha-nenhum-usuario");
    linhaNenhum.style.display = encontrou ? "none" : "";
  });

  document.getElementById("btnCriarUsuario").addEventListener("click", () => {
    Swal.fire({
      title: "Criar",
      html: `
      <input id="swal-nome" class="form-control mb-2" placeholder="Nome">
      <input id="swal-cpf" class="form-control mb-2" placeholder="CPF (somente números)">
      <input id="swal-email" class="form-control mb-2" placeholder="Email">
      <input id="swal-senha" class="form-control mb-2" placeholder="Senha" type="password">
      <select id="swal-admin" class="form-control">
        <option value="0">Usuário</option>
        <option value="1">Admin</option>
      </select>
    `,
      showCancelButton: true,
      confirmButtonText: "Criar",
      confirmButtonColor: "#28a745",
      preConfirm: () => {
        const nome = document.getElementById("swal-nome").value.trim();
        const cpf = document.getElementById("swal-cpf").value.trim();
        const email = document.getElementById("swal-email").value.trim();
        const senha = document.getElementById("swal-senha").value.trim();
        const perm_admin = document.getElementById("swal-admin").value;

        if (!nome || !cpf || !email || !senha) {
          Swal.showValidationMessage("Preencha todos os campos obrigatórios");
          return false;
        }

        return { nome, cpf, email, senha, perm_admin };
      },
    }).then((result) => {
      if (result.isConfirmed) {
        fetch("../../app/models/usuarios/criar_usuario.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(result.value),
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              Swal.fire(
                "Sucesso",
                "Usuário criado com sucesso.",
                "success"
              ).then(() => location.reload());
            } else {
              Swal.fire(
                "Erro",
                data.message || "Erro ao criar o usuário",
                "error"
              );
            }
          });
      }
    });
  });

document.getElementById("btnExportarUsuarios").addEventListener("click", () => {
  Swal.fire({
    title: "Exportar",
    html: `
      <p class="mb-2">Escolha os campos que deseja exportar:</p>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-id" checked>
        <label class="form-check-label" for="exp-id">ID</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-nome" checked>
        <label class="form-check-label" for="exp-nome">Nome</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-cpf" checked>
        <label class="form-check-label" for="exp-cpf">CPF</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-email" checked>
        <label class="form-check-label" for="exp-email">Email</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-admin" checked>
        <label class="form-check-label" for="exp-admin">Admin</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-data" checked>
        <label class="form-check-label" for="exp-data">Criado em</label>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: "Exportar",
    confirmButtonColor: "#28a745",
    cancelButtonText: "Cancelar",
    preConfirm: () => {
      const campos = [
        { id: "exp-id", label: "ID" },
        { id: "exp-nome", label: "Nome" },
        { id: "exp-cpf", label: "CPF" },
        { id: "exp-email", label: "Email" },
        { id: "exp-admin", label: "Admin" },
        { id: "exp-data", label: "Criado em" }
      ].filter((campo) => document.getElementById(campo.id).checked);

      if (campos.length === 0) {
        Swal.showValidationMessage("Selecione ao menos um campo para exportar.");
        return false;
      }

      return campos;
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const camposSelecionados = result.value;
      const linhas = document.querySelectorAll("table tbody tr");
      if (!linhas.length) return;

      let csv = camposSelecionados.map(c => c.label).join(",") + "\n";

      linhas.forEach((linha) => {
        const colunas = linha.querySelectorAll("td");
        if (colunas.length < 6) return;

        const dados = [];

        camposSelecionados.forEach((campo) => {
          switch (campo.id) {
            case "exp-id":
              dados.push(`"${colunas[0].textContent.trim()}"`);
              break;
            case "exp-nome":
              dados.push(`"${colunas[1].textContent.trim()}"`);
              break;
            case "exp-cpf":
              dados.push(`"${colunas[2].textContent.trim()}"`);
              break;
            case "exp-email":
              dados.push(`"${colunas[3].textContent.trim()}"`);
              break;
            case "exp-admin":
              dados.push(`"${colunas[4].textContent.trim()}"`);
              break;
            case "exp-data":
              dados.push(`"${colunas[5].textContent.trim()}"`);
              break;
          }
        });

        csv += dados.join(",") + "\n";
      });

      const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
      const url = URL.createObjectURL(blob);
      const link = document.createElement("a");
      link.href = url;
      link.download = "usuarios.csv";
      link.click();
    }
  });
});

});
