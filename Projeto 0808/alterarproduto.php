<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$codproduto = $_GET['cod'];

$sql = "SELECT * FROM tb_produtos WHERE codproduto = :cod";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":cod", $codproduto);
$stmt->execute();

$resultados = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultados) { // Verifica se há resultados
    // Se houver resultados, exiba o formulário de edição
    // ... (seu código HTML para o formulário de edição continua aqui)
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
            <input type="text" name="tamanho_editado" value="<?php echo htmlspecialchars($resultados['tamanhoprod']); ?>">
            <br><br>
            <label>Alterar peso:</label>
            <input type="text" name="peso_editado" value="<?php echo htmlspecialchars($resultados['pesoprod']); ?>">
            <br><br>
            <label>Alterar descrição:</label>
            <input type="text" name="descricao_editado" value="<?php echo htmlspecialchars($resultados['descricaoprod']); ?>">
            <br><br>
            <label>Alterar categoria</label>
            <select name="fk_codcategoria">
                <option>Selecione</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria['codcategoria']; ?>" <?php if ($categoria['codcategoria'] == $resultados['fk_codcategoria']) echo 'selected'; ?>>
                        <?php echo $categoria['descricaocat']; ?>
                    </option>
                <?php } ?>
            </select>
            <br><br>
            <input type="submit" name="btnAlterar" value="Alterar">
        </div>
    </form>
</body>
</html>
<?php
} else {
    // Se não houver resultados, exiba uma mensagem de erro
    echo "Produto não encontrado.";
}

if(isset($_POST['btnAlterar'])){
    $nomeprod = $_POST['nome_editado'];
    $precoprod = $_POST['preco_editado'];
    $tamanhoprod = $_POST['tamanho_editado'];
    $pesoprod = $_POST['peso_editado'];
    $descricaoprod = $_POST['descricao_editado'];
    $fk_codcategoria = $_POST['fk_codcategoria'];

    // Verifica se a categoria selecionada existe
    $sqlCategoria = "SELECT * FROM tb_categorias WHERE codcategoria = :fk_codcategoria";
    $stmtCategoria = $pdo->prepare($sqlCategoria);
    $stmtCategoria->bindParam(':fk_codcategoria', $fk_codcategoria);
    $stmtCategoria->execute();
    $categoriaExistente = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

    if (!$categoriaExistente) {
        echo "Categoria selecionada não existe.";
    } else {
        $sqlup = "UPDATE tb_produtos SET nomeprod = :nomeprod, precoprod = :precoprod, tamanhoprod = :tamanhoprod, pesoprod = :pesoprod, descricaoprod = :descricaoprod, fk_codcategoria = :fk_codcategoria WHERE codproduto = :codproduto";

        $stmt = $pdo->prepare($sqlup);

        $stmt->bindParam(':nomeprod', $nomeprod);
        $stmt->bindParam(':precoprod', $precoprod);
        $stmt->bindParam(':tamanhoprod', $tamanhoprod);
        $stmt->bindParam(':pesoprod', $pesoprod);
        $stmt->bindParam(':descricaoprod', $descricaoprod);
        $stmt->bindParam(':fk_codcategoria', $fk_codcategoria);
        $stmt->bindParam(':codproduto', $codproduto);

        if ($stmt->execute()) {
            echo "Alteração de produto concluída com sucesso!";
            // Redireciona após a operação
            header("Location: conproduto.php");
            exit();
        } else {
            echo "Erro ao alterar, confira os dados novamente!";
    }
}
}
?>