document.addEventListener("DOMContentLoaded", () => {
  const tabelaBody = document.getElementById("produtos-body");
  const paginacaoContainer = document.getElementById("paginacao-container");
  const totalProdutos = document.getElementById("totalCadastrados");
  const storagePrefix = "produtos_" + window.location.pathname.replace(/\//g, "_");
  let limite = parseInt(localStorage.getItem(storagePrefix + "_limite")) || 5;
  let paginaAtual = parseInt(localStorage.getItem(storagePrefix + "_pagina")) || 1;

  function carregarPagina(pagina) {
    fetch(`../../../app/models/produtos/painel/listar_produto_painel.php?pagina=${pagina}&limite=${limite}`)
      .then(res => res.json())
      .then(data => {
        if (data.html.trim() === "") {
          tabelaBody.innerHTML = `
        <div class="alert container p-4 rounded d-flex align-items-center justify-content-center bg-body-secondary text-center">
          <i class="bi bi-emoji-frown me-2"></i><span>Nenhum produto cadastrado.</span>
        </div>
      `;
        } else {
          tabelaBody.innerHTML = data.html;
        }

        paginaAtual = pagina;
        if (totalProdutos) totalProdutos.textContent = data.totalProdutos;
        localStorage.setItem(storagePrefix + "_pagina", paginaAtual);
        atualizarPaginacao(data.totalPaginas);
      });
  }

  function atualizarPaginacao(totalPaginas) {

    if (totalPaginas <= 5 || !totalPaginas) {
      paginacaoContainer.innerHTML = "";
      return;
    }

    let html = `
      <form method="get" class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2" onsubmit="return false;">
        <div>
          <label for="limite" class="form-label mb-0 me-2">Produtos por página:</label>
          <select id="limite" class="form-select form-select-sm d-inline-block w-auto">
            <option value="5" ${limite === 5 ? "selected" : ""}>5</option>
            <option value="10" ${limite === 10 ? "selected" : ""}>10</option>
            <option value="100" ${limite === 100 ? "selected" : ""}>100</option>
            <option value="1000" ${limite === 1000 ? "selected" : ""}>1000</option>
            <option value="5000" ${limite === 5000 ? "selected" : ""}>5000</option>
          </select>
        </div>
        <nav>
          <ul class="pagination mb-0">
    `;

    const maxLinks = 5;
    let start = Math.max(1, paginaAtual - Math.floor(maxLinks / 2));
    let end = Math.min(totalPaginas, start + maxLinks - 1);

    if (start > 1) {
      html += `<li class="page-item"><a class="page-link" href="#" data-pagina="1">1</a></li>`;
    }

    for (let i = start; i <= end; i++) {
      html += `
        <li class="page-item ${i === paginaAtual ? 'active' : ''}">
          <a class="page-link" href="#" data-pagina="${i}">${i}</a>
        </li>`;
    }

    if (end < totalPaginas) {
      html += `<li class="page-item"><a class="page-link" href="#" data-pagina="${totalPaginas}">${totalPaginas}</a></li>`;
    }

    html += `
          </ul>
        </nav>
      </form>
    `;

    paginacaoContainer.innerHTML = html;

    document.querySelectorAll(".pagination .page-link").forEach(link => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        const pagina = parseInt(link.dataset.pagina);
        if (!isNaN(pagina)) {
          carregarPagina(pagina);
        }
      });
    });

    document.getElementById("limite").addEventListener("change", (e) => {
      limite = parseInt(e.target.value);
      localStorage.setItem(storagePrefix + "_limite", limite);
      carregarPagina(1);
    });
  }

  carregarPagina(paginaAtual);
});
