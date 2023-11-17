<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$codendereco = $_GET['cod'];

$sql = "DELETE FROM tb_enderecos WHERE codendereco = :cod";
$stmex = $pdo->prepare($sql);
$stmex->bindValue(":cod", $codendereco);
$stmex->execute();

if ($stmex->rowCount() > 0) {
    echo '<script>alert("Endereço excluído com sucesso!");</script>';
    echo '<script>location.href = "conendereco.php";</script>';
}
?>
