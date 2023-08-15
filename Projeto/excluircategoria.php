<?php
include_once('conexao.php');

$pdo = conectar();

$cod = $_GET['cod'];

$sqlc = "SELECT * FROM tb_categorias WHERE codcategoria = :cod";
$stmc = $pdo->prepare($sqlc);
$stmc->bindParam(':cod', $cod);
$stmc->execute();

if ($stmc->rowCount() > 0) {
    $sqlex = "DELETE FROM tb_categorias WHERE codcategoria = $cod";
    $stmex = $pdo->query($sqlex);
    echo "Categoria excluída com sucesso!";
} else {
    echo "Categoria não encontrada!";
}

header('Location: concategoria.php')
?>