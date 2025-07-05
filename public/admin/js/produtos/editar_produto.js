document.addEventListener("DOMContentLoaded", () => {


  function formatarPreco(valor) {
    return (
      "R$ " +
      valor
        .toFixed(2)
        .replace(".", ",")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    );
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
            <input id="swal-preco" type="text" class="form-control" placeholder="Preço (R$)" value="${formatarPreco(
              preco
            )}" required>
          </div>

          <div class="d-flex gap-2 mb-3">
            <input id="swal-codigo-barras" class="form-control mb-3" placeholder="Código de Barras" value="${
              btn.dataset.codigoBarras || ""
            }">
            <input id="swal-fornecedor" class="form-control mb-3" placeholder="Fornecedor" value="${
              btn.dataset.fornecedor || ""
            }">
          </div>

          <textarea id="swal-descricao" class="form-control mb-3" placeholder="Descrição">${descricao}</textarea>

          <div class="d-flex gap-2">
            <select id="swal-status" class="form-control">
              <option value="1" ${status == 1 ? "selected" : ""}>Ativo</option>
              <option value="0" ${
                status == 0 ? "selected" : ""
              }>Inativo</option>
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
          const fornecedor = document
            .getElementById("swal-fornecedor")
            .value.trim();
          const codigoBarras = document
            .getElementById("swal-codigo-barras")
            .value.trim();

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

          return {
            nome,
            preco,
            descricao,
            quantidade,
            status,
            imagemFile,
            fornecedor,
            codigoBarras,
          };
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
          formData.append("fornecedor", produto.fornecedor);
          formData.append("codigo_barras", produto.codigoBarras);
          if (produto.imagemFile) formData.append("imagem", produto.imagemFile);

          fetch("../../app/models/produtos/editar_produto.php", {
            method: "POST",
            body: formData,
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.success) {
                Swal.fire(
                  "Sucesso!",
                  "Produto atualizado com sucesso.",
                  "success"
                ).then(() => location.reload());
              } else {
                Swal.fire(
                  "Erro",
                  data.message || "Erro ao atualizar o produto.",
                  "error"
                );
              }
            })
            .catch(() => {
              Swal.fire("Erro", "Erro ao atualizar o produto.", "error");
            });
        }
      });
    });
  });
});
