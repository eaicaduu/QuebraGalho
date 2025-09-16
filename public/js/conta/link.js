document.addEventListener("DOMContentLoaded", () => {
    const linksAccount = document.querySelectorAll(".js-account");
    const linksLogin = document.querySelectorAll(".js-login");
    const linksCadastro = document.querySelectorAll(".js-cadastro");
    linksAccount.forEach(link => {
        link.addEventListener("click", (event) => {
            if (typeof isLoggedIn !== "undefined" && isLoggedIn) {
                window.location.href = "account.php";
            } else {
                window.location.href = "login.php";
            }
        });
    });

    linksLogin.forEach(link => {
        link.addEventListener("click", () => {
            window.location.href = "login.php";
        });
    });

    linksCadastro.forEach(link => {
        link.addEventListener("click", () => {
            window.location.href = "cadastro.php";
        });
    });
});