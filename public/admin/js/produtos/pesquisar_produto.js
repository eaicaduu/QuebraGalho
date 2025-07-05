document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchProduto");

  const input = document.getElementById("searchProduto");
  input.addEventListener(
    "input",
    debounce(function () {
      const query = this.value.trim();
      fetch(`buscar_produtos.php?q=${encodeURIComponent(query)}`)
        .then((res) => res.json())
        .then((data) => {});
    }, 300)
  );

  function debounce(func, delay) {
    let timer;
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(() => func.apply(this, args), delay);
    };
  }
});
