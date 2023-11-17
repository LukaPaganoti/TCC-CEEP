<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

include_once 'conexao.php';

if (!isset($_SESSION['produto_prod'])) {
    $_SESSION['produto_prod'] = array();
}

// Outras verificações e ações...

// Seção para recuperar dados do banco de dados
$total = 0; // Inicializa a variável total

foreach ($_SESSION['produto_prod'] as $codproduto => $item) {
    $quantidade = $item['quantidade'];
    $codproduto = intval($codproduto);

    // Consulta para obter as informações do produto
    $stmt = $pdo->prepare("SELECT nomeprod, precoprod FROM tb_produtos WHERE codproduto = :codproduto");
    $stmt->bindParam(':codproduto', $codproduto, PDO::PARAM_INT);

    // Verificar se a execução ocorre sem erros
    try {
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            $nomeprod = $produto['nomeprod'];
            $precoprod = $produto['precoprod'];
            $subtotal = $precoprod * $quantidade;

            // Atualiza o total
            $total += $subtotal;

            // Exibe os dados na tabela HTML
            echo '
            <tr>
                <td>' . $nomeprod . '</td>
                <td>
                    <input type="number" name="produto_prod[' . $codproduto . ']" value="' . $quantidade . '" min="1">
                </td>
                <td>R$ ' . number_format($precoprod, 2, ',', '.') . '</td>
                <td>R$ ' . number_format($subtotal, 2, ',', '.') . '</td>
                <td><a href="?acao=del&cod=' . $codproduto . '" class="btn btn-danger">Remover</a></td>
            </tr>';
        } else {
            echo 'Produto não encontrado.';
        }
    } catch (PDOException $e) {
        // Exibe qualquer exceção (erro) que ocorra durante a execução da consulta
        exit('Erro na execução da consulta: ' . $e->getMessage());
    }
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
        <form action="?acao=up" method="post">
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
                <tbody>
                    <!-- Seção de exibição de produtos no carrinho -->
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
            </table>
        </form>
        <a href="pedido.php" class="btn btn-success">Proximo</a>
    </div>
</body>
</html>