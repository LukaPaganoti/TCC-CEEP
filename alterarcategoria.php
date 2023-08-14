<?php
//session_start();
include_once('conexao.php');

$pdo = conectar();

$codcategoria = $_GET['codcateegoria'];

$sql = "SELECT * FROM tb_categorias WHERE codcategoria = :codcategoria";

$stmc = $pdo->prepare($sql);
$stmc->bindParam(':codcategoria', $codcategoria);
$stmc->execute();

$re = $stmc->fetch(PDO::FETCH_OBJ);

/*
COMO USAR:
FETCH_ASSOC = $re['idcategoria']
FETCH_OBJ = $re->idcategoria
*/
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
            <input type="text" name="descricaocat" value="<?php echo $re->descricaocat; ?>">
        </div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>

</html>
<?php
// teste se botão foi pressionado
if (isset($_POST['btnAlterar'])) {

    //pego o valor do input (alterado ou não)
    $descricao_e = $_POST['descricaocat'];

    //verifico se tem conteudo

    if (empty($descricao_e)) {
        echo "Necessário informar a descricao da categoria";
        exit();
    }

    //crio o sql de alteração
    $sqlup = "UPDATE tb_categorias SET descricaocat = :descricaocat
    WHERE codcategoria = :codcategoria";

    //preparo do sql
    $stmup = $pdo->prepare($sqlup);

    // troco os parametros :descricao e :id
    $stmup->bindParam(':descricaocat', $descricao_e);
    $stmup->bindParam(':codcategoria', $codcategoria);

    //executo o sql
    if ($stmup->execute()) {
        echo "Alterado com sucesso!";
        header("Location: conproduto.php");
    } else {
        echo "Erro ao alterar!";
    }
}

?>
