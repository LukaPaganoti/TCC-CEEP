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
            background-color: #8a2be2; /* Cor roxa */
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
            flex: 0 0 calc(33.33% - 20px); /* Largura de 1/3 com margem à direita */
            text-align: center;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 15px; /* Bordas arredondadas */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px; /* Espaço entre os produtos na vertical */
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
            background-color: #555;
        }

        /* Adicione espaço entre os títulos das seções */
        .section-title {
            margin-bottom: 20px;
        }

        /* Rodapé */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
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
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Produtos</a></li>
                    <li><a href="#">Sobre Nós</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </nav>
            <div class="icons">
                <a href="#"><img src="pngtree-outline-user-icon-png-image_1727916.jpg" alt="Perfil"></a>
                <a href="#"><img src="imagens-de-carrinho-de-compras-png-4.png" alt="Carrinho"></a>
            </div>
        </div>
    </header>

    <section class="featured-products">
        <div class="container">
            <h2 class="section-title">Produtos em Destaque</h2>
            <div class="product-container">
                <div class="product">
                    <img src="produto1.jpg" alt="Produto 1">
                    <h3>Elementos - Ordem Paranormal</h3>
                    <p>R$ 70,00</p>
                    <button class="buy-button">Comprar</button>
                </div>
                <div class="product">
                    <img src="produto2.jpg" alt="Produto 2">
                    <h3>Porta-copo - Ghibli</h3>
                    <p>R$ 45,00</p>
                    <button class="buy-button">Comprar</button>
                </div>
                <div class="product">
                    <img src="produto3.jpg" alt="Produto 3">
                    <h3>Marca página - Demon Slayer</h3>
                    <p>R$ 25,00</p>
                    <button class="buy-button">Comprar</button>
                </div>
                <div class="product">
                    <img src="produto4.jpg" alt="Produto 4">
                    <h3>Chaveiro - Omori</h3>
                    <p>R$ 15,00</p>
                    <button class="buy-button">Comprar</button>
                </div>
                <!-- Adicione mais produtos em destaque aqui -->
            </div>
        </div>
    </section>

    <section class="new-arrivals">
        <div class="container">
            <h2 class="section-title">Novos Produtos</h2>
            <div class="product-container">
                <div class="product">
                    <img src="produto1.jpg" alt="Produto 1">
                    <h3>Porta-copo - Ghibli</h3>
                    <p>R$ 45,00</p>
                    <button class="buy-button">Comprar</button>
                </div>
                <div class="product">
                    <img src="produto2.jpg" alt="Produto 2">
                    <h3>Chaveiro - Genshin Impact</h3>
                    <p>R$ 15,00</p>
                    <button class="buy-button">Comprar</button>
                </div>
                <!-- Adicione mais novos produtos aqui -->
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2023 STUDIOSBEN</p>
        </div>
    </footer>
</body>
</html>