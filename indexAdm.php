<?php
session_start();
include_once 'Config/config.php'; // Ajuste o caminho conforme necessário
include_once 'Classes/Usuario.php'; // Ajuste o caminho conforme necessário

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Obtendo todos os usuários
$usuario = new Usuario($db);
$lista_usuarios = $usuario->ler(); // Chamada ao método ler() para buscar todos os usuários
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/indexAdm.css" />
    <title>Administração de Usuários</title>
    <script>
        function confirmarExclusao(id) {
            if (confirm('Tem certeza que deseja deletar este usuário e todas as suas notícias?')) {
                fetch('deletar_usuario.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id=' + id,
                }).then(response => {
                    if (response.ok) {
                        document.getElementById('user_' + id).remove();
                    } else {
                        alert('Erro ao excluir usuário.');
                    }
                }).catch(error => {
                    console.error('Erro ao tentar excluir usuário:', error);
                });
            }
        }

        function editarUsuario(id) {
            window.location.href = 'editarUsuario.php?id=' + id;
        }

        function buscarUsuarios() {
            var input = document.getElementById('searchInput').value.toUpperCase();
            var table = document.querySelector('table');
            var tr = table.getElementsByTagName('tr');

            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName('td')[1]; // Coluna do nome

                if (td) {
                    var nome = td.textContent || td.innerText;
                    if (nome.toUpperCase().indexOf(input) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

        function limparFiltro() {
            document.getElementById('searchInput').value = '';
            buscarUsuarios();
        }

        function filtrarUsuarios(tipo) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.querySelector('table');
            switching = true;

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName('td')[1]; // Coluna do nome
                    y = rows[i + 1].getElementsByTagName('td')[1]; // Próxima coluna do nome

                    if (tipo === 'ordem-alfabetica') {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (tipo === 'ordem-reversa') {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>
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
                <a href="cadastro.php"><label class="btn btn-primary">Cadastrar Usuário</label></a>
                <a href="logout.php"><label class="btn btn-primary">Sair</label></a>
                <div class="profile-photo">

                    <!-- <a class="nav-theme"><?php echo "<img src= '../$foto'>";?>
                        <div class="nav-popup">
                            <div class="perfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i class="fa-regular fa-user"></i>Perfil</span></a>
                            </div>
                            <div class="editarPerfil">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i class="fa-solid fa-user-pen"></i>Editar Perfil</span></a>
                            </div>
                            <div class="logout">
                                <a href="perfil.php?id=<?php echo $idUsuario; ?>"><span><i class="fa-solid fa-right-from-bracket"></i>Sair</span></a>
                            </div>
                        </div>
                    </a> -->

                </div>
            </div>
        </div>
    </nav>

    <div class="container-main">
        <h1>Administração de Usuários</h1>

        <div class="nav">
            <input class="search-bar" type="search" id="searchInput" placeholder="Pesquisar..." onkeyup="buscarUsuarios()">
            <button onclick="filtrarUsuarios('ordem-alfabetica')">Ordem alfabética</button>
            <button onclick="filtrarUsuarios('ordem-reversa')">Ordem reversa</button>
            <button onclick="limparFiltro()">Limpar</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Apelido</th>
                    <th>Sexo</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Iterando sobre a lista de usuários
                while ($dados_usuario = $lista_usuarios->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr id="user_' . $dados_usuario['id'] . '">';
                    echo '<td>' . $dados_usuario['id'] . '</td>';
                    echo '<td>' . $dados_usuario['nome'] . '</td>';
                    echo '<td>' . $dados_usuario['apelido'] . '</td>';
                    echo '<td>' . ($dados_usuario['sexo'] === 'M' ? 'Masculino' : 'Feminino') . '</td>';
                    echo '<td>' . $dados_usuario['telefone'] . '</td>';
                    echo '<td>' . $dados_usuario['email'] . '</td>';
                    echo '<td>';
                    if ($_SESSION['usuario_id'] != $dados_usuario['id']) {
                        echo '<button onclick="confirmarExclusao(' . $dados_usuario['id'] . ')">Deletar</button>';
                        echo '<button onclick="editarUsuario(' . $dados_usuario['id'] . ')">Editar</button>';
                    } else {
                        echo '<button disabled>Deletar</button>';
                        echo '<button onclick="editarUsuario(' . $dados_usuario['id'] . ')">Editar</button>';
                    }
                    echo '</td>';
                    
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
    <?php include 'footer.php'; // Inclua o rodapé ?>
    </footer>
</body>
</html>
