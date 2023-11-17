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
        <label>Tipo de pedido</label>
        <select name="tipoped" required>
            <option value="1" <?php if (isset($pedido) && $pedido['tipoped'] == 1) echo 'selected'; ?>>A opção pix não está disponível no momento</option>
            <option value="2" <?php if (isset($pedido) && $pedido['tipoped'] == 2) echo 'selected'; ?>>DINHEIRO</option>
        </select>
        <br><br>
        <label>Tipo de pagamento</label>
        <select name="pagamento">
            <option value="1" <?php if (isset($pedido) && $pedido['pagamento'] == 1) echo 'selected'; ?>>Entrega</option>
            <option value="2" <?php if (isset($pedido) && $pedido['pagamento'] == 2) echo 'selected'; ?>>Retirada</option>
        </select>
        <br><br>
        <br><br>
        <p> O valor da entrega estará disponível dentro de algum tempo!<p>
        <p> O código de rastreio será adicionado logo após a confirmação do pagamento!<p>
        <br><br>
        <input type="submit" name="btnFinalizar" value="Finalizar">
    </form>

    <?php
    // Se o botão "Finalizar" foi pressionado
    if (isset($_POST['btnFinalizar'])) {
        // Receba os dados do formulário
        $tipoped = $_POST['tipoped'];
        $pagamento = $_POST['pagamento'];
        $fk_codcliente = $_POST['fk_codcliente'];

        if (empty($tipoped) || empty($pagamento) || empty($fk_codcliente)) {
            echo "Preencha todos os campos.";
        } else {
            // Criar a consulta SQL de atualização
            $sql_atualizacao = "UPDATE tb_pedidos SET tipoped = :tipoped, pagamento = :pagamento, fk_codcliente = :fk_codcliente WHERE codpedido = :codpedido";

            // Preparar a consulta SQL para execução
            $stmt = $pdo->prepare($sql_atualizacao);

            // Associar os valores às variáveis na consulta SQL
            $stmt->bindParam(':tipoped', $tipoped);
            $stmt->bindParam(':pagamento', $pagamento);;
            $stmt->bindParam(':fk_codcliente', $fk_codcliente);
            $stmt->bindParam(':codpedido', $codpedido);

            // Executar a consulta SQL
            if ($stmt->execute()) {
                // Mensagem de atualização bem-sucedida
                echo "Detalhes atualizados!";

                // Redirecionar para a página desejada após a atualização (opcional)
                header("Location: telainicial.php");
                // exit();
            } else {
                // Mensagem de erro
                echo "Erro ao atualizar, confira os dados novamente!";
            }
        }
    }
    ?>
</body>
</html>