document.addEventListener('DOMContentLoaded', () => {
    const originalNome = userData.nome.trim();
    const originalEmail = userData.email.trim();

    const nomeInput = document.getElementById('nome');
    const emailInput = document.getElementById('email');
    const novaSenhaInput = document.getElementById('nova_senha');
    const confirmarSenhaInput = document.getElementById('confirmar_senha');
    const btnSalvar = document.getElementById('btnSalvar');

    function verificarAlteracoes() {
        const nomeAlterado = nomeInput.value.trim() !== originalNome;
        const emailAlterado = emailInput.value.trim() !== originalEmail;

        const novaSenha = novaSenhaInput.value.trim();
        const confirmarSenha = confirmarSenhaInput.value.trim();

        const senhaPreenchida = novaSenha !== '' || confirmarSenha !== '';

        let senhaValida = true;

        if (senhaPreenchida) {
            if (novaSenha.length < 6) {
                senhaValida = false;
            }
            if (novaSenha !== confirmarSenha) {
                senhaValida = false;
            }
        }

        if ((nomeAlterado || emailAlterado || senhaPreenchida) && senhaValida) {
            btnSalvar.disabled = false;
            btnSalvar.classList.remove('btn-secondary');
            btnSalvar.classList.add('btn-success');
        } else {
            btnSalvar.disabled = true;
            btnSalvar.classList.remove('btn-success');
            btnSalvar.classList.add('btn-secondary');
        }
    }

    [nomeInput, emailInput, novaSenhaInput, confirmarSenhaInput].forEach(input => {
        input.addEventListener('input', verificarAlteracoes);
    });


    document.getElementById('formAccount').addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Confirmação de senha',
            input: 'password',
            inputLabel: 'Digite sua senha atual:',
            inputPlaceholder: 'Senha atual',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            confirmButtonColor: '#6c757d',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Você precisa informar sua senha!';
                }
            },
            didOpen: () => {
                const input = Swal.getInput();
                const confirmButton = Swal.getConfirmButton();

                input.addEventListener('input', () => {
                    if (input.value.length >= 6) {
                        confirmButton.style.backgroundColor = '#28a745';
                    } else {
                        confirmButton.style.backgroundColor = '#6c757d';
                    }
                });
            }
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            const senhaAtual = result.value;

            const formData = new FormData(document.getElementById('formAccount'));
            formData.append('senha_atual', senhaAtual);

            fetch('../app/models/account.php', {
                    method: 'POST',
                    body: formData
                })
                .then(resp => resp.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Sucesso!', 'Informações atualizadas com sucesso!', 'success').then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Erro', data.error, 'error');
                        resetarFormulario();
                    }
                })
                .catch(err => {
                    Swal.fire('Erro na requisição.', '', 'error');
                    resetarFormulario();
                });
        });

        function resetarFormulario() {
            nomeInput.value = originalNome;
            emailInput.value = originalEmail;
            novaSenhaInput.value = '';
            confirmarSenhaInput.value = '';
            verificarAlteracoes();
        }
    });

});