document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formPerfil');
    const nomeInput = document.getElementById('nome');
    const emailInput = document.getElementById('email');
    const telefoneInput = document.getElementById('telefone');
    const dataNascimentoInput = document.getElementById('data_nascimento');
    const editarFotoInput = document.getElementById('editarFotoInput');
    const btnSalvar = document.getElementById('btnSalvar');

    editarFotoInput.addEventListener('change', () => {
        if (editarFotoInput.files && editarFotoInput.files[0]) {
            const formData = new FormData();
            formData.append('nova_foto', editarFotoInput.files[0]);

            fetch('../app/models/conta/account.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao enviar a imagem');
                    }
                })
                .catch(err => {
                    console.error('Erro no envio da imagem:', err);
                    alert('Erro inesperado ao enviar a imagem.');
                });
        }
    });


    if (!form || !nomeInput || !emailInput || !telefoneInput || !dataNascimentoInput || !btnSalvar) {
        console.error('Um ou mais elementos do formulário não foram encontrados.');
        return;
    }

    let valoresIniciais = {
        nome: nomeInput.value,
        email: emailInput.value,
        telefone: telefoneInput.value,
        dataNascimento: dataNascimentoInput.value
    };

    function validarNome() {
        return nomeInput.value.trim().length >= 3;
    }

    function validarEmail() {
        return emailInput.value.includes('@') && emailInput.value.length > 5;
    }

    function validarTelefone() {
        const telefoneLimpo = telefoneInput.value.replace(/\D/g, '');
        return telefoneLimpo.length > 10;
    }

    function validarData() {
        return dataNascimentoInput.value !== '';
    }

    function definirEstadoBotao(habilitar) {
        if (habilitar) {
            btnSalvar.classList.remove('btn-secondary');
            btnSalvar.classList.add('btn-success');
            btnSalvar.disabled = false;
        } else {
            btnSalvar.classList.add('btn-secondary');
            btnSalvar.classList.remove('btn-success');
            btnSalvar.disabled = true;
        }
    }

    function atualizarEstadoBotao() {
        const todosCamposValidos = validarTelefone() || validarData();
        const formularioModificado =
            nomeInput.value !== valoresIniciais.nome ||
            emailInput.value !== valoresIniciais.email ||
            telefoneInput.value !== valoresIniciais.telefone ||
            dataNascimentoInput.value !== valoresIniciais.dataNascimento;

        if (todosCamposValidos && formularioModificado && validarEmail() && validarNome()) {
            definirEstadoBotao(true);
        } else {
            definirEstadoBotao(false);
        }
    }

    async function handleFormSubmit(event) {
        event.preventDefault();

        btnSalvar.disabled = true;
        btnSalvar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...';

        try {
            const formData = new FormData(form);

            const response = await fetch("../app/models/conta/account.php", {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Erro do servidor.');
            }

            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: data.message,
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });

            valoresIniciais = {
                email: emailInput.value,
                telefone: telefoneInput.value,
                dataNascimento: dataNascimentoInput.value
            };

            definirEstadoBotao(false);

        } catch (error) {
            console.error('Erro ao salvar:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Não foi possível salvar as alterações: ' + error.message
            });
            definirEstadoBotao(true);
        } finally {
            btnSalvar.innerHTML = '<i class="bi bi-floppy-fill me-1"></i> Salvar';
        }
    }

    form.addEventListener('input', atualizarEstadoBotao);
    form.addEventListener('submit', handleFormSubmit);
    definirEstadoBotao(false);
});
