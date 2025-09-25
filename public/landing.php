<?php
session_start();

$config = $_SESSION['config'] ?? [];

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title><?= $config['nomeEmpresa'] ?> - Materiais de Construção, Elétrica e Ferragens</title>
  <meta name="description" content="A Quebra Galho Ferragem oferece os melhores produtos em ferramentas, elétrica, hidráulica e construção. Atendimento rápido, produtos de qualidade e os melhores preços da região.">
  <meta name="keywords" content="ferragem, materiais de construção, ferramentas, elétrica, hidráulica, parafusos, porcas, pregos, cimento, tinta, construção, loja de ferragens">
  <meta name="author" content="Quebra Galho Ferragem">
  <meta name="robots" content="index, follow">
  <link rel="icon" type="image/png" href="<?= $config['logo'] ?>">
  <link rel="shortcut icon" href="<?= $config['logo'] ?>">
  <meta property="og:title" content="Quebra Galho Ferragem">
  <meta property="og:description" content="Tudo para sua obra ou reforma em um só lugar. Ferragens, materiais elétricos e hidráulicos com os melhores preços.">
  <meta property="og:url" content="https://quebragalhoferragem.com.br/">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="pt_BR">
  <link rel="canonical" href="https://quebragalhoferragem.com.br/">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="user-select-none bg-warning m-0 p-0">

  <?php include 'includes/landing/nav.php'; ?>

  <?php include 'includes/landing/cards.php'; ?>

  <?php include 'includes/landing/servicos.php'; ?>

  <?php include 'includes/landing/sobre.php'; ?>

  <?php include 'includes/landing/localizacao.php'; ?>

  <?php include 'includes/landing/whatsapp.php'; ?>

  <?php include 'includes/landing/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/landing/cards.js"></script>
</body>

</html>