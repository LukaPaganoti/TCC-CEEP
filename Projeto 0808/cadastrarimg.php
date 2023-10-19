<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$sqlc = "SELECT * FROM tb_produtos";
$stmtc = $pdo->prepare($sqlc);
$stmtc->execute();
$dados = $stmtc->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir imagens</title>
</head>
<body>
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Link da imagem:</label>
        <input type= "text" name= "produtoimg">
        <br><br>
        <label>Selecione o produto</name>
        <select name="fk_codproduto">
            <?php foreach ($dados as $d) {
                echo "<option value='{$d['codprodutos']}'>{$d['nomeprod']}</option>";
            } ?>
        </select>
        <br><br>
        <input type="submit" name="btninseririmagem" value="Inserir imagem" class="btn btn-dark">
        </form>
</body>
</html>

<?php
// Se o botão "Cadastrar" foi pressionado
if (isset($_POST['btninseririmagem'])) {
    // Receba os dados do formulário
    $produtoimg = $_POST['produtoimg'];
    $fk_codproduto = $_POST['fk_codproduto'];

    if (empty($produtoimg)) {
        echo "É necessário inserir uma imagem";
        exit();
    }   

    // Criar a consulta SQL de inserção
    $sqlc = "INSERT INTO tb_imagens_prod (produtoimg, fk_codproduto) VALUES (:produtoimg, :fk_codproduto)";

    // Preparar a consulta SQL para execução
    $stmt = $pdo->prepare($sqlc);

    // Associar os valores às variáveis na consulta SQL
    $stmt->bindParam(':produtoimg', $produtoimg);
    $stmt->bindParam(':fk_codproduto', $fk_codproduto);

    // Executar a consulta SQL
    if ($stmt->execute()) {
        // Mensagem de cadastro bem-sucedido
        echo "Imagem inserida com sucesso!";
    } else {
        // Mensagem de erro
        echo "Erro ao inserir a imagem, confira os dados!";
    }
}
?>
</body>
</html>