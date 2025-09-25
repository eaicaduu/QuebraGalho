document.addEventListener('DOMContentLoaded', function () {
    const btnSalvar = document.getElementById('btn-salvar-config');
    const modoSwitch = document.getElementById('modoSiteSwitch');

    let valorInicial = modoSwitch.checked ? 1 : 0;

    function verificarMudancas() {
        let valorAtual = modoSwitch.checked ? 1 : 0;
        if (valorAtual !== valorInicial) {
            btnSalvar.classList.remove('btn-secondary');
            btnSalvar.classList.add('btn-success');
            btnSalvar.disabled = false;
        } else {
            btnSalvar.classList.remove('btn-success');
            btnSalvar.classList.add('btn-secondary');
            btnSalvar.disabled = true;
        }
    }

    modoSwitch.addEventListener('change', verificarMudancas);

    btnSalvar.addEventListener('click', function () {
        let novoValor = modoSwitch.checked ? 1 : 0;

        fetch('../../../app/models/configuracoes/outros/modo_site_config.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ modo_site: novoValor })
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                valorInicial = novoValor;
                btnSalvar.classList.remove('btn-success');
                btnSalvar.classList.add('btn-secondary');
                btnSalvar.disabled = true;
            } else {
                alert('Erro ao salvar configuração: ' + data.mensagem);
            }
        })
        .catch(error => {
            alert('Erro de comunicação com o servidor.');
            console.error(error);
        });
    });
});
