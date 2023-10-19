<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$sql = "SELECT * FROM tb_imagens_prod";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Imagens</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        Listagem de Imagens
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>Imagem</th>
            <th>Produto</th>
        </tr>
        <?php foreach ($resultado as $r) { ?>
            <tr>
                <td><?php echo $r['produtoimg']; ?></td>
                <td><?php echo $r['fk_codproduto']; ?></td>
                <td><a href="alterarimg.php?cod=<?php echo $r['codimagem'] ?>" class="btn btn-warning"> ALTERAÇÃO</a> 
                - <a href="excluirimg.php?cod=<?php echo $r['codimagem'] ?>" class="btn btn-danger">EXCLUSÃO</a> </td>
            </tr>

        <?php } ?>
    </table>
</body>

</html>