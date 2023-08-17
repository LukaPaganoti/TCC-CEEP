<?php
//session_start();
include_once('conexao.php');

$pdo = conectar();

    $codcliente = $_GET['cod'];
    $sql = "SELECT * FROM tb_clientes WHERE codcliente = :codcliente ";
    
    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':codcacliente', $codcliente);
    $stmc->execute();
    $re = $stmc->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Alterar Dados</title>
</head>
<body>
    <h2>Alteração Dados</h2>
    <form method="POST" name="clienteform">
        <div class="form-group">
            <label>Alterar Nome:</label>
            <input type="text" name="nome_editado" value="<?php echo htmlspecialchars($re->nomecli); ?>">
            <label>Alterar Telefone:</label>
            <input type="text" name="telefone_editado" value="<?php echo htmlspecialchars($re->telefonecli); ?>">
            <label>Alterar CPF:</label>
            <input type="text" name="cpf_editado" value="<?php echo htmlspecialchars($re->cpfcli); ?>">
            <label>Alterar a senha:</label>
            <input type="text" name="senha_editada" value="<?php echo htmlspecialchars($re->senhacli); ?>">
            <label>Alterar usuario:</label>
            <input type="text" name="usuario_editado" value="<?php echo htmlspecialchars($re->usuariocli); ?>">
            <label>Alterar email:/label>
            <input type="text" name="email_editado" value="<?php echo htmlspecialchars($re->emailcli); ?>">
        </div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>
</html>

<?php
if(isset($_POST['btnAlterar'])){
    $nomecli = $_POST['nome_editado'];
    $telefonecli = $_POST['telefone_editado'];
    $cpfcli = $_POST['cpf_edtitado'];
    $senhacli = $_POST['senha_editada'];
    $usuariocli = $_POST['usuario_edtitado'];
    $emailcli = $_POST['email_editado'];


    $sqlup = "UPDATE tb_clientes SET nomecli = :nomecli WHERE codcliente = :codcliente";
    $sqlup = "UPDATE tb_clientes SET telefonecli = :telefonecli WHERE codcliente = :codcliente";
    $sqlup = "UPDATE tb_clientes SET cpfcli = :cpfcli WHERE codcliente = :codcliente";
    $sqlup = "UPDATE tb_clientes SET senhacli = :senhacli WHERE codcliente = :codcliente";
    $sqlup = "UPDATE tb_clientes SET usuariocli = :usuariocli WHERE codcliente = :codcliente";
    $sqlup = "UPDATE tb_clientes SET emailcli = :emailcli WHERE codcliente = :codcliente";
    
    $stmt = $pdo->prepare($sqlup);

    $stmt->bindParam(':nomecli', $nomecli);
    $stmt->bindParam(':telefonecli', $telefonecli);
    $stmt->bindParam(':cpfcli', $cpfcli);
    $stmt->bindParam(':senhacli', $senhacli);
    $stmt->bindParam(':usuariocli', $usuariocli);
    $stmt->bindParam(':emailcli', $emailcli);
    $stmt->bindParam(':codcliente', $codcliente);


    if ($stmt->execute()) {
        echo "Alteração de dados concluída com sucesso!";
        header("location:concliente.php");
    } else {
        echo "Erro ao alterar, confira os dados novamente!";
    }
}
?>
