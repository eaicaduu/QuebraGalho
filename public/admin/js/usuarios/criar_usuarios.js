document.addEventListener("DOMContentLoaded", () => {
    const btnCriarUsuario = document.getElementById("btnCriarUsuario");

    btnCriarUsuario.addEventListener("click", () => {
        Swal.fire({
            title: "Criar Usuário",
            html: `
                <input id="swal-nome" class="form-control mb-2" placeholder="Nome">
                <input id="swal-documento" class="form-control mb-2" placeholder="Documento CPF ou CNPJ">
                <input id="swal-email" class="form-control mb-2" placeholder="Email" type="email">
                <select id="swal-tipo" class="form-control">
                    <option value="0">Usuário</option>
                    <option value="1">PJ</option>
                    <option value="2">Funcionário</option>
                    <option value="3">Admin</option>
                </select>
            `,
            didOpen: () => {
                const docInput = document.getElementById("swal-documento");
                docInput.addEventListener("input", (e) => {
                    e.target.value = formatarDocumento(e.target.value);
                });
            },
            showCancelButton: true,
            confirmButtonText: "Criar",
            confirmButtonColor: "#28a745",
            preConfirm: () => {
                const nome = document.getElementById("swal-nome").value.trim();
                const documento = document.getElementById("swal-documento").value.trim();
                const email = document.getElementById("swal-email").value.trim();
                const tipo_usuario = document.getElementById("swal-tipo").value;

                if (!nome || !documento || !email) {
                    Swal.showValidationMessage("Preencha todos os campos obrigatórios");
                    return false;
                }

                if (!isValidEmail(email)) {
                    Swal.showValidationMessage("E-mail inválido. Insira um e-mail com '@' e domínio válido.");
                    return false;
                }

                if (!isValidDocumento(documento)) {
                    Swal.showValidationMessage("Documento inválido. Insira um CPF (11 dígitos) ou CNPJ (14 dígitos) corretos.");
                    return false;
                }

                return { nome, documento, email, tipo_usuario };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("../../../app/models/usuarios/criar_usuarios.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(result.value),
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Sucesso", data.message, "success")
                                .then(() => location.reload());
                        } else {
                            Swal.fire("Erro", data.message || "Erro ao criar o usuário", "error");
                        }
                    });
            }
        });
    });
});

function onlyDigits(str) {
    return (str || '').replace(/\D+/g, '');
}

function isValidEmail(email) {
    if (!email) return false;
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function isValidCPF(cpf) {
    cpf = onlyDigits(cpf);
    if (cpf.length !== 11) return false;
    if (/^(\d)\1{10}$/.test(cpf)) return false;

    const calcCheck = (digits) => {
        let sum = 0;
        for (let i = 0; i < digits.length; i++) {
            sum += parseInt(digits.charAt(i), 10) * (digits.length + 1 - i);
        }
        const r = sum % 11;
        return r < 2 ? 0 : 11 - r;
    };

    const d1 = calcCheck(cpf.substr(0, 9));
    const d2 = calcCheck(cpf.substr(0, 9) + d1);
    return d1 === parseInt(cpf.charAt(9), 10) && d2 === parseInt(cpf.charAt(10), 10);
}

function isValidCNPJ(cnpj) {
    cnpj = onlyDigits(cnpj);
    if (cnpj.length !== 14) return false;
    if (/^(\d)\1{13}$/.test(cnpj)) return false;

    const calc = (cnpjSlice, positions) => {
        let sum = 0;
        for (let i = 0; i < cnpjSlice.length; i++) {
            sum += parseInt(cnpjSlice.charAt(i), 10) * positions[i];
        }
        const r = sum % 11;
        return r < 2 ? 0 : 11 - r;
    };

    // posições para o cálculo
    const pos1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    const pos2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    const slice12 = cnpj.substr(0, 12);
    const v1 = calc(slice12, pos1);
    const v2 = calc(slice12 + v1, pos2);

    return v1 === parseInt(cnpj.charAt(12), 10) && v2 === parseInt(cnpj.charAt(13), 10);
}

function isValidDocumento(doc) {
    const digits = onlyDigits(doc);
    if (digits.length === 11) return isValidCPF(digits);
    if (digits.length === 14) return isValidCNPJ(digits);
    return false;
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
            return doc.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, "$1.$2.$3/$4-$5");
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
