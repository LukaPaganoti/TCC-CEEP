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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Adicione o link para o seu arquivo CSS -->
    <link rel="stylesheet" href="css/seuarquivocss.css">
</head>
<body>
    <header>
        <!-- Seu cabeçalho e barra de navegação aqui -->
    </header>
    <h1>Perfil do Cliente</h1>
    <p>Nome: <?php echo $nomecli; ?></p>
    <p>Email: <?php echo $emailcli; ?></p>
    <p>CPF: <?php echo $cpfcli; ?></p>
    <p>Telefone: <?php echo $telefonecli; ?></p>
    <!-- Adicione outras informações aqui, se necessário -->
</body>
</html>