<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

if (isset($_GET['codpedido'])) {
    $codpedido = $_GET['codpedido'];

    // Consulta SQL para obter os detalhes do pedido com base no ID
    $sql_pedido = "SELECT * FROM tb_pedidos WHERE codpedido = :codpedido";
    $stmt_pedido = $pdo->prepare($sql_pedido);
    $stmt_pedido->bindParam(':codpedido', $codpedido);
    $stmt_pedido->execute();
    $pedido = $stmt_pedido->fetch(PDO::FETCH_ASSOC);

    if (isset($_SESSION['codcliente'])) {
        $codcliente = $_SESSION['codcliente'];

        // Consulta SQL para obter os dados do endereço do cliente logado
        $sql_endereco_cliente = "SELECT * FROM tb_enderecos WHERE fk_codcliente = :fk_codcliente";
        $stmt_endereco_cliente = $pdo->prepare($sql_endereco_cliente);
        $stmt_endereco_cliente->bindParam(':fk_codcliente', $codcliente);
        $stmt_endereco_cliente->execute();
        $endereco_cliente = $stmt_endereco_cliente->fetch(PDO::FETCH_ASSOC);
    }
}

// Consulta SQL para obter os dados do cliente logado
if (isset($_SESSION['codcliente'])) {
    $codcliente = $_SESSION['codcliente'];
    $sql_cliente = "SELECT * FROM tb_clientes WHERE codcliente = :codcliente";
    $stmt_cliente = $pdo->prepare($sql_cliente);
    $stmt_cliente->bindParam(':codcliente', $codcliente);
    $stmt_cliente->execute();
    $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
}

// Adiciona os detalhes do carrinho de compras à tabela tb_pedidos_prod
if (isset($_POST['btnFinalizar'])) {
    $tipoped = $_POST['tipoped'];
    $pagamento = $_POST['pagamento'];
    $fk_codcliente = $_POST['fk_codcliente'];

    if (empty($tipoped) || empty($pagamento) || empty($fk_codcliente)) {
        echo "Preencha todos os campos.";
    } else {
        // Criação do pedido
        $sql_criar_pedido = "INSERT INTO tb_pedidos (fk_codcliente, tipoped, pagamento, valor_entrega) VALUES (:fk_codcliente, :tipoped, :pagamento, :valor_entrega)";
        $stmt_criar_pedido = $pdo->prepare($sql_criar_pedido);
        $stmt_criar_pedido->bindParam(':fk_codcliente', $fk_codcliente);
        $stmt_criar_pedido->bindParam(':tipoped', $tipoped);
        $stmt_criar_pedido->bindParam(':pagamento', $pagamento);
        $stmt_criar_pedido->bindValue(':valor_entrega', 0); // Defina o valor da entrega conforme necessário

        // Executa a inserção do pedido
        if ($stmt_criar_pedido->execute()) {
            // Recupera o ID do pedido recém-criado
            $codpedido = $pdo->lastInsertId();

            // Adiciona os produtos do carrinho à tabela tb_pedidos_prod
            foreach ($_SESSION['produto_prod'] as $codproduto => $item) {
                $quantidade = $item['quantidade'];
                $precoped = $item['precoprod'];

                // Insere os produtos na tabela tb_pedidos_prod
                $sql_inserir_produto = "INSERT INTO tb_pedidos_prod (fk_codpedido, fk_codproduto, quantidadeped, precoped) VALUES (:fk_codpedido, :fk_codproduto, :quantidadeped, :precoped)";
                $stmt_inserir_produto = $pdo->prepare($sql_inserir_produto);
                $stmt_inserir_produto->bindParam(':fk_codpedido', $codpedido);
                $stmt_inserir_produto->bindParam(':fk_codproduto', $codproduto);
                $stmt_inserir_produto->bindParam(':quantidadeped', $quantidade);
                $stmt_inserir_produto->bindParam(':precoped', $precoped);

                // Executa a inserção do produto
                $stmt_inserir_produto->execute();
            }

            // Limpa o carrinho após o pedido ser finalizado
            unset($_SESSION['produto_prod']);

            // Redireciona ou executa outras ações após o pedido ser finalizado
            header("Location: telainicial.php");
        } else {
            echo "Erro ao criar o pedido.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferir detalhes do pedido</title>
</head>
<body>
    <br><br>
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Cliente</label>
        <select name="fk_codcliente">
            <?php
            // Se houver um cliente logado, mostre apenas esse cliente no dropdown
            if (isset($cliente)) {
                echo "<option value='{$cliente['codcliente']}' selected>{$cliente['nomecli']}</option>";
            }
            ?>
        </select>
        <br><br>
        <label>Endereço</label>
        <select name="fk_codendereco">
            <?php
            // Se houver um cliente logado, mostre os endereços desse cliente no dropdown
            if (isset($cliente)) {
                // Consulta SQL para obter os endereços do cliente logado
                $sql_enderecos_cliente = "SELECT * FROM tb_enderecos WHERE fk_codcliente = :fk_codcliente";
                $stmt_enderecos_cliente = $pdo->prepare($sql_enderecos_cliente);
                $stmt_enderecos_cliente->bindParam(':fk_codcliente', $cliente['codcliente']);
                $stmt_enderecos_cliente->execute();
                $enderecos_cliente = $stmt_enderecos_cliente->fetchAll(PDO::FETCH_ASSOC);

                // Exibe os endereços do cliente no dropdown
                foreach ($enderecos_cliente as $endereco) {
                    echo "<option value='{$endereco['codendereco']}'>{$endereco['ruaend']}, {$endereco['numeroend']} - {$endereco['bairroend']}</option>";
                }
            }
            ?>
        </select>
        <br><br>
        <label>Tipo de pedido</label>
        <select name="tipoped" required>
            <option value="1" <?php if (isset($pedido) && $pedido['tipoped'] == 1) echo 'selected'; ?>>Entrega</option>
            <option value="2" <?php if (isset($pedido) && $pedido['tipoped'] == 2) echo 'selected'; ?>>Retirada</option>
        </select>
        <br><br>
        <label>Forma de pagamento</label>
        <select name="pagamento" required>
            <option value="Dinheiro" <?php if (isset($pedido) && $pedido['pagamento'] == 'Dinheiro') echo 'selected'; ?>>Dinheiro</option>
            <option value="Pix" <?php if (isset($pedido) && $pedido['pagamento'] == 'Pix') echo 'selected'; ?>>A opção Pix não está disponível agora.</option>
        </select>
        <br><br>
        <!-- Substituído o botão de "Finalizar Pedido" por um botão de redirecionamento -->
        <a href="carrinhodecompras.php" class="btn-carrinho">Ver Carrinho</a>
    </form>
    <br><br>
</body>
</html>