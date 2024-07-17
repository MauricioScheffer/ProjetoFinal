<?php
class Curtida {
    private $conn;
    private $table_name = "curtida"; // Corrigido para o nome correto da tabela

    public function __construct($db) {
        $this->conn = $db;
    }

    // Verifica se o usuário já curtiu a postagem
    public function jaCurtiu($idPostagem, $idUsuario) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idPostagem = ? AND idUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPostagem, $idUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Adiciona uma curtida
    public function curtir($idPostagem, $idUsuario) {
        $query = "INSERT INTO " . $this->table_name . " (idPostagem, idUsuario) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPostagem, $idUsuario]);
        return $stmt;
    }

    // Remove uma curtida
    public function descurtir($idPostagem, $idUsuario) {
        $query = "DELETE FROM " . $this->table_name . " WHERE idPostagem = ? AND idUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPostagem, $idUsuario]);
        return $stmt;
    }



    
    // Conta o total de curtidas de uma postagem
    public function contarCurtidas($idPostagem) {
        $query = "SELECT COUNT(*) AS totalCurtidas FROM " . $this->table_name . " WHERE idPostagem = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPostagem]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['totalCurtidas'];
    }

    // Obtém os usuários que curtiram uma postagem
    public function obterCurtidas($idPostagem) {
        $query = "SELECT u.nome, u.foto FROM " . $this->table_name . " c ";
        $query .= "JOIN usuario u ON c.idUsuario = u.id ";
        $query .= "WHERE c.idPostagem = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idPostagem]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>