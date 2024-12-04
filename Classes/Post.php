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

    //  função para consultar o total de postagens existentes

    public function contarTotalPostagens()
    { // Consulta para obter o número total de postagens 
        $queryTotal = "SELECT COUNT(id) as total_postagens FROM postagem;";
        $stmtTotal = $this->conn->prepare($queryTotal);
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
        return $resultTotal;
    }

    // Função para consultar o total de postagens filtradas

    public function contarTotalPostagensFiltrada($search = '')
    {
        $searchTerm = "%" . $search . "%";
        $query = "SELECT count(id) as total_postagens FROM " . $this->table_name . " WHERE titulo LIKE ? OR descricao LIKE ?";

       $stmt = $this->conn->prepare($query);
        $stmt->execute([$searchTerm, $searchTerm]);
        $resultTotal = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultTotal['total_postagens'];
    }

    public function ler($search = '', $limite = 25, $offset = 0)
    {

        // chamando a função de contar o total de postagens

        $totalPostagens = $this->contarTotalPostagens();

        $query = "SELECT * FROM " . $this->table_name;
        $conditions = [];
        $params = [];

        if ($search) {
            $conditions[] = " (titulo LIKE :search OR descricao LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions) . "ORDER BY id DESC";
        } else {
            $query .= " ORDER BY id DESC";
        }

        if ($offset >= $totalPostagens) {
            // Se o offset for maior ou igual ao total de postagens, ajusta o offset para o último conjunto válido
            $offset = max(0, $totalPostagens - $limite);// Garante que o offset não seja negativo
            $query .= " LIMIT " . $limite . " OFFSET " . $offset;
        } else {
            $query .= " LIMIT " . $limite . " OFFSET " . $offset;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function lerPorUsuario($idUsu)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idUsuario = ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUsu]);
        return $stmt;
    }

    public function lerPostagem($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //  função para consultar o total de postagens existentes pelo usuário e pelas contas que ele segue

    public function contarTotalPostagensSeguidas($idUsuario)
    {
        // Consulta para obter o número total de postagens
        $queryTotal = "SELECT COUNT(p.id) as total_postagens 
                   FROM postagem p 
                   LEFT JOIN seguidor s ON p.idUsuario = s.idUsuario 
                   WHERE s.idSeguidor = ? OR p.idUsuario = ? GROUP BY p.id ORDER BY p.id";

        $stmtTotal = $this->conn->prepare($queryTotal);
        $stmtTotal->execute([$idUsuario, $idUsuario]);
        $resultTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);

        // Retorna o número total de postagens
        return $resultTotal['total_postagens'];
    }

    // função que carrega as postagens do usuário junto com as postagens de quem ele segue 

    public function lerPorSeguidor($idUsuario, $limite = 25, $offset = 0)
    {
        // chamando a função de contar o total de postagens  seguidas

        $totalPostagens = $this->contarTotalPostagensSeguidas($idUsuario);

        $query = "SELECT p.* FROM postagem p LEFT JOIN seguidor s ON p.idUsuario = s.idUsuario WHERE s.idSeguidor = ? or p.idUsuario = ? GROUP BY p.id ORDER BY p.id";

        if ($offset >= $totalPostagens) {
            // Se o offset for maior ou igual ao total de postagens, ajusta o offset para o último conjunto válido
            $offset = max(0, $totalPostagens - $limite);// Garante que o offset não seja negativo
            $query .= " DESC LIMIT  $limite OFFSET $offset";

        } else {
            $query .= " DESC LIMIT  $limite OFFSET $offset";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$idUsuario, $idUsuario]);
        return $stmt;
    }

    public function atualizar($titulo, $descricao, $imagem, $id)
    {
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