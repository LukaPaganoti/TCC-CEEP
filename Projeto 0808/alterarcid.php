<?php
//session_start();
include_once('conexao.php');

$pdo = conectar();

    $codcidade = $_GET['cod'];
    $sql = "SELECT * FROM tb_cidades WHERE codcidade = :codcidade ";
    
    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':codcidade', $codcidade);
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
    <title>Alterar Cidade</title>
</head>
<body>
    <h2>Alteração de Cidades</h2>
    <form method="POST" name="categoriaform">
        <div class="form-group">
            <label>Nome da cidade:</label>
            <input type="text" name="nomecid_editada" value="<?php echo htmlspecialchars($re->nomecid); ?>">
        </div>
        <div class="form-group">
        <label>Estado:</label>
            <input type="text" name="estadocid_editada" value="<?php echo htmlspecialchars($re->estadocid); ?>">
</div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>
</html>

<?php
if(isset($_POST['btnAlterar'])){
    $nomecid = $_POST['nomecid_editada'];
    $estadocid = $_POST['estadocid_editada'];

    if(empty($nomecid)){
        echo "Necessário informar o campo obrigatório";
        exit();
    }
    if(empty($estadocid)){
        echo "Necessário informar o campo obrigatório";
        exit();
    }

    $sqlup = "UPDATE tb_cidades SET nomecid = :nomecid, estadocid = :estadocid WHERE codcidade = :codcidade";
    
    $stmt = $pdo->prepare($sqlup);

    $stmt->bindParam(':nomecid', $nomecid);
    $stmt->bindParam(':estadocid', $estadocid);
    $stmt->bindParam(':codcidade', $codcidade);


    if ($stmt->execute()) {
        echo "Alteração de cidade concluída com sucesso!";
        header("location:concidade.php");
    } else {
        echo "Erro ao alterar cidade, confira os dados novamente!";
    }
}
?>
