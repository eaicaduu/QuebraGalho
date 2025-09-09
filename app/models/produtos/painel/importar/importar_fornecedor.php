<?php
function getFornecedorId(PDO $conn, string $nome) {
    if (empty($nome)) return null;

    $stmt = $conn->prepare("SELECT id FROM fornecedores WHERE nome = ?");
    $stmt->execute([$nome]);
    $id = $stmt->fetchColumn();

    if (!$id) {
        $stmtInsert = $conn->prepare("INSERT INTO fornecedores (nome) VALUES (?)");
        $stmtInsert->execute([$nome]);
        $id = $conn->lastInsertId();
    }

    return $id;
}
