<?php
//session_start();
include_once "conexao.php";

$pdo = conectar();
$stmtc = $pdo->prepare($sqlc);
$stmtc->execute();
$dados = $stmtc->fetchAll(PDO::FETCH_ASSOC);
// FETCH_ASSOC  - $variavel['atributo'];
// FETCH_OBJ    - $variavel->atributo;

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
          <a class="links" id="login.php"></a>

    <h2>Cadastro</h2>
    <form action="telainicial.php" method="POST">
        <label>Nome</label>
        <input type="text" name="nomecli" placeholder="Informe o nome.">
        <label>Telefone</label>
        <input type="text" id="telefonecli" name="telefonecli" placeholder="Informe o telefone.">
        <br>
        <label>CPF</label>
        <input type="text" id="cpfcli" name="cpfcli" placeholder="Informe o CPF.">
        <br>
        <label>Senha</label>
        <input type="password" name="senhacli" placeholder="Informe a senha.">
        <br>
        <br>
        <label>Usuario</label>
        <input type="text" name="usuariocli" placeholder="Informe o um usuario.">
        <br>
        <label>Email</label>
        <input type="text" name="emailcli" placeholder="Informe o e-mail.">
        <br>

        <input type="submit" name="btnCadastrar" value="Cadastrar">
        <input type="hidden" name="tp" value="x">
        
        <p class="link">  
                  Já tem conta?
                  <a href="login.php"> Ir para Login </a>
        </p>
    </form>

    <form>
    <h2>Login</h2>
    <form action="telainicial.php" method="POST">
        <label>Email</label>
        <input type="text" name="emailcli" placeholder="informe o email.">
        <label>Senha</label>
        <input type="password" id="senhacli" name="senhacli" placeholder="Informe a senha.">
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


    
    // Implemente a lógica de login aqui, verifique se os dados são válidos e autentique o usuário
    // Redirecione o usuário para a página apropriada após o login
if (isset($_POST['Cadastrar'])) {
    // Receba os dados do formulário
    $nomecli = $_POST['nomecli'];
    $telefonecli = $_POST['telefonecli'];
    $cpfcli = $_POST['cpfcli'];
    $senhacli = $_POST['senhacli'];
    $usuariocli = $_POST['usuariocli'];
    $emailcli = $_POST['emailcli'];

    // Validação simples
    if (empty($nomecli)) {
        echo "É necessário informar seu nome completo";
        exit();
    }   
    if (empty($telefonecli)) {
        echo "É necessário informar seu telefone";
        exit();
    }
    if (empty($cpfcli)) {
        echo "É necessário informar seu CPF";
        exit();
    }
    if (empty($senhacli)) {
        echo "É necessário criar uma senha";
        exit();
    }
    if (empty($usuariocli)) {
        echo "É necessário criar um usuário";
        exit();
    }
    if (empty($emailcli)) {
        echo "É necessário informar um email";
        exit();
    }

    // Criar a consulta SQL de inserção
    $sql = "INSERT INTO tb_clientes (nomecli, telefonecli, cpfcli, senhacli, usuariocli, emailcli) VALUES (:nomecli, :telefonecli, :cpfcli, :senhacli, :usuariocli, :emailcli)";

    // Preparar a consulta SQL para execução
    $stmt = $pdo->prepare($sql);

    // Associar os valores às variáveis na consulta SQL
    $stmt->bindParam(':nomecli', $nomecli);
    $stmt->bindParam(':telefonecli', $telefonecli);
    $stmt->bindParam(':cpfcli', $cpfcli);
    $stmt->bindParam(':senhacli', $senhacli);
    $stmt->bindParam(':usuariocli', $usuariocli);
    $stmt->bindParam(':emailcli', $emailcli);

    // Executar a consulta SQL
    if ($stmt->execute()) {
        // Mensagem de cadastro bem-sucedido
        echo "Cadastro concluído com sucesso!";
    } else {
        // Mensagem de erro
        echo "Erro ao cadastrar, confira seus dados novamente!";
    }
}
}
?>