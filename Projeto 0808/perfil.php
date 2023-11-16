<?php
session_start();
include_once("conexao.php");

$pdo = conectar();

// Verifique se o cliente está autenticado
if (!isset($_SESSION['codcliente'])) {
    header("Location: login.php"); // Redirecione para a página de login se o cliente não estiver autenticado
    exit();
}

// Recupere o código do cliente a partir da sessão
$codcliente = $_SESSION['codcliente'];

// Consulta para obter informações do cliente
$stmt = $pdo->prepare("SELECT * FROM tb_clientes WHERE codcliente = :codcliente");
$stmt->bindParam(':codcliente', $codcliente);
$stmt->execute();
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cliente) {
    // Exiba as informações do cliente
    $nomecli = $cliente['nomecli'];
    $telefonecli = $cliente['telefonecli'];
    $cpfcli = $cliente['cpfcli'];
    $emailcli = $cliente['emailcli'];
    // Adicione outras informações, se necessário
} else {
    // Não foi possível encontrar informações do cliente
    echo "Não foi possível encontrar as informações do cliente.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* (estilos existentes) */

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
                    <li><a href="#">Contato</a></li>
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
                        <a href="login.php">Login</a>
                        <a href="perfil.php">Meu perfil</a>
                        <a href="carrinhodecompras.php">Minhas Compras</a>
                        <a href="logoff.php">Sair</a>
                    </div>
                </div>
                <a href="carrinhodecompras.php"><img src="imagens-de-carrinho-de-compras-png-4.png" alt="Carrinho" id="cart-icon"></a>
            </div>
        </div>
    </header>
    <footer>
        <div class="container">
            <p>&copy; 2023 STUDIOSBEN</p>
        </div>
    </footer>

    <script>
        document.getElementById("profile-img").addEventListener("click", function() {
            var dropdownContent = document.getElementById("profile-dropdown-content");
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    </script>
</body>
</html>