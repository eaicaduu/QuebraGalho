    <?php
    session_start();
    require_once '../../config/database.php';

    $db = new Database();
    $conn = $db->getConnection();

    $usuario_id = $_SESSION['usuario_id'] ?? null;
    $produto_id = $_POST['produto_id'] ?? null;
    $quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 1;
    $preco_unitario = isset($_POST['preco_unitario']) ? floatval($_POST['preco_unitario']) : 0;
    
    if (!$usuario_id) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não autenticado.']);
        exit;
    }

    if (!$produto_id) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Produto inválido.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT id, quantidade FROM carrinho WHERE usuario_id = ? AND produto_id = ? AND status = 0");
        $stmt->execute([$usuario_id, $produto_id]);
        $itemExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($itemExistente) {
            $novaQuantidade = $itemExistente['quantidade'] + $quantidade;
            $stmt = $conn->prepare("UPDATE carrinho SET quantidade = ?, preco_unitario = ? WHERE id = ?");
            $stmt->execute([$novaQuantidade, $preco_unitario, $itemExistente['id']]);
        } else {
            $stmt = $conn->prepare("INSERT INTO carrinho (usuario_id, produto_id, quantidade, preco_unitario, status) VALUES (?, ?, ?, ?, 0)");
            $stmt->execute([$usuario_id, $produto_id, $quantidade, $preco_unitario]);
        }

        $stmt = $conn->prepare("SELECT COUNT(*) FROM carrinho WHERE usuario_id = ? AND status = 0");
        $stmt->execute([$usuario_id]);
        $total = (int) $stmt->fetchColumn();

        $stmt = $conn->prepare("SELECT id, cod_sku, nome, imagem_principal, preco FROM produtos WHERE id = ? LIMIT 1");
        $stmt->execute([$produto_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        $imagem = (!isset($produto['imagem_principal']) || trim($produto['imagem_principal']) === '') ? 'images/default.png' : "../app/uploads/produtos/" . $produto['imagem_principal'];

        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Adicionado ao carrinho!',
            'total' => $total,
            'produto' => [
                'id' => $produto_id,
                'cod_sku' => $produto['cod_sku'],
                'nome' => $produto['nome'],
                'imagem' => $imagem,
                'quantidade' => $quantidade
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar o carrinho.']);
    }
