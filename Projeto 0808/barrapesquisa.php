<?php
include_once('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $termo_pesquisa = $_POST["termo_pesquisa"];

    $pdo = conectar();

    $sql = "SELECT * FROM tb_produtos WHERE nomeprod LIKE :termo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":termo", "%" . $termo_pesquisa . "%");
    $stmt->execute();
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Agora, exiba os resultados da pesquisa
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultados da Pesquisa</title>
</head>
<body>
    <h2>Resultados da Pesquisa</h2>
    
    <div class="product-list">
        <div class="product-row">
            <?php
            if (!empty($produto)) {
                foreach ($produtos as $produto) {
                    ?>
                    <div class="product">
                        <img src="<?php echo $produto['produtoimg']; ?>" alt="<?php echo $produto['nomeprod']; ?>">
                        <h3><?php echo $produto['nomeprod']; ?></h3>
                        <p id="descricaoprod"><?php echo $produto['descricaoprod']; ?></p>
                            <button id="acesso">Comprar</button>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "Nenhum resultado encontrado.";
            }
            ?>
        </div>
    </div>
</body>
</html>