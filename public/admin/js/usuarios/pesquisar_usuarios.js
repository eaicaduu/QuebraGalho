document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchUsuario");

    searchInput.addEventListener("input", function () {
        const termo = this.value.toLowerCase();
        const cards = document.querySelectorAll(".usuario-card");

        let encontrou = false;

        cards.forEach((card) => {
            const texto = card.innerText.toLowerCase();
            const visivel = texto.includes(termo);
            card.style.display = visivel ? "" : "none";
            if (visivel) encontrou = true;
        });

        const mensagemNenhum = document.getElementById("linha-nenhum-usuario");
        if (mensagemNenhum) {
            mensagemNenhum.style.display = encontrou ? "none" : "block";
        }
    });
});
