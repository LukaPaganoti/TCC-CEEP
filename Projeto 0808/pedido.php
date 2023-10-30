<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$sqlc = "SELECT * FROM tb_clientes";
$stmtc = $pdo->prepare($sqlc);
$stmtc->execute();
$dados = $stmtc->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferir detalhes do pedido</title>
</head>
<body>
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Codigo de Rastreio</label>
        <p>O codigo de rastreio sera mandado por e-mail</p>
        <p>O rementente do email é bendrownedstudios@gmail.com</p>
        <br><br>
        <label>Tipo de pedido</label>
        <select name="tipoped">
            <?php foreach ($dados as $d) {
                echo "<option value='{$d['tipoped']}'>{$d['tipoped']}</option>";
            } ?>
        </select>
        <br><br>
        <label>Tipo de pagamento</label>
        <select name="pagamento">
            <?php foreach ($dados as $d) {
                echo "<option value='{$d['Pix']}'>{$d['pagamento']}</option>";
            } ?>
        </select>
        <br><br>
        <label>Valor da entrega</label>
        <input type="text" name="valor_entrega">
        <br><br>
        <label>Cliente</label>
        <select name="fk_codcliente">
            <?php foreach ($dados as $d) {
                echo "<option value='{$d['codcliente']}'>{$d['nomecli']}</option>";
            } ?>
        </select>
        <br><br>
        <input type="submit" name="btncontinuar" value="Continuar" class="btn btn-dark">
    </form>
</body>
</html>

<?php
// Se o botão "Cadastrar" foi pressionado
if (isset($_POST['btnContinuar'])) {
    // Receba os dados do formulário
    $tipoped = $_POST['tipoped'];
    $pagamento = $_POST['pagamento'];
    $valor_entrega = $_POST['valor_entrega'];
    $fk_codcliente = $_POST['fk_codcliente'];

    if (empty($tipoped) || empty($pagamento) || empty($valor_entrega) || empty($fk_codcliente)) {
        echo "Preencha todos os campos.";
    } else {
        // Criar a consulta SQL de inserção
        $sqlc = "INSERT INTO tb_pedidos (tipoped, pagamento, valor_entrega, fk_codcliente) VALUES (:tipoped, :pagamento, :valor_entrega, :fk_codcliente)";

        // Preparar a consulta SQL para execução
        $stmt = $pdo->prepare($sqlc);

        // Associar os valores às variáveis na consulta SQL
        $stmt->bindParam(':tipoped', $tipoped);
        $stmt->bindParam(':pagamento', $pagamento);
        $stmt->bindParam(':valor_entrega', $valor_entrega);
        $stmt->bindParam(':fk_codcliente', $fk_codcategoria);

        // Executar a consulta SQL
        if ($stmt->execute()) {
            // Mensagem de cadastro bem-sucedido
            echo "Detalhes cadastrados!";
        } else {
            // Mensagem de erro
            echo "Erro ao mudar, confira os dados novamente!";
        }
    }
}
?>
</body>
</html>