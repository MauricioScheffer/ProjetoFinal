

<?php
class Usuario
{
    private $conn;
    private $table_name = "usuario";


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function criarUsuario($nome, $apelido, $email, $telefone, $sexo, $senha, $foto, $nascimento,  $adm, $ativo) {
        $query = "INSERT INTO " . $this->table_name . " (nome, apelido, email, telefone, sexo, senha, foto, nascimento, adm, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $apelido, $email, $telefone, $sexo, $hashed_password, $foto, $nascimento,  $adm, $ativo]);
        return $stmt;
    }
    

    public function deletarUsuario($nome, $apelido, $email, $telefone, $sexo, $senha, $nascimento, $adm, $ativo){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ? ON DELETE CASCADE";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$$nome, $apelido, $email, $telefone, $sexo, $senha, $nascimento, $adm, $ativo]);
        return $stmt;

    }

    public function login($email, $senha){
        
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
     
        if ($usuario && password_verify($senha, $usuario['senha'])){
            
            return $usuario;
            
        }
        return false;
    }




}




?>