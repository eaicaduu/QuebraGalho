document.addEventListener("DOMContentLoaded", () => {
  var input = document.getElementById("searchProduto");
  var tabelaBody = document.getElementById("produtos-body");

  input.addEventListener(
    "input",
    debounce(function () {
      const query = this.value.trim();

      const url =
        query === ""
          ? "../../../app/models/produtos/buscar_produtos.php?padrao=1"
          : `../../../app/models/produtos/buscar_produtos.php?q=${encodeURIComponent(
            query
          )}`;

      fetch(url)
        .then((res) => res.json())
        .then((data) => {
          const produtos = data.produtos;
          tabelaBody.innerHTML = "";

          if (produtos.length === 0) {
            tabelaBody.innerHTML = `
              <tr>
                <td colspan="11" class="text-center text-muted">Nenhum produto encontrado.</td>
              </tr>`;
            return;
          }

          produtos.forEach((produto) => {
            tabelaBody.insertAdjacentHTML('beforeend', produto.html);
          });
        });
    }, 300)
  );

  function debounce(func, delay) {
    let timer;
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => func.apply(this, args), delay);
    };
  }

  const clearBtn = document.getElementById("clearSearch");

  input.addEventListener("input", () => {
    clearBtn.style.display = input.value.length > 0 ? "block" : "none";
  });

  clearBtn.addEventListener("click", () => {
    input.value = "";
    clearBtn.style.display = "none";
    input.dispatchEvent(new Event("input"));
  });
});
