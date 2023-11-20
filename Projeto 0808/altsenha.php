<?php
//session_start();
include_once('conexao.php');

$pdo = conectar();

// Verifica se o parâmetro 'cod' está presente na URL
if (isset($_GET['cod'])) {
    $codcliente = $_GET['cod'];

    $sql = "SELECT * FROM tb_clientes WHERE codcliente = :codcliente ";

    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':codcliente', $codcliente);
    $stmc->execute();
    $re = $stmc->fetch(PDO::FETCH_OBJ);

    // Se não houver resultados, redirecione para uma página de erro ou trate de acordo
    if (!$re) {
        echo "Cliente não encontrado.";
        exit();
    }
}
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
            <label>Alterar a senha:</label>
            <input type="text" name="senha_editada" value="<?php echo isset($re->senhacli) ? htmlspecialchars($re->senhacli) : ''; ?>">
            <br><br>
        </div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>
</html>

<?php
if (isset($_POST['btnAlterar'])) {
    $senhacli = $_POST['senha_editada'];

    $sqlup = "UPDATE tb_clientes SET senhacli = :senhacli WHERE codcliente = :codcliente";
    
    $stmt = $pdo->prepare($sqlup);

    $stmt->bindParam(':senhacli', $senhacli);
    $stmt->bindParam(':codcliente', $codcliente);

    if ($stmt->execute()) {
        echo "Alteração de senha concluída com sucesso!";
        header("location: concliente.php");
    } else {
        echo "Erro ao alterar, confira os dados novamente!";
    }
}
?>
