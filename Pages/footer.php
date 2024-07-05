<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .footer-content {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .footer-logo img {
            max-height: 50px;
        }

        .footer-links {
            list-style-type: none;
            padding: 0;
        }

        .footer-links li {
            display: inline;
            margin: 0 10px;
        }

        .footer-links a {
            color: #fff;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="path/to/your/logo.png" alt="Logo">
            </div>
            <ul class="footer-links">
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="servicos.php">Serviços</a></li>
                <li><a href="pessoas.php">Pessoas</a></li>
                <li><a href="perfil.php">Perfil</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
