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

if (isset($_POST['btncadastrarcategoria'])) {

    $descricaocat = $_POST['descricaocat'];


    if (empty($descricaocat)) {
        echo "É necessário informar uma descrição para a categoria";
        exit();
    }   


    $sql = "INSERT INTO tb_categorias (descricaocat) VALUES (:descricaocat)";


    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':descricaocat', $descricaocat);


    if ($stmt->execute()) {
        echo "Cadastro de categoria concluído com sucesso!";
    } else {
 
        echo "Erro ao cadastrar, confira os dados novamente!";
    }
}
?>