<?php
session_start();
include_once "conexao.php";
$pdo = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomecli = $_POST['nomecli'];
    $telefonecli = $_POST['telefonecli'];
    $cpfcli = $_POST['cpfcli'];
    $senhacli = md5($_POST['senhacli']); // Criptografa a senha com MD5
    $usuariocli = $_POST['usuariocli'];
    $emailcli = $_POST['emailcli'];

    $query = "INSERT INTO tb_clientes (nomecli, telefonecli, cpfcli, senhacli, usuariocli, emailcli) VALUES ('$nomecli', '$telefonecli', '$cpfcli', '$senhacli', '$usuariocli', '$emailcli')";
    $resultado = $pdo->query($query);

    if ($resultado) {
        echo "Cadastro concluído com sucesso!";
    } else {
        echo "Erro ao cadastrar, confira seus dados novamente!";
    }
}
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
<div class="container">
    <h2>Cadastro</h2>
    <form action="cadastrocliente.php" method="POST">
        <label>Nome</label>
        <input type="text" name="nomecli" placeholder="Informe o nome.">
        <br>
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
        <br>
        <input type="submit" name="btnCadastrar" value="Cadastrar">
    </form>
</div>
</body>
</html>