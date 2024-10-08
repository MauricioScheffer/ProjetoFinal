<?php
class Post
{
    private $conn;
    private $table_name = "postagem";

    public function __construct($db)
    {
        $this->conn = $db;
    }

public function criar($idUsuario, $titulo, $descricao, $imagem, $data)
{
    $query = "INSERT INTO " . $this->table_name . " (idUsuario, titulo, descricao, imagem, data) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$idUsuario, $titulo, $descricao, $imagem, $data]);
    return $stmt;

}

public function ler($search = '') {
    $query = "SELECT * FROM " . $this->table_name;
    $conditions = [];
    $params = [];

    if ($search) {
       $conditions[] = " (titulo LIKE :search OR descricao LIKE :search)";
        $params[':search'] = '%' . $search . '%';
    }

    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions ) . "ORDER BY id DESC";
    }else{
        $query .= " ORDER BY id DESC";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

public function lerPorUsuario($idUsu){
    $query = "SELECT * FROM " . $this->table_name . " WHERE idUsuario = ? ORDER BY id DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$idUsu]);
    return $stmt;
}

public function lerPostagem($id){
    $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function lerPorSeguidor($idUsuario){
$query = "SELECT p.* FROM postagem p LEFT JOIN seguidor s ON p.idUsuario = s.idUsuario WHERE s.idSeguidor = ? or p.idUsuario = ? GROUP BY p.id ORDER BY p.id DESC";
$stmt = $this->conn->prepare($query);
    $stmt->execute([$idUsuario, $idUsuario]);
    return $stmt;
}

public function atualizar($titulo, $descricao, $imagem, $id){
    $query = "UPDATE " . $this->table_name . " SET titulo = ?, descricao = ?, imagem = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$titulo, $descricao, $imagem, $id]);
    return $stmt;
}

public function deletarPostagem($id)
{
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt;
}

}
?>