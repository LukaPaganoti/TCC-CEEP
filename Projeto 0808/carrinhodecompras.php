<?php
session_start();
include_once 'conexao.php'; // Certifique-se de que o arquivo 'conexao.php' existe

if (!isset($_SESSION['produto_prod'])) {
    $_SESSION['produto_prod'] = array();
}

// Defina $_SESSION['cod'] com o código do cliente logado, por exemplo, após a autenticação bem-sucedida
if (!isset($_SESSION['cod'])) {
    $_SESSION['cod'] = 1; // Substitua pelo código do cliente real
}

if (isset($_GET['acao'])) {
    if ($_GET['acao'] == 'add' && isset($_GET['cod'])) {
        $cod = intval($_GET['cod']);
        if (!isset($_SESSION['produto_prod'][$cod])) {
            $_SESSION['produto_prod'][$cod] = 1;
        } else {
            $_SESSION['produto_prod'][$cod]++;
        }
    } elseif ($_GET['acao'] == 'del' && isset($_GET['cod'])) {
        $cod = intval($_GET['cod']);
        if (isset($_SESSION['produto_prod'][$cod])) {
            unset($_SESSION['produto_prod'][$cod]);
        }
    }
}

if (isset($_POST['finalizaVenda'])) {

    // Certifique-se de que $_SESSION['precoped'] esteja corretamente definido
    if (!isset($_SESSION['precoped'])) {
        $_SESSION['precoped'] = 0;
    }

    $fk_codcliente = $_SESSION['cod']; // Substitua pelo valor correto
    $precoped = $_SESSION['precoped']; // Use o valor já calculado

    // Inserir a venda no banco de dados
    $sql = "INSERT INTO tb_pedidos_prod (fk_codpedido, fk_codproduto, precoped, quantidadeped) VALUES(:fk_codpedido, :fk_codproduto, :precoped, :quantidadeped)";

    $quantidadeped = 1; // Substitua pelo valor correto

    $stmip = $pdo->prepare($sql);

    // Adicione as variáveis $fk_codpedido e $fk_codproduto corretas aqui
    $fk_codpedido = 1; // Substitua pelo valor correto
    $fk_codproduto = 1; // Substitua pelo valor correto

    $stmip->bindValue(":fk_codpedido", $fk_codpedido);
    $stmip->bindValue(":fk_codproduto", $fk_codproduto);
    $stmip->bindValue(":precoped", $precoped);
    $stmip->bindValue(":quantidadeped", $quantidadeped);

    if ($stmip->execute()) {
        echo "Venda inserida com sucesso";
    } else {
        echo "Ocorreu um erro ao inserir a venda";
    }

    $venda = $pdo->lastInsertId();

    // Para cada item no carrinho, insira os detalhes da venda
    foreach ($_SESSION['produto_prod'] as $cod => $quantidadeped) {
        $sqlit = "INSERT INTO tb_produtos_prod (fk_codpedido, fk_codproduto, precoped, quantidadeped) VALUES (:fk_codpedido, :fk_codproduto, :precoped, :quantidadeped)";

        $stmit = $pdo->prepare($sqlit);

        // Adicione as variáveis $fk_codpedido e $fk_codproduto corretas aqui
        $fk_codpedido = 1; // Substitua pelo valor correto
        $fk_codproduto = $cod; // O código do produto vem do loop

        $stmit->bindValue(":fk_codpedido", $fk_codpedido);
        $stmit->bindValue(":fk_codproduto", $fk_codproduto);
        $stmit->bindValue(":precoped", $precoped);
        $stmit->bindValue(":quantidadeped", $quantidadeped);

        $stmit->execute();
    }

    // Limpe as sessões após a finalização da venda
    unset($_SESSION['produto_prod']);
    unset($_SESSION['precoped']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-3">Carrinho de Compras</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                    <th>Remover</th>
                </tr>
            </thead>
            <form action="?acao=up" method="post">
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2"><strong>R$ <?php echo $total; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <button type="submit" class="btn btn-primary">Atualizar Carrinho</button>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    if (count($_SESSION['produto_prod']) == 0) {
                        echo '<tr><td colspan="5">Não há produtos no carrinho</td></tr>';
                    } else {
                        foreach ($_SESSION['produto_prod'] as $codproduto => $item) {
                            $produto = $item['nomeprod'];
                            $quantidade = $item['quantidade'];
                            $preco = number_format($item['precoprod'], 2, ',', '.');
                            $subtotal = number_format($item['precoprod'] * $quantidade, 2, ',', '.');

                            echo '
                            <tr>
                                <td>' . $produto . '</td>
                                <td>
                                    <input type="number" name="produto_prod[' . $codproduto . ']" value="' . $quantidade . '" min="1">
                                </td>
                                <td>R$ ' . $preco . '</td>
                                <td>R$ ' . $subtotal . '</td>
                                <td><a href="?acao=del&cod=' . $codproduto . '" class="btn btn-danger">Remover</a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </form>
        </table>
        <a href="finalizar_venda.php" class="btn btn-success">Finalizar Compra</a>
    </div>
</body>
</html>