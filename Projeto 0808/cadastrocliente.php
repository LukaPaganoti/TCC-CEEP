<?php
session_start();
include_once('conexao.php');

$pdo = conectar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Nome completo:</label>
        <input type="text" name="nomecli">
        <br><br>
        <label>Telefone:</label>
        <input type="text" name="telefonecli">
        <br><br>
        <label>CPF:</label>
        <input type="text" name="cpfcli">
        <br><br>
        <label>Crie uma senha:</label>
        <input type="password" name="senhacli">
        <br><br>
        <label>Crie um usuario:</label>
        <input type="text" name="usuariocli">
        <br><br>
        <label>Email:</label>
        <input type="text" name="emailcli">
        <br><br>
        <input type="submit" name="btncadastrar" value="Cadastrar" class="btn btn-dark">
    </form>
</body>
</html>

<?php
// Se o botão "Cadastrar" foi pressionado
if (isset($_POST['btncadastrar'])) {
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
        echo "É necessário criar um usuario";
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
?>