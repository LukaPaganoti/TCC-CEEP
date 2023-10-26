<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$sqlc = "SELECT * FROM tb_categorias";
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
    <title>Cadastro de produto</title>
</head>
<body>
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Nome do produto</label>
        <input type="text" name="nomeprod">
        <br><br>
        <label>Preço do produto</label>
        <input type="text" name="precoprod">
        <br><br>
        <label>Tamanho do produto</label>
        <input type="text" name="tamanhoprod">
        <br><br>
        <label>Peso do produto</label>
        <input type="text" name="pesoprod">
        <br><br>
        <label>Descrição do produto</label>
        <input type="text" name="descricaoprod">
        <br><br>
        <label>Selecione a categoria</label>
        <select name="fk_codcategoria">
            <?php foreach ($dados as $d) {
                echo "<option value='{$d['codcategoria']}'>{$d['descricaocat']}</option>";
            } ?>
        </select>
        <br><br>
        <input type="submit" name="btncadastrarproduto" value="Cadastrar produto" class="btn btn-dark">
    </form>
</body>
</html>

<?php
// Se o botão "Cadastrar" foi pressionado
if (isset($_POST['btncadastrarproduto'])) {
    // Receba os dados do formulário
    $nomeprod = $_POST['nomeprod'];
    $precoprod = $_POST['precoprod'];
    $tamanhoprod = $_POST['tamanhoprod'];
    $pesoprod = $_POST['pesoprod'];
    $descricaoprod = $_POST['descricaoprod'];
    $fk_codcategoria = $_POST['fk_codcategoria'];

    if (empty($nomeprod) || empty($precoprod) || empty($tamanhoprod) || empty($pesoprod) || empty($descricaoprod) || empty($fk_codcategoria)) {
        echo "Preencha todos os campos.";
    } else {
        // Criar a consulta SQL de inserção
        $sqlc = "INSERT INTO tb_produtos (nomeprod, precoprod, tamanhoprod, pesoprod, descricaoprod, fk_codcategoria) VALUES (:nomeprod, :precoprod, :tamanhoprod, :pesoprod, :descricaoprod, :fk_codcategoria)";

        // Preparar a consulta SQL para execução
        $stmt = $pdo->prepare($sqlc);

        // Associar os valores às variáveis na consulta SQL
        $stmt->bindParam(':nomeprod', $nomeprod);
        $stmt->bindParam(':precoprod', $precoprod);
        $stmt->bindParam(':tamanhoprod', $tamanhoprod);
        $stmt->bindParam(':pesoprod', $pesoprod);
        $stmt->bindParam(':descricaoprod', $descricaoprod);
        $stmt->bindParam(':fk_codcategoria', $fk_codcategoria);

        // Executar a consulta SQL
        if ($stmt->execute()) {
            // Mensagem de cadastro bem-sucedido
            echo "Cadastro de produto concluído com sucesso!";
        } else {
            // Mensagem de erro
            echo "Erro ao cadastrar, confira os dados novamente!";
        }
    }
}
?>
</body>
</html>