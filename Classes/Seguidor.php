<?php
class Seguidor
{
    private $conn;
    private $table_name = "seguidor";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Consulta se o usuário já está sendo seguido 
    public function ler($idUsuario, $idSeguidor)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idUsuario = ? AND idSeguidor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUsuario, $idSeguidor]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Cria na tabela a informação de quem o usuário começou a seguir 

    public function seguir($idUsuario, $idSeguidor)
    {
        $query = "INSERT INTO " . $this->table_name . " (idUsuario, idSeguidor) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUsuario, $idSeguidor]);
        return $stmt;

    }

    // Deixar de seguir

    public function desseguir($idUsuario, $idSeguidor)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE idUsuario = ? AND idSeguidor = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUsuario, $idSeguidor]);
        return $stmt;
    }

}
?>