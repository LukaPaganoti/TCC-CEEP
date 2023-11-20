<?php
include_once('conexao.php');

$pdo = conectar();

$cod = $_GET['cod'];

$sqlc = "SELECT * FROM tb_cidades WHERE codcidades = :cod";
$stmc = $pdo->prepare($sqlc);
$stmc->bindParam(':cod', $cod);
$stmc->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h2>Excluir cidade</h2>
    <form method="POST">
        <div class="form-group">
            <label>Excluir cidade</label>
            <input type="text" name="cidade_alterada" value="<?php echo isset($re->nomecid) ? $re->nomecid : ''; ?>">
        </div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>
</html>

<?php
if ($stmc->rowCount() > 0) {

    $sqlex = "DELETE FROM tb_cidades WHERE codcidades = :cod";

    $stmex = $pdo->prepare($sqlex);
    $stmex->bindParam(':cod', $cod);
    
    if ($stmex->execute()) {
        echo "Cidade excluída com sucesso!";
    } else {
        echo "Erro ao excluir cidade!";
    }
} else {
    echo "Cidade não encontrada!";
}

header('Location: concidade.php');
?>