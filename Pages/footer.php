<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap');

        :root{
            --primary-color-hue: 252;
            --dark-color-lightness: 17%;
            --light-color-lightness: 95%;
            --white-color-lightness: 100%;

            --color-white: hsl(252, 30%, var(--white-color-lightness));
            --color-light: hsl(252, 30%, var(--light-color-lightness));
            --color-grey: hsl(var(--primary-color-hue), 15%, 65%);
            --color-primary: hsl(var(--primary-color-hue), 75%, 60%);
            --color-secundary: hsl(252, 100%, 90%);
            --color-sucess: hsl(120, 95%, 65%);
            --color-danger: hsl(0, 95%, 65%);
            --color-dark: hsl(252, 30%, var(--dark-color-lightness));
            --color-black: hsl(252, 30%, 10%);

            --border-radius: 2rem;
            --card-border-radius: 1rem;
            --btn-padding: 0.6rem 2rem;
            --search-padding: 0.6rem 1rem;
            --card-padding: 1rem;

            --sticky-top-left: 1.4rem;
            --sticky-top-right: 7.4rem;
        }

        /* *, *::before, *::after{
            margin: 0;
            padding: 0;
            outline: 0;
            box-sizing: border-box;
            text-decoration: none;
            list-style: none;
            border: none;
        } */

        body{
            font-family: "Poppins", sans-serif;
            color: var(--color-dark);
            background: var(--color-light);
            overflow-x: hidden;
        }

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
                <li><a href="">Blog</a></li>
                <li><a href="">Contato</a></li>
                <li><a href="">Clientes</a></li>
                <li><a href="">Serviços</a></li>
                <li><a href="">Pessoas</a></li>
                <li><a href="">Perfil</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
