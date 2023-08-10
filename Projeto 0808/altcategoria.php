<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$cod = $_GET['cod'];

$sql = "SELECT * FROM tb_categorias WHERE codcategoria = :cod";

$stmc = $pdo->prepare($sql);
$stmc->bindParam(':cod', $cod);
$stmc->execute();

$re = $stmc->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Categorias</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>Alteração de Categorias</h2>
    <form method="POST">
        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="descricaocat_e" value="<?php echo $re->descricaocat; ?>">
        </div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>

</html>
<?php
if (isset($_POST['btnAlterar'])) {

    $descricaocat_e = $_POST['descricaocat_e'];

    if (empty($descricaocat_e)) {
        echo "Necessário informar a descricao da categoria";
        exit();
    }

    $sqlup = "UPDATE tb_categorias SET descricaocat = :descricaocat 
             WHERE codcategoria = :cod";

    $stmup = $pdo->prepare($sqlup);

    $stmup->bindParam(':descricaocat', $descricaocat_e);
    $stmup->bindParam(':cod', $cod);

    if ($stmup->execute()) {
        echo "Alterado com sucesso!";
        header("Location: concategoria.php");
    } else {
        echo "Erro ao alterar!";
    }
}

?>