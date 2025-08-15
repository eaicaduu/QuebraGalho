document.addEventListener('DOMContentLoaded', () => {
    const plataformas = ['ecommerce', 'mercado_livre', 'shopee', 'amazon'];
    const pedidosContainer = document.getElementById('pedidosContainer');
    const MENSAGEM_ID = 'mensagem-sem-pedidos';

    function criarLoading() {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.style.cssText = `
            position: absolute; inset: 0; background-color: rgba(255,255,255,0.6);
            display: flex; justify-content: center; align-items: center; z-index: 10;
        `;
        const spinner = document.createElement('div');
        spinner.className = 'spinner-border text-primary';
        spinner.setAttribute('role', 'status');
        overlay.appendChild(spinner);
        pedidosContainer.style.position = 'relative';
        pedidosContainer.appendChild(overlay);
        return overlay;
    }

    function formatarData(dataISO) {
        if (!dataISO) return '';
        const data = new Date(dataISO);
        return data.toLocaleDateString('pt-BR', { day: 'numeric', month: 'short' }) + ' ' +
               data.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' }) + ' hs';
    }

    function carregarPedidos(plataforma) {
        return fetch(`../../../app/models/pedidos/pedidos.php?plataforma=${plataforma}`)
            .then(res => res.json())
            .then(pedidos => {
                if (!Array.isArray(pedidos)) return;

                const abreviacoes = {
                    'mercado_livre': 'ML',
                    'ecommerce': 'EC',
                    'amazon': 'AZ',
                    'shopee': 'SH'
                };

                pedidos.forEach(pedido => {
                    const card = document.createElement('div');
                    card.className = 'card shadow-sm mb-2';
                    card.setAttribute('data-plataforma', plataforma);

                    const abreviacao = abreviacoes[plataforma] || plataforma.charAt(0).toUpperCase();

                    const badgeClass = {
                        'mercado_livre': 'bg-warning text-dark',
                        'shopee': 'bg-danger text-white',
                        'amazon': 'bg-primary text-white',
                        'ecommerce': 'bg-secondary text-white'
                    }[plataforma] || 'bg-dark text-white';

                    card.innerHTML = `
                    <div class="card-header bg-white p-2">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-pill ${badgeClass}">${abreviacao}</span>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 fw-bold small">#${pedido.id_completo || pedido.id}</h6>
                                    <small class="text-muted ms-4">${formatarData(pedido.data_pedido)}</small>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="fw-bold small">${pedido.cliente}</span>
                            </div>
                            <div class="text-end">
                                <p class="mb-0 small"><span class="fw-bold">Valor:</span> R$ ${parseFloat(pedido.valor_total).toFixed(2).replace('.', ',')} (${pedido.quantidade} un)</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="mb-1 small"><span class="fw-bold">Produto:</span> ${pedido.produto_nome}</p>
                                <p class="mb-1 small"><span class="fw-bold">SKU:</span> ${pedido.sku || 'N/A'}</p>
                            </div>
                            <div>
                                <h6 class="mb-1 small">Entregar até o dia ${pedido.data_envio || 'N/A'}</h6>
                                <p class="text-muted small mb-0">Isso não afeta a sua reputação.</p>
                            </div>
                            <button class="btn btn-sm btn-primary">Imprimir</button>
                        </div>
                    </div>
                    `;
                    pedidosContainer.appendChild(card);
                });
            })
            .catch(e => {
                pedidosContainer.innerHTML += `<div class="alert alert-danger small">Erro ao carregar ${plataforma}: ${e.message}</div>`;
            });
    }

    function verificarTabelaVazia() {
        document.getElementById(MENSAGEM_ID)?.remove();
        pedidosContainer.style.display = "";

        if (pedidosContainer.children.length === 0) {
            pedidosContainer.style.display = "none";
            const divMensagem = document.createElement('div');
            divMensagem.id = MENSAGEM_ID;
            divMensagem.className = 'alert container d-flex align-items-center justify-content-center bg-body-secondary text-center';
            divMensagem.innerHTML = `<i class="bi bi-emoji-frown me-2"></i><span>Nenhum pedido encontrado</span>`;
            pedidosContainer.parentNode.insertBefore(divMensagem, pedidosContainer.nextSibling);
        }
    }

    function atualizarPedidos() {
        pedidosContainer.innerHTML = ''; 
        const overlay = criarLoading(); 

        const promises = plataformas.map(plataforma => {
            const cb = document.getElementById(plataforma);
            if (cb && cb.checked) {
                return carregarPedidos(plataforma);
            } else {
                return Promise.resolve();
            }
        });

        Promise.allSettled(promises).then(() => {
            overlay.remove();
            verificarTabelaVazia();
        });
    }

    plataformas.forEach(plataforma => {
        const checkbox = document.getElementById(plataforma);
        if (checkbox) {
            checkbox.addEventListener('change', () => {
                atualizarPedidos();
            });
        }
    });

    atualizarPedidos();
});
