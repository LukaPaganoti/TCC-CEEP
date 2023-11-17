<?php

session_start();
include_once "conexao.php";
$pdo = conectar();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Produtos</title>
</head>
<body>
    <h1>Pesquisa de Produtos</h1>
    <form method="post">
        <label for="pesquisa">Pesquisar Produto:</label>
        <input type="text" id="pesquisa" name="pesquisa" placeholder="Digite o código ou modelo">
        <input type="submit" name="btnpesquisar" value="Pesquisar">
    </form>

    <?php
    if (isset($_POST['btnpesquisar'])) {
        $pdo = conectar();

        $pesquisa = $_POST['pesquisa'];

        // Consulta SQL para buscar produtos com base no código ou modelo físico
        $sql = "SELECT * FROM tb_produtos WHERE codproduto = :pesquisa OR nomeprod LIKE :pesquisa";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pesquisa', $pesquisa);

        if ($stmt->execute()) {
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($resultados) > 0) {
                echo "<h2>Resultados da Pesquisa:</h2>";
                echo "<ul>";
                foreach ($resultados as $produto) {
                    echo "<li>Código: {$produto['codproduto']} - Nome: {$produto['nomeprod']} - Preço: {$produto['precoprod']}</li>";
                }
                echo "</ul>";
            } else {
                echo "Nenhum resultado encontrado.";
            }
        } else {
            echo "Erro na consulta ao banco de dados.";
        }
    }
    ?>
</body>
</html>