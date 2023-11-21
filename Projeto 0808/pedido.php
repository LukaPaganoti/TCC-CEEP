<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

if (isset($_GET['codpedido'])) {
    $codpedido = $_GET['codpedido'];

    // Consulta SQL para obter os detalhes do pedido com base no ID
    $sql_pedido = "SELECT * FROM tb_pedidos WHERE codpedido = :codpedido";
    $stmt_pedido = $pdo->prepare($sql_pedido);
    $stmt_pedido->bindParam(':codpedido', $codpedido);
    $stmt_pedido->execute();
    $pedido = $stmt_pedido->fetch(PDO::FETCH_ASSOC);

    if (isset($_SESSION['codcliente'])) {
        $codcliente = $_SESSION['codcliente'];

        // Consulta SQL para obter os dados do endereço do cliente logado
        $sql_endereco_cliente = "SELECT * FROM tb_enderecos WHERE fk_codcliente = :fk_codcliente";
        $stmt_endereco_cliente = $pdo->prepare($sql_endereco_cliente);
        $stmt_endereco_cliente->bindParam(':fk_codcliente', $codcliente);
        $stmt_endereco_cliente->execute();
        $endereco_cliente = $stmt_endereco_cliente->fetch(PDO::FETCH_ASSOC);
    }
}

// Consulta SQL para obter os dados do cliente logado
if (isset($_SESSION['codcliente'])) {
    $codcliente = $_SESSION['codcliente'];
    $sql_cliente = "SELECT * FROM tb_clientes WHERE codcliente = :codcliente";
    $stmt_cliente = $pdo->prepare($sql_cliente);
    $stmt_cliente->bindParam(':codcliente', $codcliente);
    $stmt_cliente->execute();
    $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
}

// Adiciona os detalhes do carrinho de compras à tabela tb_pedidos_prod
if (isset($_POST['btnFinalizar'])) {
    $tipoped = $_POST['tipoped'];
    $pagamento = $_POST['pagamento'];
    $fk_codcliente = $_POST['fk_codcliente'];

    if (empty($tipoped) || empty($pagamento) || empty($fk_codcliente)) {
        echo "Preencha todos os campos.";
    } else {
        // Criação do pedido
        $sql_criar_pedido = "INSERT INTO tb_pedidos (fk_codcliente, tipoped, pagamento, valor_entrega) VALUES (:fk_codcliente, :tipoped, :pagamento, :valor_entrega)";
        $stmt_criar_pedido = $pdo->prepare($sql_criar_pedido);
        $stmt_criar_pedido->bindParam(':fk_codcliente', $fk_codcliente);
        $stmt_criar_pedido->bindParam(':tipoped', $tipoped);
        $stmt_criar_pedido->bindParam(':pagamento', $pagamento);
        $stmt_criar_pedido->bindValue(':valor_entrega', 0); // Defina o valor da entrega conforme necessário

        // Executa a inserção do pedido
        if ($stmt_criar_pedido->execute()) {
            // Recupera o ID do pedido recém-criado
            $codpedido = $pdo->lastInsertId();

            // Adiciona os produtos do carrinho à tabela tb_pedidos_prod
            foreach ($_SESSION['produto_prod'] as $codproduto => $item) {
                $quantidade = $item['quantidade'];
                $precoped = $item['precoprod'];

                // Insere os produtos na tabela tb_pedidos_prod
                $sql_inserir_produto = "INSERT INTO tb_pedidos_prod (fk_codpedido, fk_codproduto, quantidadeped, precoped) VALUES (:fk_codpedido, :fk_codproduto, :quantidadeped, :precoped)";
                $stmt_inserir_produto = $pdo->prepare($sql_inserir_produto);
                $stmt_inserir_produto->bindParam(':fk_codpedido', $codpedido);
                $stmt_inserir_produto->bindParam(':fk_codproduto', $codproduto);
                $stmt_inserir_produto->bindParam(':quantidadeped', $quantidade);
                $stmt_inserir_produto->bindParam(':precoped', $precoped);

                // Executa a inserção do produto
                $stmt_inserir_produto->execute();
            }

            // Limpa o carrinho após o pedido ser finalizado
            unset($_SESSION['produto_prod']);

            // Redireciona ou executa outras ações após o pedido ser finalizado
            header("Location: telainicial.php");
        } else {
            echo "Erro ao criar o pedido.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
    <title>Perfil do Cliente</title>
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
            <div class="icons">
                <div class="search-box">
                    <form method="get" action="" class="form-group search-box">
                        <input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o nome do produto">
                        <input type="submit" name="btnpesquisar" value="Pesquisar">
                    </form>
                    <div class="profile-dropdown">
                    <img src="perfil.png" alt="Perfil" id="profile-img">
                    <div class="dropdown-content" id="profile-dropdown-content">
                        <a href="login.php">Login</a>
                        <a href="perfil.php" onclick="redirectToProfile();">Meu Perfil</a>
<script>
    function redirectToProfile() {
        window.location.href = 'perfil.php';
    }
</script>
                        <a href="minhascompras.php">Minhas Compras</a>
                        <a href="logoff.php">Sair</a>
                    </div>
                </div>
                <a href="carrinhodecompras.php"><img src="imagens-de-carrinho-de-compras-png-4.png" alt="Carrinho" id="cart-icon"></a>
            </div>
        </div>
    </header>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferir detalhes do pedido</title>
</head>
<body>
    <br><br>
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Cliente</label>
        <select name="fk_codcliente">
            <?php
            // Se houver um cliente logado, mostre apenas esse cliente no dropdown
            if (isset($cliente)) {
                echo "<option value='{$cliente['codcliente']}' selected>{$cliente['nomecli']}</option>";
            }
            ?>
        </select>
        <br><br>
        <label>Endereço</label>
        <select name="fk_codendereco">
            <?php
            // Se houver um cliente logado, mostre os endereços desse cliente no dropdown
            if (isset($cliente)) {
                // Consulta SQL para obter os endereços do cliente logado
                $sql_enderecos_cliente = "SELECT * FROM tb_enderecos WHERE fk_codcliente = :fk_codcliente";
                $stmt_enderecos_cliente = $pdo->prepare($sql_enderecos_cliente);
                $stmt_enderecos_cliente->bindParam(':fk_codcliente', $cliente['codcliente']);
                $stmt_enderecos_cliente->execute();
                $enderecos_cliente = $stmt_enderecos_cliente->fetchAll(PDO::FETCH_ASSOC);

                // Exibe os endereços do cliente no dropdown
                foreach ($enderecos_cliente as $endereco) {
                    echo "<option value='{$endereco['codendereco']}'>{$endereco['ruaend']}, {$endereco['numeroend']} - {$endereco['bairroend']}</option>";
                }
            }
            ?>
        </select>
        <br><br>
        <label>Tipo de pedido</label>
        <select name="tipoped" required>
            <option value="1" <?php if (isset($pedido) && $pedido['tipoped'] == 1) echo 'selected'; ?>>Entrega</option>
            <option value="2" <?php if (isset($pedido) && $pedido['tipoped'] == 2) echo 'selected'; ?>>Retirada</option>
        </select>
        <br><br>
        <label>Forma de pagamento</label>
        <select name="pagamento" required>
            <option value="Pix" <?php if (isset($pedido) && $pedido['pagamento'] == 'Pix') echo 'selected'; ?>>A opção Pix não está disponível agora.</option>
            <option value="Dinheiro" <?php if (isset($pedido) && $pedido['pagamento'] == 'Dinheiro') echo 'selected'; ?>>Dinheiro</option>
        </select>
        <br><br>
        <!-- Substituído o botão de "Finalizar Pedido" por um botão de redirecionamento -->
        <a href="carrinhodecompras.php" class="btn-carrinho">Ver Carrinho</a>
    </form>
    <br><br>
</body>
</html>