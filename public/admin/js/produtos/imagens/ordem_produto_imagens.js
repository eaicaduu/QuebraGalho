document.addEventListener('DOMContentLoaded', () => {
    const containers = document.querySelectorAll('.midias-secundarias');

    containers.forEach(container => {
        new Sortable(container, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: async (evt) => {
                const produtoId = container.id.replace('midias-produto-', '');
                const ordem = Array.from(container.querySelectorAll('[data-id]'))
                    .map(div => div.dataset.id);

                if (ordem.length === 0) return;

                try {
                    const formData = new FormData();
                    formData.append('produto_id', produtoId);
                    formData.append('ordem', JSON.stringify(ordem));

                    const res = await fetch('../../../app/models/produtos/imagens/ordem_produto_imagens.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await res.json();
                    if (!data.success) {
                        alert('Erro ao salvar a ordem das mídias.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Erro na requisição AJAX.');
                }
            }
        });
    });
});
