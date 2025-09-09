<?php 
function obterTokenComCacheML($client_id, $client_secret, $conn) {
    $stmt = $conn->query("SELECT * FROM tokens_ml LIMIT 1");
    $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tokenData) {
        $access_token = $tokenData['access_token'];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.mercadolibre.com/users/me',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $access_token"
            ],
        ]);
        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($http_code === 200) {
            return $access_token;
        }

        $refreshToken = $tokenData['refresh_token'];
        $url = 'https://api.mercadolibre.com/oauth/token';

        $postData = http_build_query([
            'grant_type' => 'refresh_token',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refreshToken,
        ]);

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']
        ]);

        $newResponse = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($newResponse, true);

        if (isset($data['access_token'])) {
            $stmt = $conn->prepare("UPDATE tokens_ml SET access_token = ?, refresh_token = ?, atualizado_em = NOW() WHERE id = ?");
            $stmt->execute([$data['access_token'], $data['refresh_token'], $tokenData['id']]);

            return $data['access_token'];
        }
    }

    return false;
}

