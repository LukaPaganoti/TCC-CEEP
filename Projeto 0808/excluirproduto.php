<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$codproduto = $_GET['cod'];

$sql = "DELETE FROM tb_produtos WHERE codprodutos = :cod";
$stmex = $pdo->prepare($sql);
$stmex->bindValue(":cod", $codprodutos);
$stmex->execute();

if ($stmex->rowCount() > 0) {
    echo '<script>alert("Produto excluído com sucesso!");</script>';
    echo '<script>location.href = "conproduto.php";</script>';
}
?>