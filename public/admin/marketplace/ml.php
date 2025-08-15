<?php
session_start();

if (!isset($_SESSION['usuario_tipo']) || !in_array($_SESSION['usuario_tipo'], [2, 3])) {
    header("Location: ../index.php");
    exit();
}

$access_token = 'APP_USR-6214520474866255-071017-35730f9bf2e50b0ebb3fa79e52f69a0e-766192095'; 
$user_id = '766192095';
$cache_file = 'cache_items.json';
$cache_time = 1800;

$url = "https://api.mercadolibre.com/users/$user_id/items/search";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $access_token"
    ],
]);

$response = curl_exec($curl);
curl_close($curl);
$items = json_decode($response, true);
?>

<head>
    <meta charset="UTF-8">
    <title>Mercado Livre - Quebra Galho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../images/logo.png">
    <link href="../../bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include 'includes/ml/nav.php'; ?>

     <div class="container mt-4">
        <div id="loading" class="text-center my-5">
            <p>Carregando produtos, aguarde...</p>  
            <div class="spinner-border text-warning" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>

        <div class="row" id="products-row" style="display:none;">
        </div>
    </div>

    <script>
        async function fetchProducts() {
            try {
                const response = await fetch('../../../app/models/marketplace/ml_produtos.php');
                if (!response.ok) throw new Error('Erro ao carregar os produtos');
                const html = await response.text();
                document.getElementById('products-row').innerHTML = html;
                document.getElementById('loading').style.display = 'none';
                document.getElementById('products-row').style.display = 'flex';
            } catch (e) {
                document.getElementById('loading').innerHTML = '<p class="text-danger">Erro ao carregar produtos.</p>';
            }
        }

        window.onload = fetchProducts;
    </script>


</body>

</html>