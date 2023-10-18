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
    <a class "links" id="login.php"></a>
    
    <!-- Formulário de Cadastro -->
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
        <label>Usuário</label>
        <input type="text" name="usuariocli" placeholder="Informe o um usuário.">
        <br>
        <label>Email</label>
        <input type="text" name="emailcli" placeholder="Informe o e-mail.">
        <br>
        <input type="submit" name="btnCadastrar" value="Cadastrar">
    </form>

</body>

<?php

    if (isset($_POST['btnCadastrar'])) {
        // Lógica de cadastro
        $nomecli = $_POST['nomecli'];
        $telefonecli = $_POST['telefonecli'];
        $cpfcli = $_POST['cpfcli'];
        $senhacli = $_POST['senhacli'];
        $usuariocli = $_POST['usuariocli'];
        $emailcli = $_POST['emailcli'];
    
        if (empty($nomecli) || empty($telefonecli) || empty($cpfcli) || empty($senhacli) || empty($usuariocli) || empty($emailcli)) {
            echo "Preencha todos os campos.";
        } else {
            // Criar a consulta SQL de inserção
            $sql = "INSERT INTO tb_clientes (nomecli, telefonecli, cpfcli, senhacli, usuariocli, emailcli) VALUES (:nomecli, :telefonecli, :cpfcli, :senhacli, :usuariocli, :emailcli)";
    
            // Preparar a consulta SQL para execução
            $stmt = $pdo->prepare($sql);
    
            // Associar os valores às variáveis na consulta SQL
            $stmt->bindParam (':nomecli', $nomecli);
            $stmt->bindParam (':telefonecli', $telefonecli);
            $stmt->bindParam (':cpfcli', $cpfcli);
            $stmt->bindParam (':senhacli', md5($senhacli));
            $stmt->bindParam (':usuariocli', $usuariocli);
            $stmt->bindParam (':emailcli', $emailcli);
    
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