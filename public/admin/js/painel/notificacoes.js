document.addEventListener("DOMContentLoaded", () => {
    const lista = document.getElementById('lista-notificacoes');
    
    function carregarNotificacoes() {
         lista.innerHTML = '<div class="text-center my-4"><div class="spinner-border text-warning" role="status"></div><p>Carregando notificações...</p></div>';

        fetch('/QuebraGalho/app/models/notificacoes/verificar_erros.php')
            .then(response => response.json())
            .then(notificacoes => {

                if (notificacoes.length === 0) {
                    lista.innerHTML = '<li class="list-group-item">Nenhuma notificação no momento.</li>';
                    return;
                }

                lista.innerHTML = notificacoes.html;

            })
            .catch(err => {
                console.error('Erro ao carregar notificações', err);
            });
    }

    carregarNotificacoes();
    setInterval(carregarNotificacoes, 60000);
});
