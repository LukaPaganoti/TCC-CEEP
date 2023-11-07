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

$sqlcli = "SELECT * FROM tb_clientes";
$stmtcli = $pdo->prepare($sqlcli);
$stmtcli->execute();
$dadoscli = $stmtcli->fetchAll(PDO::FETCH_ASSOC);
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
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Código de Rastreio</label>
        <p>O código de rastreio será enviado por e-mail</p>
        <p>O remetente do email é bendrownedstudios@gmail.com</p>
        <br><br>
        <label>Tipo de pedido</label>
        <select name="tipoped" required>
            <option value="1" <?php if (isset($pedido) && $pedido['tipoped'] == 1) echo 'selected'; ?>>PIX</option>
            <option value="2" <?php if (isset($pedido) && $pedido['tipoped'] == 2) echo 'selected'; ?>>DINHEIRO</option>
        </select>
        <br><br>
        <label>Tipo de pagamento</label>
        <select name="pagamento">
            <option value="1" <?php if (isset($pedido) && $pedido['pagamento'] == 1) echo 'selected'; ?>>Entrega</option>
            <option value="2" <?php if (isset($pedido) && $pedido['pagamento'] == 2) echo 'selected'; ?>>Retirada</option>
        </select>
        <br><br>
        <label>Valor da entrega</label>
        <input type="text" name="valor_entrega" value="<?php if (isset($pedido)) echo $pedido['valor_entrega']; ?>">
        <br><br>
        <label>Cliente</label>
        <select name="fk_codcliente">
            <?php foreach ($dadoscli as $d) {
                echo "<option value='{$d['codcliente']}'";
                if (isset($pedido) && $d['codcliente'] == $pedido['fk_codcliente']) {
                    echo ' selected';
                }
                echo ">{$d['nomecli']}</option>";
            } ?>
        </select>
        <br><br>
        <input type="submit" name="btnContinuar" value="Continuar" class="btn btn-dark">
    </form>
</body>
</html>

<?php
// Se o botão "Continuar" foi pressionado
if (isset($_POST['btnContinuar'])) {
    // Receba os dados do formulário
    $tipoped = $_POST['tipoped'];
    $pagamento = $_POST['pagamento'];
    $valor_entrega = $_POST['valor_entrega'];
    $fk_codcliente = $_POST['fk_codcliente'];

    if (empty($tipoped) || empty($pagamento) || empty($valor_entrega) || empty($fk_codcliente)) {
        echo "Preencha todos os campos.";
    } else {
        // Criar a consulta SQL de atualização
        $sql_atualizacao = "UPDATE tb_pedidos SET tipoped = :tipoped, pagamento = :pagamento, valor_entrega = :valor_entrega, fk_codcliente = :fk_codcliente WHERE codpedido = :codpedido";

        // Preparar a consulta SQL para execução
        $stmt = $pdo->prepare($sql_atualizacao);

        // Associar os valores às variáveis na consulta SQL
        $stmt->bindParam(':tipoped', $tipoped);
        $stmt->bindParam(':pagamento', $pagamento);
        $stmt->bindParam(':valor_entrega', $valor_entrega);
        $stmt->bindParam(':fk_codcliente', $fk_codcliente);
        $stmt->bindParam(':codpedido', $codpedido);

        // Executar a consulta SQL
        if ($stmt->execute()) {
            // Mensagem de atualização bem-sucedida
            echo "Detalhes atualizados!";
        } else {
            // Mensagem de erro
            echo "Erro ao atualizar, confira os dados novamente!";
        }
    }
}
?>
</body>
</html>