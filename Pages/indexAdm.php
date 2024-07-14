<?php include_once '../Classes/Usuario.php';
include_once '../Config/config.php';

$usuario = new Usuario($db);

// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: ');
    exit();
}

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// if para evitar que ocorra erro na pesquisa por digitarem e pesquisarem por order_by
if ($order_by) {
    $search = '';
}

// Obter dados dos usuários com filtros
$dados = $usuario->ler($search, $order_by);

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome']

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/indexAdm.css">
    <script src="https://kit.fontawesome.com/1c1bb96ec4.js" crossorigin="anonymous"></script>
    <title>Lista de Usuários</title>
</head>
<body>
    <nav>
        <div class="container">
            <a href="index.php">
                <h2 class="log">
                    Rede Social
                </h2>
            </a>
            <div class="create">
                <a href="index.php"><label class="btn btn-primary">Voltar</label></a>
            </div>
        </div>
    </nav>
    <main>
    <div class="container">
        <form method="GET">
            <div class="filtro">
                <label>
                    <input type="radio" name="order_by" value="" <?php if ($order_by == '')
                        echo 'checked'; ?>> Normal
                </label>
                <label>
                    <input type="radio" name="order_by" value="nome" <?php if ($order_by == 'nome')
                        echo 'checked'; ?>> Ordem
                    Alfabética
                </label>
                <label>
                    <input type="radio" name="order_by" value="sexo" <?php if ($order_by == 'sexo')
                        echo 'checked'; ?>> Sexo
                </label>
            </div>
            <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass btn btn-primary i"></i>
            <input type="search" name="search" placeholder="Pesquisar por nome ou email"
                value="<?php echo htmlspecialchars($search); ?>">
                <!-- <button class="btn btn-primary" type="submit">Pesquisar</button> -->
            </div>
            
            <div class="botao">
                
            </div>

        </form>
        <h1>Lista de Usuários</h1>

        <form action="" method="POST">
        <div class="user-list">
        <table border="2">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Fone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados_usuario->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['apelido']; ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                <td><?php echo $row['fone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <div class="edicao">
                        <div class="editar">
                            <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                        </div>
                        <div class="deletar">
                            <a href="deletar.php?id=<?php echo $row['id']; ?>">Deletar</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        </div>
        </form>

    </div>
    </main>
</body>
</html>