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
<tr id="linha_produto_' . $codproduto . '">
    <td>' . $produto . '</td>
    <td>
        <input type="number" name="produto_prod[' . $codproduto . ']" value="' . $quantidade . '" min="1" class="quantidade-input">
    </td>
    <td>R$ ' . $preco . '</td>
    <td class="subtotal" data-preco="' . $item['precoprod'] . '">R$ ' . $subtotal . '</td>
    <td><a href="javascript:void(0);" class="btn btn-danger btn-remover">Remover</a></td>
</tr>';
        }
    }
    ?>
</tbody>
<tfoot>
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td colspan="2" id="total"><strong>R$ <?php echo $total; ?></strong></td>
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
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Adiciona um ouvinte de eventos de mudança de quantidade a todos os campos de entrada
        var quantidadeInputs = document.querySelectorAll('.quantidade-input');
        quantidadeInputs.forEach(function (input) {
            input.addEventListener('change', function () {
                atualizarTotais(input);
            });
        });

        // Adiciona um ouvinte de eventos de clique aos botões de remoção
        var botoesRemover = document.querySelectorAll('.btn-remover');
        botoesRemover.forEach(function (botao) {
            botao.addEventListener('click', function () {
                removerProduto(botao);
            });
        });

        // Função para atualizar os totais com base nas alterações na quantidade
        function atualizarTotais(input) {
            var linhaProduto = input.closest('tr');
            var precoUnitario = parseFloat(linhaProduto.querySelector('.subtotal').dataset.preco);
            var quantidade = parseInt(input.value);
            var novoSubtotal = precoUnitario * quantidade;

            // Atualiza o subtotal na tabela
            linhaProduto.querySelector('.subtotal').textContent = 'R$ ' + novoSubtotal.toFixed(2);

            // Chama uma função (pode ser uma requisição AJAX) para atualizar o total no servidor se necessário
            atualizarTotal();
        }

        // Função para calcular e atualizar o total
        function atualizarTotal() {
            var totais = document.querySelectorAll('.subtotal');
            var total = 0;

            totais.forEach(function (subtotal) {
                total += parseFloat(subtotal.textContent.replace('R$ ', ''));
            });

            // Atualiza o total na interface do usuário
            document.querySelector('#total').textContent = 'R$ ' + total.toFixed(2);
        }

        // Função para remover um produto do carrinho
        function removerProduto(botao) {
            var linhaProduto = botao.closest('tr');
            var precoUnitario = parseFloat(linhaProduto.querySelector('.subtotal').dataset.preco);
            var quantidade = parseInt(linhaProduto.querySelector('.quantidade-input').value);

            // Atualiza o total subtraindo o subtotal do produto removido
            var subtotalRemovido = precoUnitario * quantidade;
            var totalAtual = parseFloat(document.querySelector('#total').textContent.replace('R$ ', ''));
            var novoTotal = totalAtual - subtotalRemovido;

            // Atualiza o total na interface do usuário
            document.querySelector('#total').textContent = 'R$ ' + novoTotal.toFixed(2);

            // Remove a linha do produto da tabela
            linhaProduto.remove();

            // Função para atualizar o carrinho no servidor (exemplo de requisição AJAX)
function atualizarCarrinho() {
    // Implemente o código aqui para enviar os detalhes do carrinho para o servidor usando AJAX
    // Você pode usar a função fetch ou outras bibliotecas AJAX, como jQuery.ajax
    // Exemplo fictício:
    fetch('atualizar_carrinho.php', {
        method: 'POST',
        body: JSON.stringify({ /* Envie os detalhes do carrinho aqui */ }),
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        // Faça algo com a resposta do servidor, se necessário
    })
    .catch(error => console.error('Erro ao atualizar carrinho:', error));
}
        }
    });
</script>
</body>
</html>