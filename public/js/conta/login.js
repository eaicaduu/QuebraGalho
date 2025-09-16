document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  const documentoInput = document.getElementById("documento");
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

  if (erro === "documento" || erro === "senha") {
    documentoInput.value = "";
    passwordInput.value = "";
    const url = new URL(window.location);
    url.searchParams.delete("erro");
    window.history.replaceState({}, document.title, url.pathname + url.search);
    localStorage.removeItem("savedDocumento");
    localStorage.removeItem("savedSenha");
  } else {
    if (localStorage.getItem("savedDocumento")) {
      documentoInput.value = localStorage.getItem("savedDocumento");
    }

    if (localStorage.getItem("savedSenha")) {
      passwordInput.value = localStorage.getItem("savedSenha");
    }
  }

  if (document.referrer.includes("cadastro.php")) {
    cadastroLink.style.display = "none";
  }

  documentoInput.addEventListener("input", () => {
    documentoInput.value = formatarDocumento(documentoInput.value);
    localStorage.setItem("savedDocumento", documentoInput.value);
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
      const response = await fetch("../app/models/conta/login.php", {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (data.success) {
        localStorage.removeItem("savedDocumento");
        localStorage.removeItem("savedSenha");
        if (data.admin) {
          window.location.href = "./admin/admin_painel.php?refresh=" + new Date().getTime();
        } else {
          const paginaAnterior = sessionStorage.getItem("paginaAnterior");
          sessionStorage.removeItem("paginaAnterior");
          if (paginaAnterior) {
            window.location.href = paginaAnterior + (paginaAnterior.includes("?") ? "&" : "?") + "refresh=" + new Date().getTime();
          } else {
            window.location.href = "index.php?refresh=" + new Date().getTime();
          }
        }
      } else {
        if (data.error === "documento") {
          showAlert("CPF ou CNPJ não encontrado.");
        } else if (data.error === "senha") {
          showAlert("Senha incorreta.");
        } else {
          showAlert("Erro desconhecido. Tente novamente.");
        }
        documentoInput.value = "";
        passwordInput.value = "";
        localStorage.removeItem("savedDocumento");
        localStorage.removeItem("savedSenha");
        documentoInput.focus();
        validarCampos();
      }
    } catch (err) {
      console.log(err);
      showAlert("Erro na conexão. Tente novamente.");
    }
  });

  function validarCampos() {
    let valid = true;

    const docLimpo = documentoInput.value.replace(/\D/g, "");

    const docValido =
      (docLimpo.length === 11 && validarCPF(docLimpo)) ||
      (docLimpo.length === 14 && validarCNPJ(docLimpo));

    if (!docValido) {
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

  function formatarDocumento(valor) {
    let doc = valor.replace(/\D/g, "");

    if (doc.length <= 11) {
      doc = doc.substring(0, 11);
      if (doc.length > 9) {
        return doc.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, "$1.$2.$3-$4");
      } else if (doc.length > 6) {
        return doc.replace(/(\d{3})(\d{3})(\d{0,3})/, "$1.$2.$3");
      } else if (doc.length > 3) {
        return doc.replace(/(\d{3})(\d{0,3})/, "$1.$2");
      } else {
        return doc;
      }
    } else {
      doc = doc.substring(0, 14);
      if (doc.length > 12) {
        return doc.replace(
          /(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/,
          "$1.$2.$3/$4-$5"
        );
      } else if (doc.length > 8) {
        return doc.replace(/(\d{2})(\d{3})(\d{3})(\d{0,4})/, "$1.$2.$3/$4");
      } else if (doc.length > 5) {
        return doc.replace(/(\d{2})(\d{3})(\d{0,3})/, "$1.$2.$3");
      } else if (doc.length > 2) {
        return doc.replace(/(\d{2})(\d{0,3})/, "$1.$2");
      } else {
        return doc;
      }
    }
  }

  function validarCPF(cpf) {
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    for (let i = 0; i < 9; i++) soma += parseInt(cpf.charAt(i)) * (10 - i);
    let resto = (soma * 10) % 11;
    if (resto === 10) resto = 0;
    if (resto !== parseInt(cpf.charAt(9))) return false;

    soma = 0;
    for (let i = 0; i < 10; i++) soma += parseInt(cpf.charAt(i)) * (11 - i);
    resto = (soma * 10) % 11;
    if (resto === 10) resto = 0;
    if (resto !== parseInt(cpf.charAt(10))) return false;

    return true;
  }

  function validarCNPJ(cnpj) {
    if (cnpj.length !== 14 || /^(\d)\1+$/.test(cnpj)) return false;

    let tamanho = cnpj.length - 2;
    let numeros = cnpj.substring(0, tamanho);
    let digitos = cnpj.substring(tamanho);
    let soma = 0;
    let pos = tamanho - 7;
    for (let i = tamanho; i >= 1; i--) {
      soma += parseInt(numeros.charAt(tamanho - i)) * pos--;
      if (pos < 2) pos = 9;
    }
    let resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
    if (resultado !== parseInt(digitos.charAt(0))) return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (let i = tamanho; i >= 1; i--) {
      soma += parseInt(numeros.charAt(tamanho - i)) * pos--;
      if (pos < 2) pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
    if (resultado !== parseInt(digitos.charAt(1))) return false;

    return true;
  }

  validarCampos();
});
