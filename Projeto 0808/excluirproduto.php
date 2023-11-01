<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$codproduto = $_GET['cod']; // Altere de 'codprodutos' para 'codproduto'

$sql = "DELETE FROM tb_produtos WHERE codproduto = :cod"; // Altere de 'codprodutos' para 'codproduto'
$stmex = $pdo->prepare($sql);
$stmex->bindValue(":cod", $codproduto); // Altere de 'codprodutos' para 'codproduto'
$stmex->execute();

if ($stmex->rowCount() > 0) {
    echo '<script>alert("Produto excluído com sucesso!");</script>';
    echo '<script>location.href = "conproduto.php";</script>';
}
?>