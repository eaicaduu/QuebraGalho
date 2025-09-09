document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("searchProduto");
  const tabelaBody = document.getElementById("produtos-body");
  const clearBtn = document.getElementById("clearSearch");
  const localStorageKey = "searchProdutoValue";

  function pesquisar() {
    const query = input.value.trim();

    if (query.length < 2 && isNaN(query)) {
      tabelaBody.innerHTML = "";
      return;
    }

    localStorage.setItem(localStorageKey, query);

    const url =
      query === ""
        ? "../../../app/models/produtos/geral/pesquisar_produto.php?padrao=1"
        : `../../../app/models/produtos/geral/pesquisar_produto.php?q=${encodeURIComponent(query)}`;

    fetch(url)
      .then((res) => res.json())
      .then((data) => {
        const produtos = data.produtos;
        tabelaBody.innerHTML = "";

        if (produtos.length === 0) {
          tabelaBody.innerHTML = `
            <div class="alert container p-4 rounded d-flex align-items-center justify-content-center bg-body-secondary text-center">
              <i class="bi bi-emoji-frown me-2"></i><span>Nenhum produto encontrado.</span>
            </div>
          `;
          return;
        }

        produtos.forEach((produto) => {
          tabelaBody.insertAdjacentHTML("beforeend", produto.html);
        });
      });
  }

  function debounce(func, delay) {
    let timer;
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => func.apply(this, args), delay);
    };
  }

  input.addEventListener("input", debounce(pesquisar, 300));

  input.addEventListener("input", () => {
    clearBtn.style.display = input.value.length > 0 ? "block" : "none";
  });

  clearBtn.addEventListener("click", () => {
    input.value = "";
    clearBtn.style.display = "none";
    localStorage.removeItem(localStorageKey);
    input.dispatchEvent(new Event("input"));
  });

  const savedQuery = localStorage.getItem(localStorageKey);
  if (savedQuery) {
    input.value = savedQuery;
    clearBtn.style.display = savedQuery.length > 0 ? "block" : "none";
    input.dispatchEvent(new Event("input"));
  }
});
