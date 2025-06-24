document.addEventListener("DOMContentLoaded", () => {
  const btnAddProduct = document.getElementById("addproduct");

  btnAddProduct?.addEventListener("click", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Adicionar Produto",
      html: `
        <input id="swal-nome" class="form-control mb-3" placeholder="Nome do produto" required>

        <div class="d-flex gap-2 mb-3">
          <input id="swal-quantidade" type="number" min="0" class="form-control" placeholder="Quantidade em estoque" required>
          <input id="swal-preco" type="text" class="form-control" placeholder="Preço (R$)" required>
        </div>

        <textarea id="swal-descricao" class="form-control mb-3" placeholder="Descrição"></textarea>

        <div class="d-flex gap-2">
         <select id="swal-status" class="form-control">
            <option value="1" selected>Ativo</option>
            <option value="0">Inativo</option>
          </select>
          <input id="swal-imagem" type="file" accept="image/*" class="form-control" />
        </div>
      `,
      didOpen: () => {
        const precoInput = document.getElementById("swal-preco");

        precoInput?.addEventListener("input", function () {
          let valor = this.value.replace(/\D/g, "");
          valor = (valor / 100).toFixed(2) + "";
          valor = valor.replace(".", ",");
          valor = valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
          this.value = "R$ " + valor;
        });
      },

      focusConfirm: false,
      showCancelButton: true,
      confirmButtonText: "Salvar",
      confirmButtonColor: "#28a745",
      cancelButtonText: "Cancelar",

      preConfirm: () => {
        const nome = document.getElementById("swal-nome").value.trim();
        const precoStr = document.getElementById("swal-preco").value.trim();
        const precoLimpo = precoStr
          .replace("R$", "")
          .replace(/\./g, "")
          .replace(",", ".")
          .trim();
        const preco = parseFloat(precoLimpo);
        const descricao = document
          .getElementById("swal-descricao")
          .value.trim();
        const quantidade = parseInt(
          document.getElementById("swal-quantidade").value
        );
        const status = parseInt(document.getElementById("swal-status").value);
        const imagemFile = document.getElementById("swal-imagem").files[0];

        if (!nome)
          return Swal.showValidationMessage("O nome do produto é obrigatório");
        if (isNaN(preco) || preco < 0)
          return Swal.showValidationMessage("Informe um preço válido");
        if (isNaN(quantidade) || quantidade < 0)
          return Swal.showValidationMessage("Informe uma quantidade válida");
        if (!imagemFile)
          return Swal.showValidationMessage("Selecione uma imagem");

        return { nome, preco, descricao, quantidade, status, imagemFile };
      },
    }).then((result) => {
      if (result.isConfirmed) {
        const { nome, preco, descricao, quantidade, status, imagemFile } =
          result.value;

        const formData = new FormData();
        formData.append("nome", nome);
        formData.append("preco", preco);
        formData.append("descricao", descricao);
        formData.append("quantidade", quantidade);
        formData.append("status", status);
        formData.append("imagem", imagemFile);

        fetch("../../app/models/produtos/salvar_produto.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              Swal.fire(
                "Sucesso!",
                "Produto adicionado com sucesso.",
                "success"
              ).then(() => location.reload());
            } else {
              Swal.fire(
                "Erro",
                data.message || "Erro ao salvar o produto.",
                "error"
              );
            }
          })
          .catch(() => {
            Swal.fire("Erro", "Erro ao salvar o produto.", "error");
          });
      }
    });
  });

  const searchInput = document.getElementById("searchProduto");

  if (searchInput) {
    searchInput.addEventListener("input", function () {
      const termo = this.value.toLowerCase();
      const linhas = document.querySelectorAll(
        "table tbody tr:not(#linha-nenhum-produto)"
      );
      const linhaNenhum = document.getElementById("linha-nenhum-produto");

      let encontrou = false;

      linhas.forEach((linha) => {
        const texto = linha.innerText.toLowerCase();
        const visivel = texto.includes(termo);
        linha.style.display = visivel ? "" : "none";
        if (visivel) encontrou = true;
      });

      linhaNenhum.style.display = encontrou ? "none" : "table-row";
    });
  }

   function formatarPreco(valor) {
    return "R$ " + valor.toFixed(2).replace(".", ",").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  document.querySelectorAll(".btn-editar-produto").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;
      const nome = btn.dataset.nome;
      const preco = parseFloat(btn.dataset.preco);
      const descricao = btn.dataset.descricao;
      const quantidade = parseInt(btn.dataset.quantidade);
      const status = btn.dataset.status;

      Swal.fire({
        title: "Editar Produto",
        html: `
          <input id="swal-nome" class="form-control mb-3" placeholder="Nome do produto" value="${nome}" required>

          <div class="d-flex gap-2 mb-3">
            <input id="swal-quantidade" type="number" min="0" class="form-control" placeholder="Quantidade em estoque" value="${quantidade}" required>
            <input id="swal-preco" type="text" class="form-control" placeholder="Preço (R$)" value="${formatarPreco(preco)}" required>
          </div>

          <textarea id="swal-descricao" class="form-control mb-3" placeholder="Descrição">${descricao}</textarea>

          <div class="d-flex gap-2">
            <select id="swal-status" class="form-control">
              <option value="1" ${status == 1 ? "selected" : ""}>Ativo</option>
              <option value="0" ${status == 0 ? "selected" : ""}>Inativo</option>
            </select>
            <input id="swal-imagem" type="file" accept="image/*" class="form-control" />
          </div>
        `,
        didOpen: () => {
          const precoInput = document.getElementById("swal-preco");
          precoInput.addEventListener("input", function () {
            let valor = this.value.replace(/\D/g, "");
            valor = (valor / 100).toFixed(2) + "";
            valor = valor.replace(".", ",");
            valor = valor.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            this.value = "R$ " + valor;
          });
        },
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Salvar",
        confirmButtonColor: "#007bff",
        cancelButtonText: "Cancelar",
        preConfirm: () => {
          const nome = document.getElementById("swal-nome").value.trim();
          const precoStr = document.getElementById("swal-preco").value.trim();
          const precoLimpo = precoStr.replace("R$", "").replace(/\./g, "").replace(",", ".").trim();
          const preco = parseFloat(precoLimpo);
          const descricao = document.getElementById("swal-descricao").value.trim();
          const quantidade = parseInt(document.getElementById("swal-quantidade").value);
          const status = parseInt(document.getElementById("swal-status").value);
          const imagemFile = document.getElementById("swal-imagem").files[0]; // opcional

          if (!nome) {
            Swal.showValidationMessage("O nome do produto é obrigatório");
            return false;
          }
          if (isNaN(preco) || preco < 0) {
            Swal.showValidationMessage("Informe um preço válido");
            return false;
          }
          if (isNaN(quantidade) || quantidade < 0) {
            Swal.showValidationMessage("Informe uma quantidade válida");
            return false;
          }

          return { nome, preco, descricao, quantidade, status, imagemFile };
        },
      }).then((result) => {
        if (result.isConfirmed) {
          const produto = result.value;
          const formData = new FormData();
          formData.append("id", id);
          formData.append("nome", produto.nome);
          formData.append("preco", produto.preco);
          formData.append("descricao", produto.descricao);
          formData.append("quantidade", produto.quantidade);
          formData.append("status", produto.status);
          if (produto.imagemFile) formData.append("imagem", produto.imagemFile);

          fetch("../../app/models/produtos/editar_produto.php", {
            method: "POST",
            body: formData,
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.success) {
                Swal.fire("Sucesso!", "Produto atualizado com sucesso.", "success").then(() => location.reload());
              } else {
                Swal.fire("Erro", data.message || "Erro ao atualizar o produto.", "error");
              }
            })
            .catch(() => {
              Swal.fire("Erro", "Erro ao atualizar o produto.", "error");
            });
        }
      });
    });
  });

  document.querySelectorAll(".btn-excluir-produto").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;
      const nome = btn.dataset.nome;

      Swal.fire({
        title: "Excluir Produto",
        text: `Tem certeza que deseja excluir o produto "${nome}"?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sim, excluir",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`../../app/models/produtos/excluir_produto.php?id=${id}`, {
            method: "GET",
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.success) {
                Swal.fire("Excluído!", "Produto excluído com sucesso.", "success").then(() => location.reload());
              } else {
                Swal.fire("Erro", data.message || "Erro ao excluir o produto.", "error");
              }
            })
            .catch(() => {
              Swal.fire("Erro", "Erro ao excluir o produto.", "error");
            });
        }
      });
    });
  });

  document.getElementById("btnImportar").addEventListener("click", () => {
  document.getElementById("inputImportar").click();
});

document.getElementById("inputImportar").addEventListener("change", function() {
  const file = this.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append("arquivo", file);

  fetch("../../app/models/produtos/importar_produtos.php", {
    method: "POST",
    body: formData,
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("Importação realizada com sucesso!");
    } else {
      alert("Erro: " + data.message);
    }
  })
  .catch(() => alert("Erro ao importar arquivo."));
});
});
