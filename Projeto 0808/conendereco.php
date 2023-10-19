<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$sql = "SELECT * FROM tb_enderecos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Endereços</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Endereços</center>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>Rua</th>
            <th>CEP</th>
            <th>Número casa</th>
            <th>Bairro</th>
            <th>Complemento</th>
            <th>Cliente</th>
            <th>Cidade</th>
        </tr>
        <?php foreach ($resultado as $r) { ?>
            <tr>
                <td><?php echo $r['ruaend']; ?></td>
                <td><?php echo $r['cepend']; ?></td>
                <td><?php echo $r['numeroend']; ?></td>
                <td><?php echo $r['bairroend']; ?></td>
                <td><?php echo $r['complementoend']; ?></td>
                <td><?php echo $r['fk_codcidade']; ?></td>
                <td><?php echo $r['fk_codcidade']; ?></td>
                <td><a href="alterarendereco.php?cod=<?php echo $r['codendereco'] ?>" class="btn btn-warning"> ALTERAÇÃO</a> 
                - <a href="excluirendereco.php?cod=<?php echo $r['codendereco'] ?>" class="btn btn-danger">EXCLUSÃO</a> </td>
            </tr>

        <?php } ?>
    </table>
</body>

</html>