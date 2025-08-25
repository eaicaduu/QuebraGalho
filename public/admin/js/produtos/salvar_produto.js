document.addEventListener("DOMContentLoaded", () => {
  const btnAddProduct = document.getElementById("addproduct");

  btnAddProduct?.addEventListener("click", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Adicionar Produto",
      html: `
<label for="swal-nome" class="form-label">Nome do Produto</label>
<input id="swal-nome" class="form-control mb-3" placeholder="Nome do produto" required>

<label for="swal-preco" class="form-label">Preço (R$)</label>
<input id="swal-preco" type="text" class="form-control mb-3" placeholder="Preço (R$)" required>

<label for="swal-status" class="form-label">Status</label>
<select id="swal-status" class="form-control mb-3">
  <option value="1" selected>Ativo</option>
  <option value="0">Inativo</option>
</select>

<label for="swal-imagem" class="form-label">Imagem do Produto</label>
<input id="swal-imagem" type="file" class="form-control mb-3" accept="image/*">
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
        const status = parseInt(document.getElementById("swal-status").value);
        const imagem = document.getElementById("swal-imagem").files[0];

        if (!nome)
          return Swal.showValidationMessage("O nome do produto é obrigatório");
        if (isNaN(preco) || preco < 0)
          return Swal.showValidationMessage("Informe um preço válido");
        if (!imagem)
          return Swal.showValidationMessage("Selecione uma imagem para o produto");

        return { nome, preco, status, imagem };
      },
    }).then((result) => {
      if (result.isConfirmed) {
        const { nome, preco, status, imagem } = result.value;

        const formData = new FormData();
        formData.append("nome", nome);
        formData.append("preco", preco);
        formData.append("status", status);
        formData.append("imagem", imagem);

        fetch("../../../app/models/produtos/salvar_produtos.php", {
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

  document.getElementById("produtos-body").addEventListener("click", async (e) => {
    const btn = e.target.closest(".salvar-produto");
    if (!btn) return;

    const card = btn.closest(".produto-item");
    const produtoId = card.dataset.produtoId;
    const nome = card.querySelector(".nome-produto").value;
    const status = card.querySelector(".status-produto").value;

    try {
      const formData = new FormData();
      formData.append("id", produtoId);
      formData.append("nome", nome);
      formData.append("status", status);

      const res = await fetch("../../../app/models/produtos/edit_produtos.php", {
        method: "POST",
        body: formData
      });

      const data = await res.json();
      if (data.success) {
        Swal.fire({
          title: "Salvo!",
          text: "A alteração foi salva.",
          icon: "success",
          confirmButtonColor: "#28a745"
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: data.error || 'Erro ao atualizar produto.',
        });
      }
    } catch (err) {
      console.error(err);
      Swal.fire({
        icon: 'error',
        title: 'Erro',
        text: 'Erro na requisição.',
      });
    }
  });

  document.getElementById("produtos-body").addEventListener("click", async (e) => {
    const btn = e.target.closest(".alterar-imagem");
    if (!btn) return;

    const card = btn.closest(".produto-item");
    const produtoId = card.dataset.produtoId;

    const inputFile = document.createElement("input");
    inputFile.type = "file";
    inputFile.accept = "image/*";
    inputFile.click();

    inputFile.addEventListener("change", async () => {
      const file = inputFile.files[0];
      if (!file) return;

      const formData = new FormData();
      formData.append("id", produtoId);
      formData.append("imagem", file);

      try {
        const res = await fetch("../../../app/models/produtos/edit_produtos.php", {
          method: "POST",
          body: formData
        });
        const data = await res.json();

        if (data.success) {
          card.querySelector(".produto-imagem").src = data.novaImagemUrl + "?t=" + new Date().getTime();

          Swal.fire({
            title: "Sucesso!",
            text: "A imagem foi alterada.",
            icon: "success",
            confirmButtonColor: "#28a745"
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: data.error || 'Erro ao atualizar imagem.'
          });
        }
      } catch (err) {
        console.error(err);
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: 'Erro na requisição.'
        });
      }
    });
  });


});
