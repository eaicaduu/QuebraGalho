document.addEventListener("DOMContentLoaded", () => {
  carregarUsuarios();

  function carregarUsuarios() {
    fetch("../../../app/models/usuarios/listar_usuarios.php")
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById("usuarios");
        const msgNenhum = document.getElementById("linha-nenhum-usuario");
        const totalUsuarios = document.getElementById("totalUsuarios");

        container.innerHTML = data.html;

        totalUsuarios.textContent = data.totalUsuarios;

        if (!data.html.trim()) {
          msgNenhum.style.display = "block";
        } else {
          msgNenhum.style.display = "none";
        }

        inicializarBotoes();
      })
      .catch(err => {
        console.error("Erro ao carregar usuários:", err);
        msgNenhum.style.display = "block";
        document.getElementById("totalUsuarios").textContent = 0;
      });
  }

  function inicializarBotoes() {
    document.querySelectorAll(".btn-editar-usuario").forEach((btn) => {
      btn.addEventListener("click", () => {
        const id = btn.dataset.id;
        const nome = btn.dataset.nome;
        const cpf = btn.dataset.cpf;
        const email = btn.dataset.email;
        const tipo = btn.dataset.tipo;

        window.editarUsuario(id, nome, cpf, email, tipo);
      });
    });

    document.querySelectorAll(".btn-excluir-usuario").forEach((btn) => {
      btn.addEventListener("click", () => {
        const id = btn.dataset.id;
        const nome = btn.dataset.nome;

        window.excluirUsuario(id, nome);
      });
    });
  }
});
