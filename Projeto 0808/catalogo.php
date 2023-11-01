<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();

$sql = "SELECT * FROM tb_produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute(); // Corrigido o typo de $smt para $stmt
$rprd = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/mask.js">
    </script>
    <link rel="stylesheet" type="text/css" href="css/catalogo.css">
</head>
/
<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
<header>
    <h1>Catálogo de Produtos</h1>
    <div class="return">
        <a href="index.php">&lt; Voltar à Página Inicial</a>
    </div>
</header>
<div class="product-container">
    <h2>Produtos</h2>
    <div class="row">
        <?php
        foreach ($rprd as $produto) : // Corrigido o uso da variável $produto
        ?>
            <div class="col-sm-4">
                <div class="card">
                <img src="img/<?php echo $produto['produtoimg'];?> "alt="Imagem do Produto" width="150px" height="150px">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $produto['nomeprod']; ?></h5>
                        <p class="card-text"><?php echo $produto['descricaoprod']; ?></p>
                        <p class="card-text">Preço: R$<?php echo number_format($produto['precoprod'], 2, ',', '.'); ?></p>
                        <button type="submit" class="button-comprar">COMPRAR</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
