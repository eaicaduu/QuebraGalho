<?php
session_start();
require_once __DIR__ . '/app/config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmtConfig = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

$_SESSION['config'] = [
    'modo_site'   => $config['modo_site'],
    'nomeEmpresa' => !empty($config['nome_empresa']) ? htmlspecialchars($config['nome_empresa']) : 'Minha Empresa',
    'corPrincipal'=> !empty($config['cor_principal']) ? htmlspecialchars($config['cor_principal']) : '#000000',
    'logo'        => !empty($config['logo']) ? '../app/uploads/logo/' . htmlspecialchars($config['logo']) : 'images/default.png',
    'telefoneEmpresa' => !empty($config['telefone']) ? htmlspecialchars($config['telefone']) : '',
    'telefoneSecundarioEmpresa' => !empty($config['telefone_secundario']) ? htmlspecialchars($config['telefone_secundario']) : '',
    'emailEmpresa'=> !empty($config['email']) ? htmlspecialchars($config['email']) : 'contato@empresa.com',
    'enderecoEmpresa'=> !empty($config['endereco']) ? htmlspecialchars($config['endereco']) : '',
    'mapsEmpresa' => !empty($config['maps']) ? htmlspecialchars($config['maps']) : '#',
    'descricaoEmpresa'=> !empty($config['descricao']) ? htmlspecialchars($config['descricao']) : 'Descrição Da Empresa.',
    'facebook'    => !empty($config['facebook']) ? htmlspecialchars($config['facebook']) : '#',
    'instagram'   => !empty($config['instagram']) ? htmlspecialchars($config['instagram']) : '#',
    'whatsapp'    => !empty($config['whatsapp']) ? htmlspecialchars($config['whatsapp']) : '#'
];

switch ($config['modo_site']) {
    case 0:
        header("Location: public/landing.php");
        exit;
    case 1:
        header("Location: public/index.php");
        exit;
    default:
        header("Location: public/landing.php");
        exit;
}
