<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$codpedido = $_GET['cod'];

$sql = "DELETE FROM tb_pedidos WHERE codpedido = :cod";
$stmex = $pdo->prepare($sql);
$stmex->bindValue(":cod", $codpedido);
$stmex->execute();

if ($stmex->rowCount() > 0) {
    echo '<script>alert("Pedido excluído com sucesso!");</script>';
    echo '<script>location.href = "conpedido.php";</script>';
}
?>