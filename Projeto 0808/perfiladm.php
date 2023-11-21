<?php
session_start();
include_once 'conexao.php';

// Verifique se o cliente está logado
if (!isset($_SESSION['codcliente'])) {
    // Se não estiver logado, redirecione para a página de login
    header("Location: login.php");
    exit();
}

// Estabeleça a conexão com o banco de dados
$pdo = conectar();

// Recupere o código do cliente a partir da sessão
$codcliente = $_SESSION['codcliente'];

// Consulta para obter informações do cliente, endereço e cidade
$stmt = $pdo->prepare("SELECT c.*, e.*, cid.nomecid AS nomecid, cid.estadocid AS estadocid
                      FROM tb_clientes c
                      LEFT JOIN tb_enderecos e ON c.codcliente = e.fk_codcliente
                      LEFT JOIN tb_cidades cid ON e.fk_codcidade = cid.codcidade
                      WHERE c.codcliente = :codcliente");

$stmt->bindParam(':codcliente', $codcliente, PDO::PARAM_INT);

try {
    $stmt->execute();

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        // Exiba as informações do cliente, endereço e cidade
        $nomecli = $cliente['nomecli'];
        $telefonecli = $cliente['telefonecli'];
        $cpfcli = $cliente['cpfcli'];
        $emailcli = $cliente['emailcli'];

        // Informações do endereço
        $cepend = $cliente['cepend'];
        $numeroend = $cliente['numeroend'];
        $bairroend = $cliente['bairroend'];
        $ruaend = $cliente['ruaend'];
        $complementoend = $cliente['complementoend'];
        
        // Informações da cidade
        $nomecid = $cliente['nomecid'];
        $estadocid = $cliente['estadocid'];
        // Adicione outras informações, se necessário
    } else {
        echo "Não foi possível encontrar as informações do cliente, endereço e cidade.";
    }
} catch (PDOException $e) {
    echo "Erro na consulta ao banco de dados: " . $e->getMessage();
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
                    <li><a href="consultas.php">Consultas</a></li>
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
                        <a href="perfiladm.php" onclick="redirectToProfile();">Meu Perfil</a>
<script>
    function redirectToProfile() {
        window.location.href = 'perfiladm.php';
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
    
    <div class="container">
    <?php if (isset($nomecli)) : ?>
        <h1>Perfil do Cliente</h1>
        <p>Nome: <?php echo $nomecli; ?></p>
        <p>Email: <?php echo $emailcli; ?></p>
        <p>CPF: <?php echo $cpfcli; ?></p>
        <p>Telefone: <?php echo $telefonecli; ?></p>
        <a href="alterarcliente.php">Alterar dados</a>
        <br><br>
        <!-- Informações do endereço -->
        <h2>Endereços</h2>

        <?php
        // Consulta para obter todos os endereços do cliente
        $stmtEnderecos = $pdo->prepare("SELECT * FROM tb_enderecos WHERE fk_codcliente = :codcliente");
        $stmtEnderecos->bindParam(':codcliente', $codcliente, PDO::PARAM_INT);

        try {
            $stmtEnderecos->execute();
            $enderecos = $stmtEnderecos->fetchAll(PDO::FETCH_ASSOC);

            if ($enderecos) {
                foreach ($enderecos as $endereco) {
                    echo "<p>CEP: {$endereco['cepend']}</p>";
                    echo "<p>Número: {$endereco['numeroend']}</p>";
                    echo "<p>Bairro: {$endereco['bairroend']}</p>";
                    echo "<p>Rua: {$endereco['ruaend']}</p>";
                    echo "<p>Complemento: {$endereco['complementoend']}</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p>Nenhum endereço cadastrado.</p>";
            }
        } catch (PDOException $e) {
            echo "Erro na consulta ao banco de dados: " . $e->getMessage();
        }
        ?>
        <a href="alterarendeco.php">Alterar endereço</a>
        <a href="cadastroendereco.php">Cadastrar endereço</a>
        <br><br>
        <!-- Informações da cidade -->
        <h2>Cidade</h2>
        <p>Cidade: <?php echo $cliente['nomecid']; ?></p>
        <p>Estado: <?php echo $cliente['estadocid']; ?></p>
        <a href="alterarcid.php">Alterar cidade</a>
        <br><br>
    <?php else : ?>
        <p>Não foi possível carregar as informações do cliente.</p>
    <?php endif; ?>
</div>

    <footer>
        <div class="container">
            <p>&copy; 2023 STUDIOSBEN</p>
        </div>
    </footer>

    <!-- Adicione seus scripts JavaScript abaixo, se necessário -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-J6fR5VnWlC9uNUo7UHw6P2nYVdOUl4A7RS6Xq0Y9Jw9q5JqgPrxK8LlOZg6I5qwC" crossorigin="anonymous"></script>
    <!-- Adicione seus próprios scripts abaixo, se necessário -->
</body>
</html>