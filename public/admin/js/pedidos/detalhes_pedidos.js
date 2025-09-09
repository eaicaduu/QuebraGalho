document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".ver-detalhes").forEach(btn => {
        btn.addEventListener("click", () => {
            const pedido = JSON.parse(btn.dataset.pedido);

            Swal.fire({
                title: `Pedido #${pedido.order_id}`,
                html: `
                    <p><strong>Plataforma:</strong> ${pedido.plataforma}</p>
                    <p><strong>Cliente:</strong> ${pedido.cliente}</p>
                    <p><strong>Status:</strong> ${pedido.status}</p>
                    <p><strong>Produto:</strong> ${pedido.produto_nome}</p>
                    <p><strong>Quantidade:</strong> ${pedido.quantidade}</p>
                    <p><strong>Unitário:</strong> R$ ${parseFloat(pedido.valor_unitario).toFixed(2)}</p>
                    <p><strong>Total:</strong> R$ ${parseFloat(pedido.valor_total).toFixed(2)}</p>
                    <p><strong>Endereço:</strong> ${pedido.endereco ?? '-'}, ${pedido.cidade ?? '-'}, ${pedido.estado ?? '-'} - ${pedido.cep ?? '-'}</p>
                    <p><strong>Pedido:</strong> ${pedido.data_pedido ?? '-'}</p>
                    <p><strong>Entrega:</strong> ${pedido.data_entrega ?? '-'}</p>
                    <hr>
                    <a href="../../../app/models/pedidos/emitir_nfc-e.php?identificador_envio=${encodeURIComponent(pedido.identificador_envio)}&plataforma=${encodeURIComponent(pedido.plataforma)}" target="_blank" class="btn btn-sm btn-primary me-2">Emitir NFC-e</a>
                    <a href="../../../app/models/pedidos/emitir_etiqueta.php?identificador_envio=${encodeURIComponent(pedido.identificador_envio)}&plataforma=${encodeURIComponent(pedido.plataforma)}" target="_blank" class="btn btn-sm btn-success">Imprimir Etiqueta</a>
                `,
                width: 600,
                showCloseButton: true,
                showConfirmButton: false
            });
        });
    });
});
