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
        <br>
        <label>Telefone:</label>
        <input type="text" name="telefonecli">
        <br>
        <label>CPF:</label>
        <input type="text" name="cpfcli">
        <br>     
        <label>Crie uma senha:</label>
        <input type="password" name="senhacli">
        <br>
        <label>Email:</label>
        <input type="text" name="emailcli">
        <br><br>
        <input type="submit" name="btncadastrar" value="Cadastrar" class="btn btn-dark">
    </form>
</body>
</html>

<?php
//fazer o teste se foi pressionado o botão
if (isset($_POST['btncadastrar'])) {

    // receba os dados do formulário
    // faça 1 para cada input
    $nomecli = $_POST['nomecli'];
    $telefonecli = $_POST['telefonecli'];
    $cpfcli = $_POST['cpfcli'];
    $senhacli = $_POST['senhacli'];
    $emailcli = $_POST['emailcli'];

    //validação simplificada - se o campo tá vazio
    if (empty($nomecli)) {
        echo "Necessário informar seu nome completo";
        exit();
    }   
    if (empty($telefonecli)) {
        echo "Necessário informar seu telefone";
        exit();
    }
    if (empty($cpfcli)) {
        echo "Necessário informar seu CPF";
        exit();
    }
    if (empty($senhacli)) {
        echo "Necessário criar uma senha";
        exit();
    }
    if (empty($emailcli)) {
        echo "Necessário informar um email";
        exit();
    }



    // criar o SQL de inserção
    $sql = "INSERT INTO tb_clientes (nomecli, telefonecli, cpfcli, senhacli, emaicli) VALUES (:nomecli, telefonecli, cpfcli, senhacli, emaicli)"; //variavel magica

    // preparar o SQL para execução (EVITA SQL INJECTION)
    $stmt = $pdo->prepare($sql);

    // trocar pelo valor da variavel magica pelo recebido via formulário
    $stmt->bindParam(':nomecli', $nomecli);
    $stmt->bindParam(':telefonecli', $telefonecli);
    $stmt->bindParam(':cpfcli', $cpfcli);
    $stmt->bindParam(':senhacli', $senhacli);
    $stmt->bindParam(':emailcli', $emailcli);

    // mandar realizar o codigo 
    if ($stmt->execute()) {
        //mostra mensagem de execução com sucesso
        echo "Cadastro concluido com sucesso!";
        // envio a execução para outra pagina
        // header("Location: telainicial.php");
    } else {
        echo "Erro ao cadastrar, confira seus dados novamente!";
    }
}
?>