document.addEventListener("DOMContentLoaded", () => {
    const pedidosContainer = document.getElementById("pedidos-body");
    const filtroSelect = document.getElementById("filtroPedidos");
    const totalPedidosSpan = document.getElementById("totalPedidos");
    const loadingPedidos = document.getElementById("loadingPedidos");

    let atualizarInterval = null;

    async function carregarPedidos() {
        try {
            loadingPedidos.classList.remove("d-none");

            let url = `../../../app/models/pedidos/listar_pedidos.php`;
            let filtroData = null;
            const hoje = new Date();
            if (filtroSelect.value === "hoje") {
                filtroData = hoje.toISOString().split("T")[0];
            } else if (filtroSelect.value === "amanha") {
                const amanha = new Date();
                amanha.setDate(hoje.getDate() + 1);
                filtroData = amanha.toISOString().split("T")[0];
            }

            if (filtroData) {
                url += `?data=${filtroData}`;
            }

            const response = await fetch(url);
            const result = await response.json();

            pedidosContainer.innerHTML = result.html;
            totalPedidosSpan.textContent = `Total Pedidos: ${result.totalPedidos}`;
        } catch (error) {
            console.error("Erro ao carregar pedidos:", error);
            pedidosContainer.innerHTML = "<p class='text-danger'>Erro ao carregar pedidos.</p>";
            totalPedidosSpan.textContent = "";
        } finally {
            loadingPedidos.classList.add("d-none");
        }
    }

    async function atualizarPedidos() {
        try {
            loadingPedidos.classList.remove("d-none");

            const response = await fetch('../../../app/models/pedidos/atualizar_pedidos.php');
            const result = await response.json();
            console.log(result);

            if (result.success) {
                carregarPedidos();
            } else {
                console.error("Erro backend:", result.error);
            }
        } catch (error) {
            console.error("Erro ao atualizar:", error);
        } finally {
            loadingPedidos.classList.add("d-none");
        }
    }

    filtroSelect.addEventListener("change", () => {
        carregarPedidos();
    });

    carregarPedidos();
    setTimeout(() => {
        atualizarPedidos();
    }, 1000);
});
