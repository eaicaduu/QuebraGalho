document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('btnPesquisar').addEventListener('click', function () {
        Swal.fire({
            title: 'Pesquisar Produto',
            text: 'Insira o link do produto',
            input: 'text',
            inputPlaceholder: 'https://...',
            showCancelButton: true,
            confirmButtonText: 'Buscar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Por favor, insira o link do produto!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let url = result.value;
                let match = url.match(/(MLB[0-9]+)/i);
                if (!match) {
                    Swal.fire('Erro', 'Link inválido para Mercado Livre!', 'error');
                    return;
                }
                let productId = match[1];

                fetch(`https://api.mercadolibre.com/items/${productId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Erro ao buscar produto');
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            title: data.title,
                            html: `
                                <img src="${data.thumbnail}" style="max-height:150px; margin-bottom:10px;">
                                <p><b>Preço:</b> R$ ${data.price}</p>
                                <p><b>Condição:</b> ${data.condition}</p>
                                <p><b>Estoque disponível:</b> ${data.available_quantity}</p>
                            `,
                            confirmButtonText: 'OK'
                        });
                    })
                    .catch(error => {
                        Swal.fire('Erro', 'Não foi possível buscar as informações do produto.', 'error');
                        console.error(error);
                    });
            }
        });
    });
});