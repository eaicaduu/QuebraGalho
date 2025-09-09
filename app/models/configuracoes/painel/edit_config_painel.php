<?php
require_once __DIR__ . '/../../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$nome_empresa = $_POST['nome_empresa'] ?? '';
$cor_principal = $_POST['cor_principal'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$telefone_secundario = $_POST['telefone_secundario'] ?? '';
$email = $_POST['email'] ?? '';
$endereco = $_POST['endereco'] ?? '';

$logoNome = '';
$uploadDir = __DIR__ . '/../../../uploads/logo/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
    $logoNome = basename($_FILES['logo']['name']);
    move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $logoNome);
}

$check = $conn->query("SELECT COUNT(*) as total FROM configuracao")->fetch(PDO::FETCH_ASSOC);

if ($check['total'] > 0) {
    $sql = "UPDATE configuracao SET nome_empresa=?, cor_principal=?, telefone=?, telefone_secundario=?, email=?, endereco=?";
    $params = [$nome_empresa, $cor_principal, $telefone, $telefone_secundario, $email, $endereco];

    if ($logoNome) {
        $sql .= ", logo=?";
        $params[] = $logoNome;
    }

    $sql .= " LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
} else {
    $sql = "INSERT INTO configuracao (nome_empresa, cor_principal, telefone, telefone_secundario, email, endereco, logo) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nome_empresa, $cor_principal, $telefone, $telefone_secundario, $email, $endereco, $logoNome]);
}

echo json_encode(['success' => true]);
