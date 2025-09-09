document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-configuracoes');

    document.getElementById('btn-salvar-config').addEventListener('click', () => {
        const formData = new FormData(form);

        fetch('../../../app/models/configuracoes/painel/edit_config_painel.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Sucesso', 'Configurações salvas com sucesso!', 'success');
                } else {
                    Swal.fire('Erro', data.message || 'Não foi possível salvar', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Erro', 'Ocorreu um erro inesperado', 'error');
            });
    });
});
