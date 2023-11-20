<?php
session_start();
include_once('conexao.php');

$pdo = conectar();
$produtos = array(); // Inicialize a variável $produtos como um array vazio

// Se houver um parâmetro de pesquisa na URL, execute uma consulta personalizada
if (isset($_GET['btnpesquisar'])) {
    $pesquisa = '%' . $_GET['pesquisa'] . '%';

    $sql = "SELECT * FROM tb_produtos WHERE nomeprod LIKE :pesquisa";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pesquisa', $pesquisa);

    if ($stmt->execute()) {
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultados) > 0) {
            echo "<h2>Resultados da Pesquisa:</h2>";
            echo "<ul>";
            foreach ($resultados as $produto) {
                echo "<li>Nome: {$produto['nomeprod']} - Preço: R$ " . number_format($produto['precoprod'], 2, ',', '.') . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Nenhum resultado encontrado.";
        }
    } else {
        echo "Erro na consulta ao banco de dados.";
    }
} else {
    // Consulta para obter os produtos em destaque
    $sql = "SELECT * FROM tb_produtos WHERE ativo = 'S'";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute()) {
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Erro na consulta ao banco de dados.";
    }
}
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
            width: 90%; /* Aumenta a largura da container */
            margin: 20px auto; /* Adiciona margem no topo e na base */
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
            margin-left: auto; /* Adiciona margem à esquerda */
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
            display: flex;
            justify-content: flex-end; /* Alinha os ícones à direita */
            align-items: center; /* Alinha os ícones verticalmente */
        }

        #cart-icon {
            width: 30px;
            height: 30px;
            margin-left: 10px; /* Adiciona margem à esquerda para separar os ícones */
        }

        #profile-img {
            width: 30px;
            height: 30px;
            cursor: pointer;
            margin-right: 10px; /* Adiciona margem à direita para separar os ícones */
        }

        .search-box {
            text-align: center;
            display: flex; /* Para centralizar horizontalmente */
            justify-content: center; /* Para centralizar horizontalmente */
            align-items: center; /* Para centralizar verticalmente */
            margin-top: 10px; /* Reduz a margem superior */
            width: 80%; /* Torna a barra de pesquisa 80% de largura do container */
        }

        #pesquisa {
            width: 100%; /* Define a largura do campo de pesquisa como 100% */
            padding: 15px; /* Aumenta o tamanho do campo de pesquisa */
            border: 1px solid #ccc;
            border-radius: 20px;
        }

        section {
            padding: 20px 0;
        }

        /* Estilos para produtos */
        .product-container {
            display: flex; /* Exibe os produtos em uma linha flexível */
            flex-wrap: wrap; /* Permite que os produtos quebrem para a próxima linha quando não há espaço suficiente */
            justify-content: space-around; /* Espaço entre os produtos */
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
            width: calc(30% - 20px); /* Aumenta a largura dos cards */
            max-width: 300px; /* Aumenta a largura máxima dos cards */
        }

        .product-card img {
            max-width: 100%;
            height: auto;
        }

        .product-details {
            padding: 15px;
            text-align: center;
        }

        .buy-button {
            background-color: #e747e1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .buy-button:hover {
            background-color: #be18bb;
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
            margin-top: 20px; /* Adiciona margem no topo */
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .profile-dropdown:hover .dropdown-content {
            display: block;
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

            .product-card {
                width: calc(50% - 20px); /* 50% para exibir dois cards por linha */
                max-width: none; /* Remove a largura máxima para telas menores */
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
                    <li><a href="consultas.php">Consulta</a></li>
                </ul>
            </nav>

            <div class="icons">
                <div class="search-box">
                    <form method="get" action="" class="form-group search-box">
                        <input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o nome do produto">
                        <input type="submit" name="btnpesquisar" value="Pesquisar">
                    </form>
                </div>
                <div class="profile-dropdown">
                    <img src="perfil.png" alt="Perfil" id="profile-img">
                    <div class="dropdown-content" id="profile-dropdown-content">
                        <a href="perfiladm.php">Meu Perfil</a>
                        <a href="login.php">Login</a>
                        <a href="carrinhodecompras.php">Minhas Compras</a>
                        <a href="logoff.php">Sair</a>
                    </div>
                </div>
                <a href="carrinhodecompras.php"><img src="imagens-de-carrinho-de-compras-png-4.png" alt="Carrinho" id="cart-icon"></a>
            </div>
        </div>
    </header>

    <!DOCTYPE html>
<html lang="ptBR">
<head>
    <!-- Seus cabeçalhos e metatags aqui -->
</head>
<body>
    <div class="container">
        <form method="POST">
        <h2>Consultas e cadastros</h2>
        <p class="link">
            <br><br>
                Consulta de clientes:
                <a href="concliente.php">Ir para consulta</a>
                <a href="cadastrocliente.php">Ir para cadastro</a>
            </p>
            <p class="link">
                Consulta de endereços:
                <a href="conendereco.php">Ir para consulta</a>
                <a href="cadastroendereco.php">Ir para cadastro</a>
            </p>
            <p class="link">
                Consulta de cidades:
                <a href="concidade.php">Ir para consulta</a>
            </p>
            <p class="link">
                Consulta de categorias:
                <a href="concategoria.php">Ir para consulta</a>
                <a href="cadastrocategoria.php">Ir para cadastro</a>
            </p>
            <p class="link">
                Consulta de imagem:
                <a href="conimg.php">Ir para consulta</a>
                <a href="cadastrarimg.php">Ir para cadastro</a>
            </p>
            <p class="link">
                Consulta de pedidos:
                <a href="conpedido.php">Ir para consulta</a>
                <a href="pedidos.php">Ir para cadastro</a>
            </p>
            <p class="link">
                Consulta de produtos:
                <a href="conproduto.php">Ir para consulta</a>
                <a href="cadastroproduto.php">Ir para cadastro</a>
            </p>
        </form>