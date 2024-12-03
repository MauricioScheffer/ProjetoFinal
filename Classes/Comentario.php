<?php
class Comentario
{
    private $conn;
    private $table_name = "comentario";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function criar($idPostagem, $idUsuario, $descricao, $data)
    {
        $query = "INSERT INTO " . $this->table_name . " (idPostagem, idUsuario, descricao, data) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPostagem, $idUsuario, $descricao, $data]);
        return $stmt;

    }

    public function ler($idPostagem)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idPostagem = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPostagem]);
        return $stmt;
    }

    public function deletar($idComentario)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idComentario]);
        return $stmt;
    }

}

?>