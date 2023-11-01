<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$codimagem = $_GET['cod'];

$sql = "SELECT * FROM tb_imagens_prod WHERE codimagem = :cod"; // Mude de 'codprodutos' para 'codproduto'

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":cod", $codimagem);
$stmt->execute();

$resultados = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlc = "SELECT * FROM tb_produtos";
$stmtc = $pdo->prepare($sqlc);
$stmtc->execute();
$produtos = $stmtc->fetchAll(PDO::FETCH_ASSOC); // Mude de 'cidades' para 'categoria'

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Alterar Imagem</title>
</head>
<body>
    <h2>Alteração de Imagem</h2>
    <form method="POST" name="produtosform">
        <div class="form-group">
            <label>Alterar imagem:</label>
            <input type="text" name="img_editada" value="<?php echo htmlspecialchars($resultados['produtoimg']); ?>">
            <br><br>
            <br><br>
            <label>Selecione o produto</label>
            <select name="fk_codproduto">
                <option>Selecione</option>
                <?php foreach ($produto as $p) { ?>
                    <option value="<?php echo $p['codproduto']; ?>"><?php echo $p['nomeprod']; ?></option>
                <?php } ?>
            </select>
            <br>
            <input type="submit" name="btnAlterar" value="Alterar">
        </div>
    </form>
</body>
</html>

<?php
if(isset($_POST['btnAlterar'])){
    $produtoimg = $_POST['imagem_editada'];
    $fk_codproduto = $_POST['fk_codproduto'];

    $sqlup = "UPDATE tb_imagens_prod SET produtoimg = :produtoimg, fk_codproduto = :fk_codproduto WHERE codimagem = :codimagem"; // Mude de 'codprodutos' para 'codproduto'
    
    $stmt = $pdo->prepare($sqlup);

    $stmt->bindParam(':produtoimg', $produtoimg);
    $stmt->bindParam(':fk_codproduto', $fk_codproduto);
    $stmt->bindParam(':codimagem', $codimagem); // Mude de 'codprodutos' para 'codproduto'

    if ($stmt->execute()) {
        echo "Alteração de imagem concluída com sucesso!";
        // Redireciona após a operação
        header("Location: conimg.php");
        exit(); // Encerre o script para garantir que a página de redirecionamento funcione corretamente
    } else {
        echo "Erro ao alterar, confira os dados novamente!";
    }
}
?>
