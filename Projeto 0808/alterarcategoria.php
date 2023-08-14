<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

if(isset($_GET['descricaocat'])){
    $descricaocat = $_GET['descricaocat'];

    $sql = "SELECT * FROM tb_categorias WHERE descricaocat = :descricaocat ";
    $stmc = $pdo->prepare($sql);
    $stmc->bindParam(':descricaocat', $descricaocat);
    $stmc->execute();

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<body>
    <h2>Alterar categorias</h2>
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
if (isset($_POST['btnAlterar'])) {
    $descricaocat = $_POST['descricao_alterada'];

    if (empty($descricaocat)) {
        echo "É necessário informar uma descrição para a categoria";
        exit();
    }   

    $sql = "UPDATE tb_categorias SET descricaocat = :nova_descricao WHERE descricaocat = :descricaocat";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nova_descricao', $descricaocat);
    $stmt->bindParam(':descricaocat', $descricaocat);

    if ($stmt->execute()) {
        echo "Categoria atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a categoria.";
    }
}
?>