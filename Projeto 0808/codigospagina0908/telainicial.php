<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>STUDIOSBEN</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f8f8f8;
		}
		header {
			background-color: #be00f2;
			color: #fff;
			padding: 20px;
		}
		nav ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}
		nav li {
			display: inline-block;
			margin-right: 20px;
		}
		nav a {
			color: #fff;
			text-decoration: none;
		}
		nav a:hover {
			color: #e5e5e5;
		}
		main {
			max-width: 960px;
			margin: 0 auto;
			padding: 20px;
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			align-items: flex-start;
		}
		.produto {
			background-color: #fff;
			padding: 20px;
			margin-bottom: 20px;
			box-shadow: 0 2px 4px rgba(0,0,0,.2);
			width: calc(33.33% - 20px);
		}
		.produto img {
			display: block;
			margin: 0 auto;
			max-width: 100%;
			height: auto;
		}
		.produto h3 {
			font-size: 1.2rem;
			margin-top: 10px;
			margin-bottom: 0;
		}
		.produto p {
			font-size: 1rem;
			margin-top: 10px;
		}
		.produto button {
			display: block;
			margin: 20px auto 0;
			background-color: #333;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			font-size: 1rem;
			cursor: pointer;
			transition: all .2s;
		}
		.produto button:hover {
			background-color: #555;
		}
		footer {
			background-color: #333;
			color: #fff;
			padding: 20px;
			text-align: center;
		}
        .search-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .search-box {
            border: 2px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
            margin-right: 10px;
        }
        .search-button {
            background-color: #fcfcfc;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: all .2s;
        }
        .search-button:hover {
            background-color: #555;
        }
	</style>
</head>
<body>
	<header>
		<h1>STUDIOSBEN</h1>
		<nav>
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">Produtos</a></li>
				<li><a href="#">Promoções</a></li>
				<li><a href="#">Contato</a></li>
			</ul>
            <div class="search-container">
            <input type="text" class="search-box" placeholder="Pesquisar Produtos">
            <button class="search-button">Buscar</button>
            </div>
            </nav>
            </header>
            <main>
            <div class="produto">
            <img src="https://via.placeholder.com/200x300" alt="Produto 1">
            <h3>Quadro colorido</h3>
            <p>R$65,00</p>
            <button>Comprar</button>
            </div>
            <div class="produto">
            <img src="https://via.placeholder.com/200x300" alt="Produto 2">
            <h3>Quadro preto e branco</h3>
            <p>R$45,00</p>
            <button>Comprar</button>
            </div>
            <div class="produto">
            <img src="https://via.placeholder.com/200x300" alt="Produto 3">
            <h3>Chaveiro</h3>
            <p>R$10,00</p>
            <button>Comprar</button>
            </div>
            <div class="produto">
            <img src="https://via.placeholder.com/200x300" alt="Produto 4">
            <h3>Marca pagina</h3>
            <p>R$25,00</p>
            <button>Comprar</button>
            </div>
            </main>
            
            </body>
            </html>