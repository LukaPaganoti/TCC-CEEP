<?php
//session_start();
include_once('conexao.php');

$pdo = conectar();

$codcategoria = $_GET['codcategoria'];

$sqlc = "SELECT * FROM tb_categorias WHERE codcategoria = :codcategoria";
$stmc = $pdo->prepare($sqlc);
$stmc->bindParam(':codcategoria', $codcategoria);
$stmc->execute();

if ($stmc->rowCount() > 0) {
    $sqlex = "DELETE FROM tb_categorias WHERE codcategoria = :codcategoria";
    $stmex = $pdo->prepare($sqlex);
    $stmex->bindParam(':codcategoria', $codcategoria);
    if ($stmex->execute()) {
        echo "Categoria excluída com sucesso!";
    } else {
        echo "Erro ao excluir categoria.";
    }
} else {
    echo "Categoria não encontrada!";
}

header('Location: concategoria.php');
exit(); // Certifique-se de usar exit() para evitar a execução de código adicional após o redirecionamento.
?>
