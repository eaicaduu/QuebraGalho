document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const btnSalvar = document.getElementById("btnSalvarCalculo");
    const btnBuscar = document.getElementById("btnBuscarProduto");
    const btnFechar = document.getElementById("btnFechar");
    const modalBuscarEl = document.getElementById('modalBuscar');
    const modalBuscar = new bootstrap.Modal(modalBuscarEl);
    const modalCalculoEl = document.getElementById('modalCalculo');
    const modalCalculo =  new bootstrap.Modal(modalCalculoEl);

    btnFechar.addEventListener("click", function (e) {
        const modalAdicionar = bootstrap.Modal.getInstance(document.getElementById('modalAdicionar'));
        if (modalAdicionar) modalAdicionar.hide();

        modalCalculo.show();
    });

    btnBuscar.addEventListener("click", function () {
        modalBuscar.show();
    });

    const ordemCampos = [
        "Nome",
        "CustoProduto",
        "Venda",
        "CustoMarketplace",
        "Frete",
        "CustoEmbalagem",
        "Imposto",
        "ComissaoMK"
    ];

    const camposReais = ["CustoProduto", "Frete", "CustoEmbalagem", "CustoMarketplace", "Venda"];
    const camposPercentuais = ["ComissaoMK", "Imposto"];

    function verificarCamposPreenchidos() {
        const obrigatorios = ["Nome", "CustoProduto", "Venda"];
        let preenchidos = true;

        obrigatorios.forEach(campo => {
            const input = app.querySelector(`input[name="${campo}"]`);
            if (!input || input.value.trim() === "") {
                preenchidos = false;
            }
        });

        btnSalvar.disabled = !preenchidos;

        if (preenchidos) {
            btnSalvar.classList.remove("btn-secondary");
            btnSalvar.classList.add("btn-success");
        } else {
            btnSalvar.classList.remove("btn-success");
            btnSalvar.classList.add("btn-secondary");
        }
    }


    function toggleField(checked, id, label, tipo = "text") {
        const existing = document.getElementById("grupo-" + id);
        if (checked && !existing) {
            const div = document.createElement("div");
            div.className = "mb-3 col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2";
            div.id = "grupo-" + id;

            const titulo = document.createElement("h6");
            titulo.className = "form-label mb-1";
            titulo.textContent = label;

            const input = document.createElement("input");
            input.type = tipo;
            input.className = "form-control";
            input.name = id;
            input.placeholder = label;

            if (camposReais.includes(id)) {
                input.addEventListener("input", () => {
                    let value = input.value.replace(/[^\d]/g, "");
                    value = (parseFloat(value) / 100).toFixed(2) || "0.00";
                    input.value = "R$ " + value.replace(".", ",");
                });
            }
            if (camposPercentuais.includes(id)) {
                input.addEventListener("input", () => {
                    let value = input.value.replace(/[^\d,\.]/g, "");
                    input.value = value;
                });

                input.addEventListener("blur", () => {
                    let value = input.value.replace(",", ".");
                    let num = parseFloat(value);
                    if (!isNaN(num)) {
                        input.value = num.toFixed(2) + "%";
                    } else {
                        input.value = "";
                    }
                });
            }

            input.addEventListener("input", verificarCamposPreenchidos);

            div.appendChild(titulo);
            div.appendChild(input);

            const index = ordemCampos.indexOf(id);
            let inserted = false;

            for (let i = index + 1; i < ordemCampos.length; i++) {
                const next = document.getElementById("grupo-" + ordemCampos[i]);
                if (next) {
                    app.insertBefore(div, next);
                    inserted = true;
                    break;
                }
            }

            if (!inserted) {
                app.appendChild(div);
            }

        } else if (!checked && existing) {
            existing.remove();
        }

    }

    document.getElementById("checkNome").addEventListener("change", function () {
        toggleField(this.checked, "Nome", "Nome Produto");
    });

    document.getElementById("checkCustoProduto").addEventListener("change", function () {
        toggleField(this.checked, "CustoProduto", "Custo Produto");
    });

    document.getElementById("checkFrete").addEventListener("change", function () {
        toggleField(this.checked, "Frete", "Frete");
    });

    document.getElementById("checkEmbalagem").addEventListener("change", function () {
        toggleField(this.checked, "CustoEmbalagem", "Custo Embalagem");
    });

    document.getElementById("checkMarketplace").addEventListener("change", function () {
        toggleField(this.checked, "CustoMarketplace", "Custo Marketplace");
    });

    document.getElementById("checkComissaoMK").addEventListener("change", function () {
        toggleField(this.checked, "ComissaoMK", "Comissão Marketplace");
    });

    document.getElementById("checkImposto").addEventListener("change", function () {
        toggleField(this.checked, "Imposto", "Imposto");
    });

    document.getElementById("checkVenda").addEventListener("change", function () {
        toggleField(this.checked, "Venda", "Valor Venda");
    });

    btnSalvar.addEventListener("click", function () {
        const inputs = app.querySelectorAll("input");
        const dados = {};

        inputs.forEach(input => {
            const nomeCampo = input.name;
            let valor = input.value.trim();

            if (valor.startsWith("R$")) {
                valor = valor.replace("R$", "").replace(/\./g, "").replace(",", ".").trim();
            } else if (valor.endsWith("%")) {
                valor = valor.replace("%", "").replace(",", ".").trim();
            }

            dados[nomeCampo] = valor;
        });

        fetch("../../../app/models/marketplace/painel/salvar_calculo.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dados)
        })
            .then(response => response.json())
            .then(resposta => {
                if (resposta.status === "ok") {
                    Swal.fire({
                        icon: "success",
                        title: "Sucesso",
                        text: "Produto salvo com sucesso!",
                        confirmButtonText: "OK"
                    }).then(() => {
                        voltarParaModalLucro();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: "Erro ao salvar: " + resposta.mensagem,
                        confirmButtonText: "OK"
                    });
                }
            })
            .catch(error => {
                console.error("Erro ao enviar dados:", error);
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Erro de conexão com o servidor.",
                    confirmButtonText: "OK"
                });
            });
    });
});