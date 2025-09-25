document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('modalAcesso');
    document.body.style.overflow = 'hidden';
    var modal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
    });

    modalEl.addEventListener('hidden.bs.modal', function () {
        document.body.style.overflow = '';
    });

    modal.show();
    const form = document.getElementById('form-acesso');
    const btn = document.getElementById('btn-acesso');
    const senhaInput = document.getElementById('senha');
    const erroDiv = document.getElementById('erro-senha');

    senhaInput.addEventListener('input', () => {
        btn.disabled = senhaInput.value.trim() === '';
        btn.classList.toggle('btn-secondary', senhaInput.value.trim() === '');
        btn.classList.toggle('btn-primary', senhaInput.value.trim() !== '');
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const senha = senhaInput.value.trim();

        fetch('../app/models/index/acesso.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ senha })
        })
            .then(res => res.json())
            .then(data => {
                if (data.sucesso) {
                    erroDiv.style.display = 'none';
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAcesso'));
                    if (modal) modal.hide();
                    location.reload();
                } else {
                    erroDiv.textContent = data.mensagem;
                    erroDiv.style.display = 'block';
                }
            })
            .catch(err => {
                erroDiv.textContent = "Erro de comunicação com o servidor.";
                erroDiv.style.display = 'block';
                console.error(err);
            });
    });
});
