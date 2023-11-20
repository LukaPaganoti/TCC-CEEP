<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

include_once 'conexao.php';

if (!isset($_SESSION['produto_prod'])) {
    $_SESSION['produto_prod'] = array();
}

// Outras verificações e ações...

// Calcular o total do carrinho
$total = 0;

foreach ($_SESSION['produto_prod'] as $codproduto => $item) {
    $quantidade = $item['quantidade'];
    $precoprod = $item['precoprod'];
    $total += $quantidade * $precoprod;
}

// Formatando o total como moeda
$totalFormatado = number_format($total, 2, ',', '.');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['finalizar_compra'])) {
    // Verificar se o cliente está autenticado
    if (isset($_SESSION['codcliente'])) {
        $codCliente = $_SESSION['codcliente'];

        // Lógica para salvar os dados no banco de dados
        $pdo->beginTransaction(); // Inicia uma transação para garantir a consistência dos dados

        try {
            // Insira o pedido na tabela tb_pedidos e obtenha o código do pedido inserido
            $stmtPedido = $pdo->prepare("INSERT INTO tb_pedidos (fk_codcliente) VALUES (:fk_codcliente)");
            $stmtPedido->bindParam(':fk_codcliente', $codCliente, PDO::PARAM_INT);
            $stmtPedido->execute();
            $codPedido = $pdo->lastInsertId();

            // Itera sobre os itens do carrinho e insere na tabela tb_pedidos_prod
            foreach ($_SESSION['produto_prod'] as $codproduto => $item) {
                $quantidade = $item['quantidade'];
                $codproduto = intval($codproduto);

                // Consulta para obter as informações do produto
                $stmtProduto = $pdo->prepare("SELECT precoprod FROM tb_produtos WHERE codproduto = :codproduto");
                $stmtProduto->bindParam(':codproduto', $codproduto, PDO::PARAM_INT);
                $stmtProduto->execute();
                $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

                if ($produto) {
                    $precoprod = $produto['precoprod'];
                    $subtotal = $precoprod * $quantidade;

                    // Insere o item na tabela tb_pedidos_prod
                    $stmtPedidoProd = $pdo->prepare("INSERT INTO tb_pedidos_prod (fk_codpedido, fk_codproduto, precoped, quantidadeped) VALUES (:fk_codpedido, :fk_codproduto, :precoped, :quantidadeped)");
                    $stmtPedidoProd->bindParam(':fk_codpedido', $codPedido, PDO::PARAM_INT);
                    $stmtPedidoProd->bindParam(':fk_codproduto', $codproduto, PDO::PARAM_INT);
                    $stmtPedidoProd->bindParam(':precoped', $precoprod, PDO::PARAM_STR);
                    $stmtPedidoProd->bindParam(':quantidadeped', $quantidade, PDO::PARAM_STR);
                    $stmtPedidoProd->execute();
                } else {
                    echo 'Produto não encontrado.';
                }
            }

            // Confirma a transação
            $pdo->commit();

            // Limpa o carrinho após a finalização da compra
            $_SESSION['produto_prod'] = array();

            // Redireciona o cliente para a tela inicial do site
            header('Location: telainicial.php');
            exit; // Certifique-se de sair após redirecionar para evitar execução adicional
        } catch (PDOException $e) {
            // Em caso de erro, desfaz a transação e exibe uma mensagem de erro
            $pdo->rollBack();
            exit('Erro ao finalizar a compra: ' . $e->getMessage());
        }
    } else {
        // Se o cliente não estiver autenticado, redirecione para a página de login
        header('Location: login.php');
        exit;
    }
}
// Pode exibir uma mensagem de sucesso aqui, se necessário
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
                <!-- Cabeçalho da tabela -->
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
                                <td><button type="button" data-codproduto="' . $codproduto . '" class="btn btn-danger btn-remover">Remover</button></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2" id="total"><strong>R$ <?php echo $totalFormatado; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <a href="telainicial.php" class="btn btn-primary">Continuar Comprando</a>
                            <button type="submit" class="btn btn-success" name="finalizar_compra" id="btnFinalizar">Finalizar Compra</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
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

        // Adiciona um ouvinte de eventos de clique ao botão de atualizar carrinho
        var btnAtualizar = document.getElementById('btnAtualizar');
        btnAtualizar.addEventListener('click', function (event) {
            // Impede que o formulário seja enviado, pois iremos tratar via AJAX
            event.preventDefault();
            atualizarCarrinho();
        });

        // Adiciona um ouvinte de eventos de clique ao botão de finalizar compra
        var btnFinalizar = document.getElementById('btnFinalizar');
        btnFinalizar.addEventListener('click', function (event) {
            // Impede que o formulário seja enviado, pois iremos tratar via AJAX ou redirecionamento
            event.preventDefault();
            finalizarCompra();
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
            var codProduto = botao.dataset.codproduto;
            var linhaProduto = document.getElementById('linha_produto_' + codProduto);
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

            // Chama uma função (pode ser uma requisição AJAX) para atualizar o carrinho no servidor se necessário
            atualizarCarrinho();
        }

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

        // Função para finalizar a compra
        function finalizarCompra() {
            // Implemente o código aqui para finalizar a compra, seja via AJAX ou redirecionamento
            // Exemplo fictício:
            fetch('relatorio_pedido.php', {
                method: 'POST',
                body: JSON.stringify({ /* Envie os detalhes da compra aqui */ }),
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                // Faça algo com a resposta do servidor, se necessário
                // Redireciona para o perfil após finalizar a compra
                window.location.href = 'perfil.php';
            })
            .catch(error => console.error('Erro ao finalizar compra:', error));
        }
    });
    </script>
</body>
</html>