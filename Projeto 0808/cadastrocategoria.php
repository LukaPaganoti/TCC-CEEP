<?php
session_start();
include_once('conexao.php');

$pdo = conectar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categoria</title>
</head>
<body>
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Descrição da categoria:</label>
        <input type="text" name="descricaocat">
        <br><br>
        <input type="submit" name="btncadastrarcategoria" value="Cadastrar categoria" class="btn btn-dark">
    </form>
</body>
</html>

<?php
// Se o botão "Cadastrar" foi pressionado
if (isset($_POST['btncadastrarcategoria'])) {
    // Receba os dados do formulário
    $descricaocat = $_POST['descricaocat'];

    // Validação simples
    if (empty($descricaocat)) {
        echo "É necessário informar uma descrição para a categoria";
        exit();
    }   

    // Criar a consulta SQL de inserção
    $sql = "INSERT INTO tb_categorias (descricaocat) VALUES (:descricaocat)";

    // Preparar a consulta SQL para execução
    $stmt = $pdo->prepare($sql);

    // Associar os valores às variáveis na consulta SQL
    $stmt->bindParam(':descricaocat', $descricaocat);

    // Executar a consulta SQL
    if ($stmt->execute()) {
        // Mensagem de cadastro bem-sucedido
        echo "Cadastro de categoria concluído com sucesso!";
    } else {
        // Mensagem de erro
        echo "Erro ao cadastrar, confira os dados novamente!";
    }
}
?>