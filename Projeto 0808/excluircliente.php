<?php
include_once('conexao.php');

$pdo = conectar();

$cod = $_GET['cod'];

$sqlc = "SELECT * FROM tb_clientes WHERE codcliente = :cod";
$stmc = $pdo->prepare($sqlc);
$stmc->bindParam(':cod', $cod);
$stmc->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h2>Excluir clientes</h2>
    <form method="POST">
        <div class="form-group">
            <label>Excluir clientes</label>
            <input type="text" name="cliente_alterado" value="<?php echo isset($re->nomecli) ? $re->nomecli : ''; ?>">
        </div>
        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>
</html>

<?php
if ($stmc->rowCount() > 0) {

    $sqlex = "DELETE FROM tb_clientes WHERE codcliente = :cod";

    $stmex = $pdo->prepare($sqlex);
    $stmex->bindParam(':cod', $cod);
    
    if ($stmex->execute()) {
        echo "Cliente excluído com sucesso!";
    } else {
        echo "Erro ao excluir cliente!";
    }
} else {
    echo "Cliente não encontrado!";
}

header('Location: concliente.php');
?>