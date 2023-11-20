<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset de estilos para remover margens e preenchimentos padrão */
        body, h1, h2, ul, li {
            margin: 0;
            padding: 0;
        }

        /* Estilos gerais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Cor de fundo geral */
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #be18bb; /* Cor roxa */
            color: #fff;
            padding: 20px 0;
            display: flex;
            align-items: center; /* Centralizar verticalmente */
        }

        header h1 {
            font-size: 36px;
            margin-left: -100px; /* Adiciona margem à esquerda */
        }

        nav ul {
            list-style-type: none;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
            padding: 0 10px; /* Adiciona espaçamento lateral */
        }

        nav a {
            color: #fff;
            text-decoration: none;
        }

        .icons {
            float: right;
            margin-right: 30px; /* Adiciona margem à direita */
        }

        .icons a {
            margin-left: 20px;
        }

        .icons img {
            width: 30px;
            height: 30px;
        }

        section {
            padding: 20px 0;
        }

        /* Estilos para produtos */
        .product-container {
            display: flex; /* Exibe os produtos em uma linha flexível */
            flex-wrap: wrap; /* Permite que os produtos quebrem para a próxima linha quando não há espaço suficiente */
            justify-content: space-between; /* Espaço igual entre os produtos */
        }

        .product {
            flex: 0 0 calc(20% - 20px); /* Largura de 1/4 com margem à direita */
            text-align: center;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 15px; /* Bordas arredondadas */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px; /* Espaço entre os produtos na vertical */
        }

        .product img {
            max-width: 100%;
            height: auto;
        }

        .buy-button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .buy-button:hover {
            background-color: #e747e1;
        }

        /* Adicione espaço entre os títulos das seções */
        .section-title {
            margin-bottom: 20px;
        }

        .search-box {
            margin-top: -60px;
            text-align: center;
        }

        input[type="text"] {
            width: 50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }

        button {
            background-color: #e747e1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Rodapé */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        /* Estilos para telas menores */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                margin: 20px 0;
            }

            .icons {
                margin-top: 20px;
            }

            .product {
                flex: 0 0 calc(50% - 20px);
            }
        }
    </style>
    <title>STUDIOSBEN - Artigos Geek e Otaku</title>
</head>
<body>
    <header>
        <div class="container">
            <h1>STUDIOSBEN</h1>
            <nav>
                <ul>
                    <li><a href="telainicial.php">Início</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="sobrenos.php">Sobre Nós</a></li>
                </ul>
            </nav>

            <div class="search-box">
                <input type="text" placeholder="Pesquisar produtos...">
                <button>Buscar</button>
            </div>

            <div class="icons">
                <a href="login.php"><img src="perfil.png" alt="Perfil"></a>
                <a href="#"><img src="imagens-de-carrinho-de-compras-png-4.png" alt="Carrinho"></a>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>Bem-vindo a StudiosBen!</h2>
        <br>
        <p>Esse é um site criado como Trabalho de Conclusão de Curso</p>
        <br>
        <p>Realinado no 4 ano do Ensino Médio no colégio Pedro Boaretto Neto - Cascavel</p>
        <p>StudiosBen é um e-commerce com foco na comunidade geek e otaku</p>
        <p>oferecendo produtos artesanais e exclusivos para todos os gostos!</p>
        <br>
        <p>Encontre produtos únicos e feitos com paixão para os fãs de cultura pop, anime e videogames.</p>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2023 STUDIOSBEN</p>
        </div>
    </footer>
</body>
</html>
