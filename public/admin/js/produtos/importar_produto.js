document.addEventListener("DOMContentLoaded", () => {

  document.getElementById("btnImportar").addEventListener("click", () => {
    document.getElementById("inputImportar").click();
  });

  document
    .getElementById("inputImportar")
    .addEventListener("change", function () {
      const file = this.files[0];
      if (!file) return;

      const formData = new FormData();
      formData.append("arquivo", file);

      fetch("../../app/models/produtos/importar_produtos.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            alert("Importação realizada com sucesso!");
          } else {
            alert("Erro: " + data.message);
          }
        })
        .catch(() => alert("Erro ao importar arquivo."));
    });

});