document.addEventListener("DOMContentLoaded", () => {
    const btnExportarUsuarios = document.getElementById("btnExportarUsuarios");

    btnExportarUsuarios.addEventListener("click", () => {
        Swal.fire({
            title: "Exportar",
            html: `
      <p class="mb-2">Escolha os campos que deseja exportar:</p>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-nome" checked>
        <label class="form-check-label" for="exp-nome">Nome</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-documento" checked>
        <label class="form-check-label" for="exp-documento">Documento (CPF)</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-email" checked>
        <label class="form-check-label" for="exp-email">Email</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-tipo_usuario" checked>
        <label class="form-check-label" for="exp-tipo_usuario">TipoUsuario</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-criado_em" checked>
        <label class="form-check-label" for="exp-criado_em">CriadoEm</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="exp-imagem_perfil" checked>
        <label class="form-check-label" for="exp-imagem_perfil">ImagemPerfil</label>
      </div>
      `,
            showCancelButton: true,
            confirmButtonText: "Exportar",
            confirmButtonColor: "#28a745",
            cancelButtonText: "Cancelar",
            preConfirm: () => {
                const campos = [
                    { id: "exp-nome", label: "Nome" },
                    { id: "exp-documento", label: "Documento" },
                    { id: "exp-email", label: "Email" },
                    { id: "exp-tipo_usuario", label: "TipoUsuario" },
                    { id: "exp-criado_em", label: "CriadoEm" },
                    { id: "exp-imagem_perfil", label: "ImagemPerfil" },
                ].filter(campo => document.getElementById(campo.id).checked);

                if (campos.length === 0) {
                    Swal.showValidationMessage("Selecione ao menos um campo para exportar.");
                    return false;
                }
                return campos;
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const camposSelecionados = result.value;
                const container = document.getElementById("usuarios");
                const usuariosCards = container.querySelectorAll(".col-12.col-md-6.mb-3");

                if (usuariosCards.length === 0) {
                    Swal.fire("Nenhum usuário encontrado para exportar.");
                    return;
                }

                let xml = '<?xml version="1.0" encoding="UTF-8"?>\n<Usuarios>\n';

                usuariosCards.forEach(card => {
                    const nome = card.querySelector("h6.fw-bold")?.textContent.trim() || "";
                    const cpfSmall = card.querySelector("small.text-muted");
                    let documento = "";
                    if (cpfSmall) {
                        documento = cpfSmall.textContent.replace("CPF:", "").trim();
                    }
                    const email = card.querySelector("p.mb-1")?.textContent.replace("Email:", "").trim() || "";
                    const tipoUsuario = card.querySelector("span.badge")?.textContent.trim() || "";

                    let criadoEm = "";
                    card.querySelectorAll("small.text-muted").forEach(s => {
                        if (s.textContent.includes("Criado em")) {
                            criadoEm = s.textContent.replace("Criado em", "").trim();
                        }
                    });

                    const imgEl = card.querySelector("img.img-fluid");
                    const imagemPerfil = imgEl ? imgEl.src : "";
                    let imagemRelativa = imagemPerfil;
                    const prefixo = "http://192.168.0.106/QuebraGalho/app/uploads/perfil/";
                    if (imagemPerfil.startsWith(prefixo)) {
                        imagemRelativa = imagemPerfil.slice(prefixo.length);
                    }

                    xml += "  <Usuario>\n";

                    camposSelecionados.forEach(campo => {
                        let valor = "";
                        switch (campo.id) {
                            case "exp-nome": valor = nome; break;
                            case "exp-documento": valor = documento; break;
                            case "exp-email": valor = email; break;
                            case "exp-tipo_usuario": valor = tipoUsuario; break;
                            case "exp-criado_em": valor = criadoEm; break;
                            case "exp-imagem_perfil": valor = imagemRelativa; break;
                        }
                        valor = escapeXml(valor);
                        xml += `    <${campo.label}>${valor}</${campo.label}>\n`;
                    });

                    xml += "  </Usuario>\n";
                });

                xml += "</Usuarios>";

                function escapeXml(unsafe) {
                    return unsafe.replace(/[<>&'"]/g, function (c) {
                        switch (c) {
                            case "<": return "&lt;";
                            case ">": return "&gt;";
                            case "&": return "&amp;";
                            case "'": return "&apos;";
                            case '"': return "&quot;";
                            default: return c;
                        }
                    });
                }

                const blob = new Blob([xml], { type: "application/xml" });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.href = url;
                link.download = "usuarios.xml";
                document.body.appendChild(link);
                setTimeout(() => {
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                }, 0);
            }
        });
    });
});
