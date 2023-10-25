<?php
//session_start();
include_once "conexao.php";

$pdo = conectar();

?>

<!DOCTYPE html>
<html lang="ptBR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/mask.js"></script>
</head>

<body>
<div class="container" >
    <a class="links" id="cadastrocliente.php"></a>

    <form>
    <h2>Login</h2>
    <form action="telainicial.php" method="POST">
        <label>Email</label>
        <input type="text" name="emailcli" placeholder="informe o email.">
        <br>
        <label>Senha</label>
        <input type="password" id="senhacli" name="senhacli" placeholder="Informe a senha.">
        <br>
        <br>
        <input type="submit" name="btnEntrar" value="Entrar">
        <input type="hidden" name="tp" value="x">
        
        <p class="link">  
                  Não tem uma conta?
                  <a href="cadastrocliente.php"> Ir para cadastro </a>
        </p>
    </form>
</body>

<?php

if (isset($_POST['Entrar'])) {
    
    $emailcli = $_POST['emailcli'];
    $senhacli = $_POST['senhacli'];

    if (empty($emailcli)) {
        echo "É necessário informar um email";
        exit();
    }
    if (empty($senhacli)) {
        echo "É necessário colocar uma senha";
        exit();
    }

    $stmt = $pdo->prepare($sql);

    // Associar os valores às variáveis na consulta SQL
    $stmt->bindParam (':emailcli', $emailcli);
    $stmt->bindParam (':senhacli', md5($senhacli));

    if ($stmt->execute()) {
        // Mensagem de erro
        echo "Senha ou Email incorretos, confira os dados!";
    }
}

?>




    