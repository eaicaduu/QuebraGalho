<div class="container mt-4">
    <div class="row">
        <?php
        if (isset($items['results']) && count($items['results']) > 0) {
            $mh = curl_multi_init();
            $curl_arr = [];
            $results = [];

            // Inicializa os curl handles para cada item
            foreach ($items['results'] as $item_id) {
                $url = "https://api.mercadolibre.com/items/$item_id";
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        "Authorization: Bearer $access_token"
                    ],
                ]);
                curl_multi_add_handle($mh, $curl);
                $curl_arr[$item_id] = $curl;
            }

            $running = null;
            do {
                curl_multi_exec($mh, $running);
                curl_multi_select($mh);
            } while ($running > 0);

            foreach ($curl_arr as $item_id => $curl) {
                $response = curl_multi_getcontent($curl);
                $item_data = json_decode($response, true);
                curl_multi_remove_handle($mh, $curl);

                if (!isset($item_data['id']) || isset($item_data['error'])) {
                    echo "<div class='col-12'><div class='alert alert-warning'>Erro ao carregar o item <strong>$item_id</strong>.</div></div>";
                    continue;
                }

                $results[$item_id] = $item_data;
            }

            curl_multi_close($mh);

            // Agora imprime os cards dos produtos
            foreach ($results as $item_id => $item_data) {
                $imagem = $item_data['thumbnail'] ?? '';
                if (isset($item_data['pictures'][0]['url'])) {
                    $imagem = $item_data['pictures'][0]['url'];
                }

                echo '<div class="col-sm-6 col-md-4 col-lg-3 mb-4">';
                echo '  <div class="card shadow-sm h-100 border-0 rounded-3">';
                echo '      <img src="' . htmlspecialchars($imagem) . '" class="card-img-top img-fluid rounded-top pe-none" style="height: 200px;" alt="' . htmlspecialchars($item_data['title']) . '">';
                echo '      <div class="card-body p-3">';
                echo '          <h6 class="card-title mb-2 text-truncate" title="' . htmlspecialchars($item_data['title']) . '">' . htmlspecialchars($item_data['title']) . '</h6>';
                echo '          <p class="card-text text-muted small mb-1">Preço: <strong>R$ ' . number_format($item_data['price'], 2, ',', '.') . '</strong></p>';
                echo '          <p class="card-text text-muted small mb-2">Estoque: ' . $item_data['available_quantity'] . '</p>';
                echo '          <a href="' . $item_data['permalink'] . '" target="_blank" class="btn btn-sm btn-warning w-100 mt-auto">Ver no Mercado Livre</a>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<p>Nenhum produto encontrado.</p>';
        }
        ?>
    </div>
</div>
