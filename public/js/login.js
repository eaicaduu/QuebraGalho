document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  const cpfInput = document.getElementById("cpf");
  const passwordInput = document.getElementById("senha");
  const submitButton = document.getElementById("submitButton");
  const cadastroLink = document.getElementById("cadastroLink");
  const alertBox = document.createElement("div");
  const togglePassword = document.getElementById("toggle-password");

  togglePassword.addEventListener("click", () => {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      togglePassword.classList.remove("bi-eye");
      togglePassword.classList.add("bi-eye-slash");
    } else {
      passwordInput.type = "password";
      togglePassword.classList.remove("bi-eye-slash");
      togglePassword.classList.add("bi-eye");
    }
  });

  alertBox.style.cssText = `
        display: none;
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px 20px;
        background-color: #dc3545;
        color: white;
        border-radius: 5px;
        z-index: 9999;
        font-weight: bold;
    `;
  document.body.appendChild(alertBox);

  const urlParams = new URLSearchParams(window.location.search);
  const erro = urlParams.get("erro");

  if (erro === "cpf" || erro === "senha") {
    cpfInput.value = "";
    passwordInput.value = "";
    const url = new URL(window.location);
    url.searchParams.delete("erro");
    window.history.replaceState({}, document.title, url.pathname + url.search);
    localStorage.removeItem("savedEmail");
    localStorage.removeItem("savedSenha");
  } else {
    if (localStorage.getItem("savedEmail")) {
      cpfInput.value = localStorage.getItem("savedEmail");
    }

    if (localStorage.getItem("savedSenha")) {
      passwordInput.value = localStorage.getItem("savedSenha");
    }
  }

  if (document.referrer.includes("cadastro.php")) {
    cadastroLink.style.display = "none";
  }

  cpfInput.addEventListener("input", () => {
    cpfInput.value = formatarCPF(cpfInput.value);
    localStorage.setItem("savedEmail", cpfInput.value);
    validarCampos();
  });

  passwordInput.addEventListener("input", () => {
    localStorage.setItem("savedSenha", passwordInput.value);
    validarCampos();
  });

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (!validarCampos()) {
      return;
    }

    submitButton.disabled = true;

    const formData = new FormData(form);

    try {
      const response = await fetch("../app/models/login.php", {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (data.success) {
        localStorage.removeItem("savedEmail");
        localStorage.removeItem("savedSenha");
        if (data.admin) {
          window.location.href = "./admin/painel.php";
        } else {
          window.location.href = "./index.php";
        }
      } else {
        if (data.error === "cpf") {
          showAlert("CPF não encontrado.");
        } else if (data.error === "senha") {
          showAlert("Senha incorreta.");
        } else {
          showAlert("Erro desconhecido. Tente novamente.");
        }
        cpfInput.value = "";
        passwordInput.value = "";
        localStorage.removeItem("savedEmail");
        localStorage.removeItem("savedSenha");
        cpfInput.focus();
        validarCampos();
      }
    } catch (err) {
      showAlert("Erro na conexão. Tente novamente.");
    }
  });

  function validarCampos() {
    let valid = true;

    const cpfLimpo = cpfInput.value.replace(/\D/g, "");

    if (cpfLimpo === "" || cpfLimpo.length !== 11) {
      valid = false;
    }

    if (passwordInput.value.trim() === "" || passwordInput.value.length < 6) {
      valid = false;
    }

    if (valid) {
      submitButton.disabled = false;
      submitButton.classList.remove("btn-secondary");
      submitButton.classList.add("btn-warning");
    } else {
      submitButton.disabled = true;
      submitButton.classList.remove("btn-warning");
      submitButton.classList.add("btn-secondary");
    }

    return valid;
  }

  function showAlert(message) {
    alertBox.textContent = message;
    alertBox.style.display = "block";
    alertBox.style.opacity = "1";

    setTimeout(() => {
      let fadeEffect = setInterval(() => {
        if (!alertBox.style.opacity) {
          alertBox.style.opacity = "1";
        }
        if (alertBox.style.opacity > 0) {
          alertBox.style.opacity -= 0.1;
        } else {
          clearInterval(fadeEffect);
          alertBox.style.display = "none";
        }
      }, 50);
    }, 3000);
  }

  function formatarCPF(cpf) {
    cpf = cpf.replace(/\D/g, "");
    cpf = cpf.substring(0, 11);

    if (cpf.length > 9) {
      return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, "$1.$2.$3-$4");
    } else if (cpf.length > 6) {
      return cpf.replace(/(\d{3})(\d{3})(\d{0,3})/, "$1.$2.$3");
    } else if (cpf.length > 3) {
      return cpf.replace(/(\d{3})(\d{0,3})/, "$1.$2");
    } else {
      return cpf;
    }
  }

  validarCampos();
});
