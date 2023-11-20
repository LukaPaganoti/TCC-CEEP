<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$sql = "SELECT * FROM tb_pedidos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Pedidos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Pedidos</center>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>Codigo pedido</th>
            <th>Transporte</th>
            <th>Tipo de pedido</th>
            <th>Pagamento</th>
            <th>Valor da entrega</th>
            <th>Cliente</th>
        </tr>
        <?php foreach ($resultado as $r) { ?>
            <tr>
                <td><?php echo $r['codpedido']; ?></td>
                <td><?php echo $r['codtransporte']; ?></td>
                <td><?php echo $r['tipoped']; ?></td>
                <td><?php echo $r['pagamento']; ?></td>
                <td><?php echo $r['valor_entrega']; ?></td>
                <td><?php echo $r['fk_codcliente']; ?></td>
                <td><a href="pedido.php?cod=<?php echo $r['codpedido'] ?>" class="btn btn-warning"> ALTERAÇÃO</a> 
                - <a href="excluirpedido.php?cod=<?php echo $r['codpedido'] ?>" class="btn btn-danger">EXCLUSÃO</a> </td>
            </tr>

        <?php } ?>
    </table>
</body>

</html>