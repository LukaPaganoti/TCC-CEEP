<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$sql = "SELECT * FROM tb_clientes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>
        <center>Listagem de Clientes</center>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>Cod</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>CPF</th>
            <th>Usuario</th>
            <th>Tipo</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($resultado as $r) { ?>
            <tr>
                <td><?php echo $r['codcliente']; ?></td>
                <td><?php echo $r['nomecli']; ?></td>
                <td><?php echo $r['telefonecli']; ?></td>
                <td><?php echo $r['cpfcli']; ?></td>
                <td><?php echo $r['usuariocli']; ?></td>
                <td><?php echo $r['tipocadastro']; ?></td>
                <td><?php echo $r['ativo']; ?></td>
                <td><a href="alterarcliente.php?cod=<?php echo $r['codcliente'] ?>" class="btn btn-warning"> ALTERAÇÃO</a> 
                - <a href="excluircliente.php?cod=<?php echo $r['codcliente'] ?>" class="btn btn-danger">EXCLUSÃO</a> </td>
            </tr>

        <?php } ?>
    </table>
</body>

</html>