const btnImportar = document.getElementById("btnImportar");
const inputImportar = document.getElementById("inputImportar");

btnImportar.addEventListener("click", () => inputImportar.click());

inputImportar.addEventListener("change", function () {
  const file = this.files[0];
  if (!file) return;

  const originalText = btnImportar.innerHTML;
  btnImportar.disabled = true;
  btnImportar.innerHTML = `
  <span class="d-flex align-items-center justify-content-center w-100">
    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
    Importando...
  </span>
`;

  const formData = new FormData();
  formData.append("arquivo", file);

  fetch("../../../app/models/produtos/importar_produtos.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        Swal.fire(
          "Importação Finalizada",
          `${data.importados} produtos importados com sucesso!`,
          "success"
        );
      } else {
        Swal.fire("Erro", data.message || "Erro ao importar produtos.", "error");
      }
    })
    .catch(() => Swal.fire("Erro", "Falha na requisição.", "error"))
    .finally(() => {
      btnImportar.disabled = false;
      btnImportar.innerHTML = originalText;
      inputImportar.value = "";
    });
});
