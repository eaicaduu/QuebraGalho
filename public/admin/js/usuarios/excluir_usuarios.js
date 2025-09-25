window.excluirUsuario = function (id, nome) {
    Swal.fire({
        title: `Excluir ${nome}?`,
        text: "Esta ação não poderá ser desfeita.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`../../../app/models/usuarios/excluir_usuarios.php?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Excluído",
                            text: "Usuário removido com sucesso.",
                            icon: "success",
                            confirmButtonColor: "#28a745"
                        }).then(() => location.reload());
                    } else {
                        Swal.fire("Erro", data.message || "Erro ao excluir", "error");
                    }
                })
                .catch(err => {
                    Swal.fire("Erro", "Não foi possível conectar ao servidor", "error");
                });
        }
    });
}
