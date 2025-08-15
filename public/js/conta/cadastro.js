document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("cadastroForm");
  const nomeInput = document.getElementById("nome");
  const documentoInput = document.getElementById("documento");
  const emailInput = document.getElementById("email");
  const senhaInput = document.getElementById("senha");
  const confirmarSenhaInput = document.getElementById("confirmarSenha");
  const errorIcon = document.getElementById("errorIcon");
  let errosGlobais = [];
  const submitButton = document.getElementById("submitButton");
  const loginLink = document.getElementById("loginLink");

  nomeInput.value = localStorage.getItem("cadastroNome") ?? "";
  documentoInput.value = localStorage.getItem("cadastroDocumento") ?? "";
  emailInput.value = localStorage.getItem("cadastroEmail") ?? "";
  senhaInput.value = localStorage.getItem("cadastroSenha") ?? "";
  confirmarSenhaInput.value =
    localStorage.getItem("cadastroConfirmarSenha") ?? "";

  document.querySelectorAll(".toggle-password").forEach((icon) => {
    icon.addEventListener("click", () => {
      const input = icon.previousElementSibling;
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
      }
    });
  });

  if (document.referrer.includes("login.php")) {
    loginLink.style.display = "none";
  }

  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("erro")) {
    urlParams.delete("erro");
    const url = new URL(window.location);
    url.search = urlParams.toString();
    window.history.replaceState({}, document.title, url.toString());
  }

  nomeInput.addEventListener("input", () => {
    let valor = nomeInput.value;
    valor = valor.replace(/[^A-Za-zÀ-ÿ\s]/g, "");
    valor = valor.replace(
      /\b\w+/g,
      (w) => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase()
    );
    nomeInput.value = valor;
    localStorage.setItem("cadastroNome", nomeInput.value);
    validarCampos();
  });

  documentoInput.addEventListener("input", () => {
    documentoInput.value = formatarDocumento(documentoInput.value);
    localStorage.setItem("cadastroDocumento", documentoInput.value);
    validarCampos();
  });

  emailInput.addEventListener("input", () => {
    localStorage.setItem("cadastroEmail", emailInput.value);
    validarCampos();
  });

  senhaInput.addEventListener("input", () => {
    localStorage.setItem("cadastroSenha", senhaInput.value);
    validarCampos();
  });

  confirmarSenhaInput.addEventListener("input", () => {
    localStorage.setItem("cadastroConfirmarSenha", confirmarSenhaInput.value);
    validarCampos();
  });

  emailInput.addEventListener("input", validarCampos);
  senhaInput.addEventListener("input", validarCampos);
  confirmarSenhaInput.addEventListener("input", validarCampos);

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (!validarCampos()) return;

    submitButton.disabled = true;

    const formData = new FormData(form);

    try {
      const response = await fetch("../app/models/conta/cadastro.php", {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "Cadastro realizado com sucesso!",
          text: "Agora você pode fazer login.",
          confirmButtonText: "OK",
          confirmButtonColor: "#28a745",
        }).then(() => {
          localStorage.removeItem("cadastroNome");
          localStorage.removeItem("cadastroDocumento");
          localStorage.removeItem("cadastroEmail");
          localStorage.removeItem("cadastroSenha");
          localStorage.removeItem("cadastroConfirmarSenha");
          window.location.replace("login.php");
        });
      } else {
        errosGlobais = [];
        if (data.error == "email") {
          errosGlobais = ["E-mail já cadastrado."];
          emailInput.classList.add("is-invalid");
        } else if (data.error === "documento") {
          errosGlobais = ["Documento já cadastrado."];
          documentoInput.classList.add("is-invalid");
        } else {
          errosGlobais = ["Erro desconhecido. Tente novamente."];
        }
        mostrarErroIconComTooltip(errosGlobais);
      }
    } catch {
      errosGlobais = ["Erro na conexão. Tente novamente."];
      mostrarErroIconComTooltip(errosGlobais);
    } finally {
      submitButton.disabled = false;
    }
  });

  function validarCampos() {
    let valid = true;
    let erros = [];

    if (nomeInput.value.trim().length < 3) {
      valid = false;
      erros.push("Nome muito curto.");
    }

    const documentoSemFormatacao = documentoInput.value.replace(/\D/g, "");
    if (
      !(
        validarCPF(documentoSemFormatacao) ||
        validarCNPJ(documentoSemFormatacao)
      )
    ) {
      valid = false;
      erros.push("Documento inválido.");
    } else {
      documentoInput.classList.remove("is-invalid");
    }

    const emailValido = /\S+@\S+\.\S+/.test(emailInput.value);
    if (!emailValido) {
      valid = false;
      erros.push("E-mail inválido.");
    } else {
      emailInput.classList.remove("is-invalid");
    }

    if (senhaInput.value.length < 6) {
      valid = false;
      erros.push("Senha muito curta.");
    }

    if (senhaInput.value != confirmarSenhaInput.value) {
      valid = false;
      erros.push("Senhas divergentes.");
    }

    errosGlobais = erros;

    if (valid) {
      submitButton.disabled = false;
      submitButton.classList.remove("btn-secondary");
      submitButton.classList.add("btn-success");
      submitButton.title = "";
      errorIcon.style.display = "none";
      errorIcon.title = "";
    } else {
      submitButton.disabled = true;
      submitButton.classList.remove("btn-success");
      submitButton.classList.add("btn-secondary");
      errorIcon.style.display = "block";
      errorIcon.title = erros.join("\n");
    }

    return valid;
  }

  function mostrarErroIconComTooltip(erros) {
    if (erros.length > 0) {
      errorIcon.style.display = "block";
      errorIcon.title = erros.join("\n");
    } else {
      errorIcon.style.display = "none";
      errorIcon.title = "";
    }
  }

  errorIcon.addEventListener("click", () => {
    if (errosGlobais.length > 0) {
      Swal.fire({
        icon: "error",
        title: "Erros encontrados",
        html: errosGlobais.join("<br>"),
        confirmButtonText: "OK",
        confirmButtonColor: "#28a745",
      });
    }
  });

  senhaInput.addEventListener("input", validarCampos);
  confirmarSenhaInput.addEventListener("input", validarCampos);
  documentoInput.addEventListener("input", () => {
    documentoInput.value = formatarDocumento(documentoInput.value);
    validarCampos();
  });

  function formatarDocumento(valor) {
  valor = valor.replace(/\D/g, "");

  if (valor.length <= 11) {
    if (valor.length > 9)
      return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, "$1.$2.$3-$4");
    if (valor.length > 6)
      return valor.replace(/(\d{3})(\d{3})(\d{0,3})/, "$1.$2.$3");
    if (valor.length > 3) return valor.replace(/(\d{3})(\d{0,3})/, "$1.$2");
    return valor;
  } else {
    if (valor.length > 12)
      return valor.replace(
        /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2}).*/,
        "$1.$2.$3/$4-$5"
      );
    if (valor.length > 8)
      return valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,4}).*/, "$1.$2.$3/$4");
    if (valor.length > 5)
      return valor.replace(/^(\d{2})(\d{3})(\d{0,3}).*/, "$1.$2.$3");
    if (valor.length > 2) return valor.replace(/^(\d{2})(\d{0,3}).*/, "$1.$2");
    return valor;
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
