document.addEventListener("DOMContentLoaded", () => {
  const tabelaBody = document.getElementById("produtos-body");

  function formatarPrecoBR(input) {
    let valor = input.value.replace(/[^\d]/g, "");
    if (!valor) {
      input.value = "";
      return;
    }
    valor = (parseInt(valor, 10) / 100).toFixed(2);
    let partes = valor.split(".");
    partes[0] = partes[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    input.value = "R$" + partes.join(",");
  }

  function formatarPorcentagem(input, evento) {
    let valor = input.value.replace(/[^\d]/g, "");

    if (valor === "") {
      input.value = "";
      return;
    }

    let numero = parseInt(valor, 10);
    numero = Math.max(0, Math.min(100, numero));

    if (evento === "blur") {
      input.value = numero + "%";
    } else {
      input.value = numero;
    }
  }


  tabelaBody.addEventListener("input", (e) => {
    if (e.target.classList.contains("preco-produto") || e.target.classList.contains("preco-promocional")) {
      formatarPrecoBR(e.target);
    }
    if (e.target.classList.contains("desconto-percentual")) {
      formatarPorcentagem(e.target, "input");
    }
  });


  tabelaBody.addEventListener("blur", (e) => {
    if (e.target.classList.contains("desconto-percentual")) {
      formatarPorcentagem(e.target, "blur");
    }
  }, true);


  tabelaBody.querySelectorAll(".preco-produto").forEach(input => {
    if (input.value) formatarPrecoBR(input);
  });

  tabelaBody.querySelectorAll(".preco-promocional").forEach(input => {
    if (input.value) formatarPrecoBR(input);
  });

  tabelaBody.querySelectorAll(".desconto-percentual").forEach(input => {
    if (input.value) formatarPorcentagem(input);
  });

});
