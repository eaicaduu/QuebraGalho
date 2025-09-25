document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("searchCategorias");
    const categoriasBody = document.getElementById("categorias-body");
    const clearBtn = document.getElementById("clearSearch");
    const paginacaoContainer = document.getElementById("paginacao-container");

    const storagePrefix = "categorias_" + window.location.pathname.replace(/\//g, "_");
    let limite = parseInt(localStorage.getItem(storagePrefix + "_limite")) || 10;
    let paginaAtual = parseInt(localStorage.getItem(storagePrefix + "_pagina")) || 1;

    window.pesquisarCategorias = function (pagina = 1) {
        const query = input.value.trim();
        localStorage.setItem(storagePrefix, query);

        const url = `../../../app/models/produtos/categorias/pesquisar_produtos_categorias.php?q=${encodeURIComponent(query)}&pagina=${pagina}&limite=${limite}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                categoriasBody.innerHTML = "";

                if (!data.categorias || data.categorias.length === 0) {
                    categoriasBody.innerHTML = `
                        <div class="alert container p-4 rounded d-flex align-items-center justify-content-center bg-body-secondary text-center">
                            <i class="bi bi-emoji-frown me-2"></i><span>Nenhuma categoria encontrada.</span>
                        </div>
                    `;
                    paginacaoContainer.innerHTML = "";
                    return;
                }

                data.categorias.forEach(categoria => {
                    categoriasBody.insertAdjacentHTML("beforeend", categoria.html);
                });

                paginaAtual = pagina;
                localStorage.setItem(storagePrefix + "_pagina", paginaAtual);

                atualizarPaginacao(data.totalPaginas);
            });
    }

    function atualizarPaginacao(totalPaginas) {
        let html = "";

        if (totalPaginas > 1) {
            html += `
        <form method="get" class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2" onsubmit="return false;">
          <div>
            <label for="limite" class="form-label mb-0 me-2">Itens por página:</label>
            <select id="limite" class="form-select form-select-sm d-inline-block w-auto">
              <option value="10" ${limite === 10 ? "selected" : ""}>10</option>
              <option value="20" ${limite === 20 ? "selected" : ""}>20</option>
              <option value="100" ${limite === 100 ? "selected" : ""}>100</option>
              <option value="1000" ${limite === 1000 ? "selected" : ""}>1000</option>
              <option value="5000" ${limite === 5000 ? "selected" : ""}>5000</option>
            </select>
          </div>
        `;

            html += `<nav><ul class="pagination mb-0">`;

            const maxLinks = 5;
            let start = Math.max(1, paginaAtual - Math.floor(maxLinks / 2));
            let end = Math.min(totalPaginas, start + maxLinks - 1);

            if (start > 1) {
                html += `<li class="page-item"><a class="page-link" href="#" data-pagina="1">1</a></li>`;
            }

            for (let i = start; i <= end; i++) {
                html += `
            <li class="page-item ${i === paginaAtual ? "active" : ""}">
              <a class="page-link" href="#" data-pagina="${i}">${i}</a>
            </li>`;
            }

            if (end < totalPaginas) {
                html += `<li class="page-item"><a class="page-link" href="#" data-pagina="${totalPaginas}">${totalPaginas}</a></li>`;
            }

            html += `</ul></nav></form>`;
        }

        paginacaoContainer.innerHTML = html;

        if (totalPaginas > 1) {
            document.getElementById("limite").addEventListener("change", (e) => {
                limite = parseInt(e.target.value);
                localStorage.setItem(storagePrefix + "_limite", limite);
                window.pesquisarCategorias(paginaAtual);
            });

            document.querySelectorAll(".pagination .page-link").forEach(link => {
                link.addEventListener("click", (e) => {
                    e.preventDefault();
                    const pagina = parseInt(link.dataset.pagina);
                    if (!isNaN(pagina)) {
                        window.pesquisarCategorias(pagina);
                    }
                });
            });
        }
    }


    function debounce(func, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), delay);
        };
    }

    input.addEventListener("input", debounce(() => window.pesquisarCategorias(1), 300));

    input.addEventListener("input", () => {
        clearBtn.style.display = input.value.length > 0 ? "block" : "none";
    });

    clearBtn.addEventListener("click", () => {
        input.value = "";
        clearBtn.style.display = "none";
        localStorage.removeItem(storagePrefix);
        window.pesquisarCategorias(1);
    });

    const savedQuery = localStorage.getItem(storagePrefix);
    if (savedQuery) {
        input.value = savedQuery;
        clearBtn.style.display = savedQuery.length > 0 ? "block" : "none";
        window.pesquisarCategorias(paginaAtual);
    } else {
        window.pesquisarCategorias(paginaAtual);
    }

    window.pesquisarCategorias(paginaAtual);
});
