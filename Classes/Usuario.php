<?php
class Usuario
{
    private $conn;
    private $table_name = "usuario";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para criar um novo usuário
    public function criarUsuario($nome, $apelido, $email, $telefone, $sexo, $senha, $foto, $nascimento, $adm, $ativo)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, apelido, email, telefone, sexo, senha, foto, nascimento, adm, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $apelido, $email, $telefone, $sexo, $hashed_password, $foto, $nascimento, $adm, $ativo]);
        return $stmt;
    }

    


    // Método para deletar um usuário
    public function deletarUsuario($id)
    {
        $query = "DELETE * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

    // Método para fazer login
    public function login($email, $senha)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function lerUsuarios($search)
    {
        $query = "SELECT * FROM " . $this->table_name;
        $conditions = [];
        $params = [];

        // Verifica se a pesquisa começa com '@' para buscar pelo apelido
        if (!empty($search)) {
            if (strpos($search, '@') === 0) {
                $searchTerm = substr($search, 1); // Remove o '@' do início
                $conditions[] = "apelido LIKE :search";
                $params[':search'] = $searchTerm . '%';
            } else {
                $conditions[] = "nome LIKE :search OR apelido LIKE :search";
                $params[':search'] = '%' . $search . '%';
            }
        }
        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    // Método para ler todos os usuários ou filtrar por pesquisa e ordenação
    public function ler($search = '', $order_by = '')
    {
        $query = "SELECT * FROM " . $this->table_name;
        $conditions = [];
        $params = [];

        // Verifica se a pesquisa começa com '@' para buscar pelo apelido
        if (!empty($search)) {
            if (strpos($search, '@') === 0) {
                $searchTerm = substr($search, 1); // Remove o '@' do início
                $conditions[] = "apelido LIKE :search";
                $params[':search'] = '%' . $searchTerm . '%';
            } else {
                $conditions[] = "nome LIKE :search OR apelido LIKE :search";
                $params[':search'] = '%' . $search . '%';
            }
        }

        if ($order_by === 'nome') {
            $query .= " ORDER BY nome";
        } elseif ($order_by === 'sexo') {
            $query .= " ORDER BY sexo";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    // Método para ler um usuário específico por ID
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para atualizar dados de um usuário
    public function atualizar($nome, $email, $telefone, $sexo, $foto, $nascimento, $adm, $ativo, $id)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, email = ?, telefone = ?, sexo = ?, foto = ?, nascimento = ?, adm = ?, ativo = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $email, $telefone, $sexo, $foto, $nascimento, $adm, $ativo, $id]);
        return $stmt;
    }

    // Método para trazer os 5 usuários mais seguidos 
    public function maisSeguidos()
    {
        $query = "SELECT u.* FROM usuario u LEFT JOIN seguidor s ON u.id = s.idUsuario ORDER BY s.idUsuario DESC limit 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>