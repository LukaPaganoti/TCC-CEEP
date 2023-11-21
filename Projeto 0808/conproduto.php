<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$sql = "SELECT * FROM tb_produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Produtos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        Listagem de Produtos
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>Cod</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Tamanho</th>
            <th>Peso</th>
            <th>Descrição</th>
            <th>Categoria</th>
        </tr>
        <?php foreach ($resultado as $r) { ?>
            <tr>
                <td><?php echo $r['codproduto']; ?></td>
                <td><?php echo $r['nomeprod']; ?></td>
                <td><?php echo $r['precoprod']; ?></td>
                <td><?php echo $r['tamanhoprod']; ?></td>
                <td><?php echo $r['pesoprod']; ?></td>
                <td><?php echo $r['descricaoprod']; ?></td>
                <td><?php echo $r['fk_codcategoria']; ?></td>
                <td><a href="alterarproduto.php?cod=<?php echo $r['codproduto'] ?>" class="btn btn-warning"> ALTERAÇÃO</a> 
                - <a href="excluirproduto.php?cod=<?php echo $r['codproduto'] ?>" class="btn btn-danger">EXCLUSÃO</a> </td>
            </tr>

        <?php } ?>
    </table>
</body>

</html>