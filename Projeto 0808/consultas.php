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

        .btn-warning {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-warning:hover {
            background-color: #e747e1;
        }

        .btn-danger {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-danger:hover {
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
                    <li><a href="consultas.php">Consultas</a></li>
                </ul>
            </nav>

            <form method="get" action="" class="form-group">
                <input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o nome do produto">
                <input type="submit" name="btnpesquisar" value="Pesquisar">
            </form>

            <div class="icons">
                <a href="login.php"><img src="perfil.png" alt="Perfil"></a>
                <a href="#"><img src="imagens-de-carrinho-de-compras-png-4.png" alt="Carrinho"></a>
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