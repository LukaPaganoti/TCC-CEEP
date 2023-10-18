<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$codprodutos = $_GET['cod'];

$sql = "SELECT * FROM tb_produtos WHERE codproduto = :cod"; // Mude de 'codprodutos' para 'codproduto'

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":cod", $codprodutos);
$stmt->execute();

$resultados = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlc = "SELECT * FROM tb_produtos";
$stmtc = $pdo->prepare($sqlc);
$stmtc->execute();
$categoria = $stmtc->fetchAll(PDO::FETCH_ASSOC); // Mude de 'cidades' para 'categoria'

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Alterar Produtos</title>
</head>
<body>
    <h2>Alteração de Produtos</h2>
    <form method="POST" name="produtosform">
        <div class="form-group">
            <label>Alterar nome:</label>
            <input type="text" name="nome_editado" value="<?php echo htmlspecialchars($resultados['nomeprod']); ?>">
            <br><br>
            <label>Alterar preço:</label>
            <input type="text" name="preco_editado" value="<?php echo htmlspecialchars($resultados['precoprod']); ?>">
            <br><br>
            <label>Alterar tamanho:</label>
            <input type="text" name "tamanho_editado" value="<?php echo htmlspecialchars($resultados['tamanhoprod']); ?>">
            <br><br>
            <label>Alterar peso:</label>
            <input type="text" name="peso_editado" value="<?php echo htmlspecialchars($resultados['pesoprod']); ?>">
            <br><br>
            <label>Alterar descrição:</label>
            <input type="text" name="descricao_editada" value="<?php echo htmlspecialchars($resultados['descricaoprod']); ?>">
            <br><br>
            <label>Categoria</label>
            <select name="fk_codcategorias">
                <option>Selecione</option>
                <?php foreach ($categoria as $c) { ?>
                    <option value="<?php echo $c['codcategoria']; ?>"><?php echo $c['descricaocategoria']; ?></option>
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
    $nomeprod = $_POST['nome_editado'];
    $precoprod = $_POST['preco_editado'];
    $tamanhoprod = $_POST['tamanho_editado']; // Corrija o nome da variável
    $pesoprod = $_POST['peso_editado'];
    $descricaoprod = $_POST['descricao_editado'];
    $fk_codcategorias = $_POST['fk_codcategorias'];

    $sqlup = "UPDATE tb_produtos SET nomeprod = :nomeprod, precoprod = :precoprod, tamanhoprod = :tamanhoprod, pesoprod = :pesoprod, descricaoprod = :descricaoprod, fk_codcategorias = :fk_codcategorias WHERE codproduto = :codproduto"; // Mude de 'codprodutos' para 'codproduto'
    
    $stmt = $pdo->prepare($sqlup);

    $stmt->bindParam(':nomeprod', $nomeprod);
    $stmt->bindParam(':precoprod', $precoprod);
    $stmt->bindParam(':tamanhoprod', $tamanhoprod);
    $stmt->bindParam(':pesoprod', $pesoprod);
    $stmt->bindParam(':descricaoprod', $descricaoprod);
    $stmt->bindParam(':fk_codcategorias', $fk_codcategorias);
    $stmt->bindParam(':codproduto', $codproduto); // Mude de 'codprodutos' para 'codproduto'

    if ($stmt->execute()) {
        echo "Alteração de produto concluída com sucesso!";
        // Redireciona após a operação
        header("Location: conproduto.php");
        exit(); // Encerre o script para garantir que a página de redirecionamento funcione corretamente
    } else {
        echo "Erro ao alterar, confira os dados novamente!";
    }
}
?>
