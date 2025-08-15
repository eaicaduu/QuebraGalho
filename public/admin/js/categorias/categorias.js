document.addEventListener("DOMContentLoaded", () => {
  function abrirModalCategoria(titulo, categoria = null, produtos = []) {
    const options = produtos
      .map((p) => {
        const selected = categoria
          ? categoria.produtos?.some((prod) => prod.id == p.id)
            ? "selected"
            : ""
          : "";
        return `<option value="${p.id}" ${selected}>${p.id} - ${p.nome}</option>`;
      })
      .join("");

    Swal.fire({
      title: titulo,
      html: `
        <input id="swal-nome-categoria" class="form-control mb-3" placeholder="Nome da categoria" value="${categoria?.nome || ""}" required>
        <input id="swal-oferta" class="form-control mb-3" placeholder="Oferta (ex: 10% de desconto)" value="${categoria?.oferta || ""}">

        <label>Pesquisar</label>
        <input type="search" id="swal-produtos-search" class="form-control mb-2" placeholder="Filtrar produtos...">

        <label>Produtos</label>
        <select id="swal-produtos-categoria" class="form-control" multiple size="10">
          ${options}
        </select>
      `,
      didOpen: () => {
        const searchInput = document.getElementById("swal-produtos-search");
        const select = document.getElementById("swal-produtos-categoria");

        searchInput.addEventListener("input", () => {
          const filter = searchInput.value.toLowerCase();
          for (const option of select.options) {
            const text = option.text.toLowerCase();
            option.style.display = text.includes(filter) ? "" : "none";
          }
        });
      },
      focusConfirm: false,
      showCancelButton: true,
      confirmButtonText: "Salvar",
      confirmButtonColor: "#28a745",
      cancelButtonText: "Cancelar",
      preConfirm: () => {
        const nome = document.getElementById("swal-nome-categoria").value.trim();
        const oferta = document.getElementById("swal-oferta").value.trim();
        const selecionados = Array.from(
          document.getElementById("swal-produtos-categoria").selectedOptions
        ).map((opt) => opt.value);

        if (!nome) return Swal.showValidationMessage("Informe o nome da categoria.");
        if (selecionados.length === 0) return Swal.showValidationMessage("Selecione pelo menos um produto.");

        return { nome, oferta, produtos: selecionados };
      },
    }).then((result) => {
      if (result.isConfirmed) {
        const formData = new FormData();
        if (categoria?.id) {
          formData.append("id", categoria.id);
        }
        formData.append("nome", result.value.nome);
        formData.append("oferta", result.value.oferta);
        result.value.produtos.forEach((pId) => formData.append("produtos[]", pId));

        fetch("../../app/models/categorias/salvar_categoria.php", {
          method: "POST",
          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              Swal.fire(
                "Sucesso!",
                categoria ? "Categoria atualizada com sucesso." : "Categoria criada com sucesso.",
                "success"
              ).then(() => location.reload());
            } else {
              Swal.fire("Erro", data.message || "Erro ao salvar a categoria.", "error");
            }
          })
          .catch(() => {
            Swal.fire("Erro", "Erro ao comunicar com o servidor.", "error");
          });
      }
    });
  }

  const btnAddCategoria = document.getElementById("addcategoria");
  btnAddCategoria?.addEventListener("click", async (e) => {
    e.preventDefault();

    const res = await fetch("../../app/models/categorias/buscar_produtos.php");
    const produtos = await res.json();

    if (!produtos || produtos.length === 0) {
      Swal.fire("Atenção", "Nenhum produto disponível para associar.", "warning");
      return;
    }

    abrirModalCategoria("Nova Categoria", null, produtos);
  });

  document.querySelectorAll(".btn-editar-categoria").forEach((btn) => {
    btn.addEventListener("click", async () => {
      const id = btn.getAttribute("data-id");

      try {
        const res = await fetch(`../../app/models/categorias/obter_categoria.php?id=${encodeURIComponent(id)}`);
        const categoria = await res.json();

        if (!categoria || !categoria.id) {
          return Swal.fire("Erro", "Categoria não encontrada.", "error");
        }

        const resProdutos = await fetch("../../app/models/categorias/buscar_produtos.php");
        const produtos = await resProdutos.json();

        if (!produtos || produtos.length === 0) {
          return Swal.fire("Atenção", "Nenhum produto disponível para associar.", "warning");
        }

        abrirModalCategoria("Editar Categoria", categoria, produtos);
      } catch (error) {
        Swal.fire("Erro", "Erro ao buscar dados da categoria.", "error");
      }
    });
  });

  // Evento botão excluir categoria (mantém seu código original)
  document.querySelectorAll(".btn-excluir-categoria").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      const nome = btn.getAttribute("data-nome");

      Swal.fire({
        title: `Excluir categoria "${nome}"?`,
        text: "Esta ação não pode ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, excluir",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = new FormData();
          formData.append("id", id);

          fetch("../../app/models/categorias/excluir_categoria.php", {
            method: "POST",
            body: formData,
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.success) {
                Swal.fire("Excluído!", data.message, "success").then(() => location.reload());
              } else {
                Swal.fire("Erro", data.message || "Erro ao excluir a categoria.", "error");
              }
            })
            .catch(() => {
              Swal.fire("Erro", "Erro ao comunicar com o servidor.", "error");
            });
        }
      });
    });
  });
});
