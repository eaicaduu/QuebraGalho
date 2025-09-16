document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('produtos');
    const totalCadastrados = document.getElementById('totalCadastrados');

    const produtosMercadoLivre = localStorage.getItem('mercadoLivreChecked') === 'true';

    if (produtosMercadoLivre) {
        container.classList.remove('d-none');
        carregarProdutos();
    } else {
        container.classList.add('d-none');
        container.innerHTML = '';
    }

    function carregarProdutos() {
        container.innerHTML = '<div class="text-center my-4"><div class="spinner-border text-warning" role="status"></div><p>Carregando produtos...</p></div>';

        fetch('../../../app/models/marketplace/mercadolivre/produto_ml.php')
            .then(response => response.json())
            .then(data => {
                container.innerHTML = data.html;
                totalCadastrados.textContent = data.total;

                fetch('../../../app/models/marketplace/mercadolivre/atualizar_produto_ml.php')
                    .then(() => fetch('../../../app/models/marketplace/mercadolivre/produto_ml.php'))
                    .then(response => response.json())
                    .then(data => {
                        container.innerHTML = data.html;
                        totalCadastrados.textContent = data.total;
                    });
            })
            .catch(error => {
                console.error('Erro ao carregar os produtos:', error);
                container.innerHTML = '<div class="alert alert-danger">Erro ao carregar produtos do Mercado Livre.</div>';
                totalCadastrados.textContent = '0';
            });
    }
});
