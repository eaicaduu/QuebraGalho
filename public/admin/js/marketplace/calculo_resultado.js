document.addEventListener("DOMContentLoaded", () => {
  const btnaAdicionarProduto = document.getElementById('btnAdicionarProduto');
  const resultadoContainer = document.getElementById('resultadoProduto');
  const modalAdicionarEl = document.getElementById('modalAdicionar');
  const modalAdicionar = new bootstrap.Modal(modalAdicionarEl);
  const modalCalculoEl = document.getElementById('modalCalculo');
  const modalCalculo = new bootstrap.Modal(modalCalculoEl);

  fetch('../../../app/models/marketplace/obter_calculo.php')
    .then(response => response.json())
    .then(dados => {
      if (!dados || Object.keys(dados).length === 0) {
        resultadoContainer.innerHTML = `
      <div class="alert alert-warning d-flex justify-content-center align-items-center">
        Nenhuma simulação de cálculo cadastrada.
      </div>`;
      } else {
        const responsiveDiv = document.createElement('div');
        responsiveDiv.className = 'table-responsive';

        const table = document.createElement('table');
        table.className = 'table table-bordered table-striped table-hover text-center';

        const thead = document.createElement('thead');
        const tbody = document.createElement('tbody');

        const campos = Object.keys(dados);
        campos.push('lucro');

        const headerRow = document.createElement('tr');
        campos.forEach(campo => {
          const th = document.createElement('th');
          th.textContent = campo.replace(/_/g, ' ').toUpperCase();
          headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);

        const dataRow = document.createElement('tr');
        campos.forEach(campo => {
          const td = document.createElement('td');

          if (campo === 'lucro') {
            const vendaProduto = parseFloat(dados.venda || 0);
            const imposto = parseFloat(dados.imposto || 0);
            const comissaoMK = parseFloat(dados.comissao_mk || 0);
            const custoMK = parseFloat(dados.custo_marketplace || 0);
            const custoEmb = parseFloat(dados.custo_embalagem || 0);
            const custoProd = parseFloat(dados.custo_produto || 0);

            const valorSemImposto = vendaProduto * (imposto / 100);
            const valorSemMarketplace = vendaProduto * (comissaoMK / 100);

            const lucro = vendaProduto
              - valorSemImposto
              - valorSemMarketplace
              - custoMK
              - custoEmb
              - custoProd;

            td.textContent = lucro.toFixed(2);
            td.style.fontWeight = 'bold';
            td.style.color = lucro >= 0 ? 'green' : 'red';
          } else {
            if (['comissao_mk', 'imposto'].includes(campo)) {
              td.textContent = `${dados[campo]}%`;
            } else {
              td.textContent = dados[campo];
            }
          }

          dataRow.appendChild(td);
        });
        tbody.appendChild(dataRow);

        table.appendChild(thead);
        table.appendChild(tbody);
        responsiveDiv.appendChild(table);
        resultadoContainer.innerHTML = '';
        resultadoContainer.appendChild(responsiveDiv);
      }
    })
    .catch(error => {
      console.error('Erro ao buscar os dados:', error);
      resultadoContainer.innerHTML = `
        <div class="alert alert-danger">Erro ao carregar os dados.</div>`;
    });

  btnaAdicionarProduto.addEventListener('click', () => {
    modalCalculo.hide();
    modalAdicionar.show();
  });
});
