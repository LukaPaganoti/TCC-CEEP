<?php
include_once("conexao.php");

$pdo = conectar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Categoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>Cadastro de Categoria</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="descricaocat" class="form-control col-6" placeholder="Digite a descrição da categoria">
        </div>
        <button type="submit" name="btnSalvar" class="btn btn-primary">Salvar</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>

<?php
if (isset($_POST['btnSalvar'])) {

    $descricaocat = $_POST['descricaocat'];

    if (empty($descricaocat)) {
        echo "Necessário informar a descrição da categoria";
        exit();
    }

    $sql = "INSERT INTO tb_categorias (descricaocat) VALUES (:descricaocat)"; 

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':descricaocat', $descricaocat);

    if ($stmt->execute()) {
        echo "Categoria inserida com sucesso!";
    } else {
        echo "Erro ao inserir categoria";
    }
}
?>