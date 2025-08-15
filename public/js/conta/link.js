document.addEventListener("DOMContentLoaded", () => {
    const linksAccount = document.querySelectorAll(".js-account");
    linksAccount.forEach(link => {
        link.addEventListener("click", (event) => {
            if (typeof isLoggedIn !== "undefined" && isLoggedIn) {
                window.location.href = "account.php";
            } else {
                window.location.href = "login.php";
            }
        });
    });

});