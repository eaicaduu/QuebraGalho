document.addEventListener("DOMContentLoaded", () => {
  const checkboxes = document.querySelectorAll(".seletor-produto");
  const selecionarTodos = document.getElementById("selecionarTodos");
  const totalSelecionadoSpan = document.getElementById("totalSelecionado");
  const totalFinal = document.getElementById("totalFinal");
  const btnFinalizar = document.getElementById("btnFinalizar");

  function atualizarTotal() {
    let total = 0;
    checkboxes.forEach(cb => {
      if (cb.checked) {
        const item = cb.closest(".item-carrinho");
        total += parseFloat(item.getAttribute("data-subtotal"));
      }
    });

    const totalFormatado = `R$ ${total.toFixed(2).replace(".", ",")}`;
    totalSelecionadoSpan.textContent = totalFormatado;
    totalFinal.textContent = totalFormatado;
    btnFinalizar.disabled = total === 0;
  }

  checkboxes.forEach(cb => {
    cb.addEventListener("change", () => {
      const todosMarcados = [...checkboxes].every(c => c.checked);
      selecionarTodos.checked = todosMarcados;
      atualizarTotal();
    });
  });
  if (selecionarTodos) {
    selecionarTodos.addEventListener("change", () => {
      checkboxes.forEach(cb => cb.checked = selecionarTodos.checked);
      atualizarTotal();
    });
  } else {
    return;
  }

  atualizarTotal();
});