document.addEventListener('DOMContentLoaded', function () {
  const checkboxMercadoLivre = document.getElementById('switchMercadoLivre');
  const container = document.getElementById('produtos');

  const marcado = localStorage.getItem('mercadoLivreChecked') === 'true';
  checkboxMercadoLivre.checked = marcado;

  if (marcado) {
    container.classList.remove('d-none');
    carregarProdutos();
  } else {
    container.classList.add('d-none');
    container.innerHTML = '';
  }

  checkboxMercadoLivre.addEventListener('change', function () {
    localStorage.setItem('mercadoLivreChecked', this.checked);

    if (this.checked) {
      container.classList.remove('d-none');
      carregarProdutos();
    } else {
      container.classList.add('d-none');
      container.innerHTML = '';
    }
  });

  function carregarProdutos() {
    container.innerHTML = '<div class="text-center my-4"><div class="spinner-border text-warning" role="status"></div><p>Carregando produtos...</p></div>';

    fetch('../../../app/models/marketplace/produtos_ml.php')
      .then(response => response.text())
      .then(data => {
        container.innerHTML = data;
        fetch('../../../app/models/marketplace/atualizar_produtos_ml.php')
          .then(() => fetch('../../../app/models/marketplace/produtos_ml.php'))
          .then(response => response.text())
          .then(dataAtualizado => {
            container.innerHTML = dataAtualizado;
          });
      })
      .catch(error => {
        console.error('Erro ao carregar os produtos:', error);
        container.innerHTML = '<div class="alert alert-danger">Erro ao carregar produtos do Mercado Livre.</div>';
      });
  }
});
