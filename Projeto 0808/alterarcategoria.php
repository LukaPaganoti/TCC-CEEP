<?php
//session_start();
include_once('conexao.php');

$pdo = conectar();

    $codcategoria = $_GET['cod'];
    $sql = "SELECT * FROM tb_categorias WHERE codcategoria = :codcategoria ";
    
    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':codcategoria', $codcategoria);
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
    <title>Alterar Categorias</title>
</head>
<body>
    <h2>Alteração de Categorias</h2>
    <form method="POST" name="categoriaform">
        <div class="form-group">
            <label>Descrição da categoria:</label>
            <input type="text" name="descricao_editada" value="<?php echo htmlspecialchars($re->descricaocat); ?>">
        </div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>
</html>

<?php
if(isset($_POST['btnAlterar'])){
    $descricaocat = $_POST['descricao_editada'];

    if(empty($descricaocat)){
        echo "Necessário informar o campo obrigatório";
        exit();
    }

    $sqlup = "UPDATE tb_categorias SET descricaocat = :descricaocat WHERE codcategoria = :codcategoria";
    
    $stmt = $pdo->prepare($sqlup);

    $stmt->bindParam(':descricaocat', $descricaocat);
    $stmt->bindParam(':codcategoria', $codcategoria);


    if ($stmt->execute()) {
        echo "Alteração de categoria concluída com sucesso!";
        header("location:concategoria.php");
    } else {
        echo "Erro ao alterar categoria, confira os dados novamente!";
    }
}
?>
