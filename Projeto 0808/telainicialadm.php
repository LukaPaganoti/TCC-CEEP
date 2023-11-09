<?php
session_start();
include_once('conexao.php');

$pdo = conectar();
$produtos = array(); // Inicialize a variável $produtos como um array vazio

// Inicializa a variável $stmt fora do bloco condicional
$stmt = null;

if (isset($_GET['btnpesquisar'])) {
    $pesquisa = '%' . $_GET['pesquisa'] . '%';
    $sql = "SELECT p.*, i.produtoimg FROM tb_produtos p
            LEFT JOIN tb_imagens_prod i ON p.codproduto = i.fk_codproduto
            WHERE p.nomeprod LIKE :pesquisa";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pesquisa', $pesquisa, PDO::PARAM_STR); // Defina o tipo de dado para string
} else {
    // Consulta para obter os produtos em destaque
    $sql = "SELECT p.*, i.produtoimg FROM tb_produtos p
            LEFT JOIN tb_imagens_prod i ON p.codproduto = i.fk_codproduto
            WHERE p.ativo = 'S'";
    $stmt = $pdo->prepare($sql);
}

// Certifique-se de que a variável $stmt foi inicializada
if ($stmt !== null && $stmt->execute()) {
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Erro na consulta ao banco de dados.";
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
s
        header h1 {
            font-size: 36px;
            margin-left: auto; /* Adiciona margem à esquerda */
            margin-right: 100;
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

        /* Rodapé */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px; /* Adiciona margem no topo */
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
                    <li><a href="telainicialadm.php">Início</a></li>
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

    <section class="featured-products">
        <h2 class="section-title">Produtos</h2>
        <div class="product-container">
            <?php foreach ($produtos as $produto) : ?>
                <div class="product-card">
                    <?php if (!empty($produto['produtoimg'])) : ?>
                        <img src="<?php echo $produto['produtoimg']; ?>" alt="Imagem do Produto">
                    <?php endif; ?>
                    <div class="product-details">
                        <h5 class="card-title"><?php echo $produto['nomeprod']; ?></h5>
                        <p class="card-text"><?php echo $produto['descricaoprod']; ?></p>
                        <p class="card-text">Preço: R$<?php echo number_format($produto['precoprod'], 2, ',', '.'); ?></p>
                        <button type="submit" class="buy-button">COMPRAR</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2023 STUDIOSBEN</p>
        </div>
    </footer>

</body>
</html>