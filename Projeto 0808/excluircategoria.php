<?php
include_once('conexao.php');

$pdo = conectar();

$cod = $_GET['cod'];

$sqlc = "SELECT * FROM tb_categorias WHERE codcategoria = :cod";
$stmc = $pdo->prepare($sqlc);
$stmc->bindParam(':cod', $cod);
$stmc->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h2>Excluir categorias</h2>
    <form method="POST">
        <div class="form-group">
            <label>Alterar descrição</label>
            <input type="text" name="descricao_alterada" value="<?php echo isset($re->descricaocat) ? $re->descricaocat : ''; ?>">
        </div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>
</html>

<?php
if ($stmc->rowCount() > 0) {

    $sqlex = "DELETE FROM tb_categorias WHERE codcategoria = :cod";

    $stmex = $pdo->prepare($sqlex);
    $stmex->bindParam(':cod', $cod);
    
    if ($stmex->execute()) {
        echo "Categoria excluída com sucesso!";
    } else {
        echo "Erro ao excluir categoria!";
    }
} else {
    echo "Categoria não encontrado!";
}

header('Location: concategoria.php');
?>