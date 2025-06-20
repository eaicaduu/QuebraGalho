<?php
class Product {
    private $conn;
    private $table = "produtos";

    public function __construct($db){
        $this->conn = $db;
    }

    // Listar todos os produtos
    public function listAll(){
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar produto específico
    public function getById($id){
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Adicionar produto
    public function create($data){
        $query = "INSERT INTO {$this->table} 
            (nome, preco, descricao, quantidade, status, imagem) 
            VALUES (:nome, :preco, :descricao, :quantidade, :status, :imagem)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $data['nome']);
        $stmt->bindParam(":preco", $data['preco']);
        $stmt->bindParam(":descricao", $data['descricao']);
        $stmt->bindParam(":quantidade", $data['quantidade']);
        $stmt->bindParam(":status", $data['status']);
        $stmt->bindParam(":imagem", $data['imagem']);

        return $stmt->execute();
    }

    // Editar produto
    public function update($id, $data){
        $query = "UPDATE {$this->table} SET 
            nome = :nome,
            preco = :preco,
            descricao = :descricao,
            quantidade = :quantidade,
            status = :status,
            imagem = :imagem
            WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $data['nome']);
        $stmt->bindParam(":preco", $data['preco']);
        $stmt->bindParam(":descricao", $data['descricao']);
        $stmt->bindParam(":quantidade", $data['quantidade']);
        $stmt->bindParam(":status", $data['status']);
        $stmt->bindParam(":imagem", $data['imagem']);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    // Excluir produto
    public function delete($id){
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}