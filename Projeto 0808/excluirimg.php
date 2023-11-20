<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$codimagem = $_GET['cod'];

$sql = "DELETE FROM tb_imagens_prod WHERE codimagem = :cod";
$stmex = $pdo->prepare($sql);
$stmex->bindValue(":cod", $codimagem);
$stmex->execute();

if ($stmex->rowCount() > 0) {
    echo '<script>alert("Imagem excluída com sucesso!");</script>';
    echo '<script>location.href = "conimg.php";</script>';
}
?>