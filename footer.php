<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/fff353ec8e.js" crossorigin="anonymous"></script>
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
            overflow-x: hidden;
        }

        footer {
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: auto 0;
            /* width: 100%; */
            text-align: center;
            display: block;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 20px auto 30px;
            max-width: 960px;
            margin: 0 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .footer-logo img {
            max-height: 200px;
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

        .footer-content .Sobre li,
        .footer-content .Servicos li,
        .footer-content .Perfil li{
            list-style-type: none;
            color: var(--color-black);
            font-weight: bold;
        }

        .footer-content .Sobre,
        .footer-content .Servicos,
        .footer-content .Perfil{
            letter-spacing: 1px;
            text-align: left;
        }

        .footer-content .Sobre a,
        .footer-content .Servicos a,
        .footer-content .Perfil a{
            letter-spacing: 1px;
            text-decoration: none;
            color: var(--color-light);
            transition: 1s;
        }
        
        .footer-content .Sobre a:hover,
        .footer-content .Servicos a:hover,
        .footer-content .Perfil a:hover{
            color: var(--color-black);
        } 

        .footer-content .flecha i{
            position: absolute;
            color: var(--color-white);
            font-size: 2.9rem;
            right: 10%;
            transition: 1s;
            cursor: wait;
        }

        .footer-content .flecha i:hover{
            color: var(--color-black);
        }

        .bottom-fotter{
            margin: 0 60px;
        }

        .bottom-fotter .copyright{
            display: flex;
            justify-content: space-between;
        }

        @media (min-width: 768px) {
            .footer-content {
                flex-direction: row;
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .footer-content > div {
                flex: 1;
                margin: 1rem;
            }

            .bottom-footer .copyright {
                flex-direction: row;
                justify-content: space-between;
            }
        }

    </style>
</head>
<body>
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="img/LogoWhite.png" alt="Logo">
            </div>
            
            <div class="Sobre">
            <ul>
                <li>Rede Social</li>
                <p><a href="">Sobre</a></p>
                <p><a href="contato.php">Contato</a></p>
                <p><a href="">Endereço</a></p>
            </ul>
            </div>

            <div class="Servicos">
            <ul>
                <li>Clientes</li>
                <p><a href="">Serviços</a></p>
                <p><a href="">Encontros</a></p>
                <p><a href="">Pessoas</a></p>
            </ul>
            </div>

            <div class="Perfil">
            <ul>
                <li>Colaboradores</li>
                <p>Mauricio Scheffer<a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-linkedin"></i></a>
                <a href=""><i class="fa-brands fa-github"></i></a></p>

                <p>Gustavo Rizon<a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-linkedin"></i></a>
                <a href=""><i class="fa-brands fa-github"></i></a></p>

                <p>Vitor de Souza<a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-linkedin"></i></a>
                <a href=""><i class="fa-brands fa-github"></i></a></p>

                
            </ul>

            </div>
            <a href="" class="flecha"><i class="fa-solid fa-arrow-up"></i></a>

            
        </div>
        <section class="bottom-fotter">
                <hr></hr>
                <div class="copyright">
                    <p>© 2024 - Todos Os Direitos Reservados</p>
                    <p>Pensado, projetado e desenvolvido pelos Colaboradores</p>
                    <p>Política de Privacidade</p>
                </div>
            </section>
    </footer>
</body>
</html>
