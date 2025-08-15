document.addEventListener("DOMContentLoaded", () => {
  carregarUsuarios();

  function carregarUsuarios() {
    fetch("../../../app/models/usuarios/listar_usuarios.php")
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById("usuarios");
        const msgNenhum = document.getElementById("linha-nenhum-usuario");
        const totalEl = document.getElementById("totalUsuarios");

        container.innerHTML = "";

        totalEl.textContent = data?.success ? Number(data.totalUsuarios ?? 0) : 0;

        if (data?.success && Array.isArray(data.usuarios) && data.usuarios.length > 0) {
          msgNenhum.style.display = "none";

          data.usuarios.forEach(usuario => {
            const wrapper = document.createElement("div");
            wrapper.className = "col-12 col-md-6 mb-3";

            const nome = escapeHtml(usuario.nome || "");
            const documento = String(usuario.documento || "");
            const email = escapeHtml(usuario.email || "");
            const tipoNum = Number(usuario.tipo_usuario ?? 0);
            const imagemHTML = usuario.imagem_perfil && usuario.imagem_perfil.trim() !== ""
              ? `<img src="../../../app/${usuario.imagem_perfil.replace(/"/g, "%22")}"
                       alt="${nome}"
                       class="img-fluid rounded-start pe-none"
                       style="width:80px;height:80px;object-fit:cover;">`
              : `<div class="d-flex justify-content-center align-items-center bg-light rounded-start"
                       style="width:80px;height:80px;">
                   <i class="bi bi-person-fill text-secondary fs-2"></i>
                 </div>`;

            wrapper.innerHTML = `
              <div class="card shadow-sm border-0 h-100">
                <div class="d-flex flex-column flex-md-row align-items-center p-2 gap-3">
                  ${imagemHTML}
                  <div class="flex-grow-1 w-100">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                      <h6 class="mb-1 fw-bold">${nome}</h6>
                      <small class="text-muted"><strong>CPF:</strong> ${formatarCPF(documento)}</small>
                    </div>
                    <p class="mb-1"><strong>Email:</strong> ${email}</p>
                    <span class="badge bg-${getTipoBadge(tipoNum)}">${getTipoUsuario(tipoNum)}</span>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <small class="text-muted">Criado em ${new Date(usuario.criado_em).toLocaleDateString("pt-BR")}</small>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-primary btn-editar-usuario"
                          data-id="${escapeHtml(String(usuario.id))}"
                          data-nome="${nome}"
                          data-cpf="${escapeHtml(documento)}"
                          data-email="${email}"
                          data-tipo="${escapeHtml(String(usuario.tipo_usuario))}">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-excluir-usuario"
                          data-id="${escapeHtml(String(usuario.id))}"
                          data-nome="${nome}">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;

            container.appendChild(wrapper);
          });

        } else {
          msgNenhum.style.display = "block";
        }
      })
      .catch(err => {
        console.error("Erro ao carregar usuários:", err);
        msgNenhum.style.display = "block";
        document.getElementById("totalUsuarios").textContent = 0;
      });
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function formatarCPF(cpf) {
    if (!cpf) return "";
    const only = cpf.replace(/\D/g, "");
    return only
      .replace(/(\d{3})(\d)/, "$1.$2")
      .replace(/(\d{3})(\d)/, "$1.$2")
      .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
  }

  function getTipoBadge(tipoNum) {
    return ["secondary", "warning", "primary", "success"][tipoNum] || "dark";
  }

  function getTipoUsuario(tipoNum) {
    return ["Usuário", "PJ", "Funcionário", "Admin"][tipoNum] || "Desconhecido";
  }

  function inicializarBotoes() {
    document.querySelectorAll(".btn-editar-usuario").forEach((btn) => {
      btn.addEventListener("click", () => console.log("editar", btn.dataset.id));
    });
    document.querySelectorAll(".btn-excluir-usuario").forEach((btn) => {
      btn.addEventListener("click", () => console.log("excluir", btn.dataset.id));
    });
  }
});
