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

public function lerPorUsuario($idUsu){
    $query = "SELECT * FROM " . $this->table_name . " WHERE idUsuario = ? ORDER BY id DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$idUsu]);
    return $stmt;
}

public function lerPorSeguidor($idUsu){
$query = "SELECT p.* FROM postagem p INNER JOIN seguidor ON p.idusu = idseguido ";
$query .= "WHERE seguidor = ?";
$stmt = $this->conn->prepare($query);
    $stmt->execute([$idUsu]);
}

}
?>