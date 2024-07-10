<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/indexAdm.css">
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
                <a href="index.php"><label class="btn btn-primary" for="create-post">Voltar</label></a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Lista de Usuários</h1>
        <div class="user-list">
            <?php foreach ($usuarios as $user) : ?>
                <div class="user-card">
                    <p><?php echo htmlspecialchars($user['nome']); ?></p>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>