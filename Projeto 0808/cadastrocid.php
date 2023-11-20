<?php
session_start();
include_once "conexao.php";
$pdo = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomecid = $_POST['nomecid'];
    $estadocid = $_POST['estadocid'];


    $query = "INSERT INTO tb_cidades (nomecid, estadocid) VALUES ('$nomecid', '$estadocid')";
    $resultado = $pdo->query($query);

    if ($resultado) {
        echo "Cadastro concluído com sucesso!";
    } else {
        echo "Erro ao cadastrar, confira seus dados novamente!";
    }
}
?>

<!DOCTYPE html>
<html lang="ptBR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cidades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/mask.js"></script>
</head>

<body>
<div class="container">
    <h2>Cadastro</h2>
    <form action="cadastrocid.php" method="POST">
        <label>Nome da cidade</label>
        <input type="text" name="nomecid" placeholder="Informe o nome da cidade">
        <br>
        <label>Estado</label>
        <input type="text" id="estadocid" name="estadocid" placeholder="Informe estado">
        <br>
        <br>
        <input type="submit" name="btnCadastrar" value="Cadastrar">
    </form>
</div>
</body>
</html>