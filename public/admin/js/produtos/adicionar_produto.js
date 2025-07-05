document.addEventListener("DOMContentLoaded", () => {
  const btnAddProduct = document.getElementById("addproduct");

  btnAddProduct?.addEventListener("click", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Adicionar Produto",
      html: `
        <input id="swal-nome" class="form-control mb-3" placeholder="Nome do produto" required>

        <div class="d-flex gap-2 mb-3">
          <input id="swal-quantidade" type="number" min="0" class="form-control" placeholder="Estoque" required>
          <input id="swal-preco" type="text" class="form-control" placeholder="Preço (R$)" required>
        </div>

        <div class="d-flex gap-2 mb-3">
          <input id="swal-codigo-barras" class="form-control mb-3" placeholder="Código de Barras">
          <input id="swal-fornecedor" class="form-control mb-3" placeholder="Fornecedor">
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
        const fornecedor = document
          .getElementById("swal-fornecedor")
          .value.trim();
        const codigoBarras = document
          .getElementById("swal-codigo-barras")
          .value.trim();

        if (!nome)
          return Swal.showValidationMessage("O nome do produto é obrigatório");
        if (isNaN(preco) || preco < 0)
          return Swal.showValidationMessage("Informe um preço válido");
        if (isNaN(quantidade) || quantidade < 0)
          return Swal.showValidationMessage("Informe uma quantidade válida");
        if (!imagemFile)
          return Swal.showValidationMessage("Selecione uma imagem");

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
        const { nome, preco, descricao, quantidade, status, imagemFile } =
          result.value;

        const formData = new FormData();
        formData.append("nome", nome);
        formData.append("preco", preco);
        formData.append("descricao", descricao);
        formData.append("quantidade", quantidade);
        formData.append("status", status);
        formData.append("imagem", imagemFile);
        formData.append("fornecedor", fornecedor);
        formData.append("codigo_barras", codigoBarras);

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
});
