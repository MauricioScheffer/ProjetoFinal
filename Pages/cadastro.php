<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Cadastrar</title>
</head>
<body>
<nav>
    <div class="container">
            <a href="index.php"><h2 class="log">
                Rede Social
            </h2></a>
        <!-- <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="Pesquisar">
        </div> -->
        <div class="create">
          <a href="index.php"><label class="btn btn-primary"  for="create-post">Voltar</label></a>
            <div class="profile-photo">
                <img src="img/perfil.jpg" alt="">
            </div>
        </div>
    </div>
</nav>

<!-- main -->
<main>
    <div class="container">
        <div class="meio">
            <h2>Cadastrar</h2>
            <div class="caixas">
                <input type="text" placeholder="Nome">
                <!-- <input type="text" placeholder="Seu Pet🐶"> -->
                <input type="email" placeholder="E-mail">
                <input type="password" id="senha" placeholder="Senha">
                <input type="text" placeholder="Telefone">
                <input type="date" placeholder="Data de Nascimento">
                <select>
                    <option value="" disabled selected>Sexo</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                    <option value="outro">Outro</option>
                </select>
                <i class="bi bi-eye" id="btn-senha" onclick="mostrarSenha()"></i>
            </div>
            <div class="botao">
                <label class="btn btn-primary entrar">Cadastrar</label>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>
<script src="../Script/main.js"></script>
</body>
</html>
