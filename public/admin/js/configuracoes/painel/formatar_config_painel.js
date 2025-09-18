const telefones = document.querySelectorAll('.telefone');

function mascaraTelefone(event) {
    let input = event.target;
    let numero = input.value.replace(/\D/g, '');

    if (numero.length > 11) numero = numero.slice(0, 11);

    if (numero.length === 11) {
        input.value = `(${numero.substring(0, 2)})${numero.substring(2, 3)} ${numero.substring(3, 7)}-${numero.substring(7, 11)}`;
    } else {
        input.value = numero;
    }
}

telefones.forEach(input => {
    input.addEventListener('input', mascaraTelefone);
});

document.addEventListener('DOMContentLoaded', function () {
    const btnSalvar = document.getElementById('btn-salvar-config');
    const form = document.getElementById('form-configuracoes');

    const valoresIniciais = {};
    form.querySelectorAll('input, textarea').forEach(input => {
        valoresIniciais[input.name] = input.value;
    });

    function verificarMudancas() {
        let mudou = false;
        form.querySelectorAll('input, textarea').forEach(input => {
            if (input.value !== valoresIniciais[input.name]) {
                mudou = true;
            }
        });

        if (mudou) {
            btnSalvar.classList.remove('btn-secondary');
            btnSalvar.classList.add('btn-success');
            btnSalvar.disabled = false;
        } else {
            btnSalvar.classList.remove('btn-success');
            btnSalvar.classList.add('btn-secondary');
            btnSalvar.disabled = true;
        }
    }

    form.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('input', verificarMudancas);
    });

    btnSalvar.classList.add('btn-secondary');
});