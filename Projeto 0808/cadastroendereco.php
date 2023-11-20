<?php
session_start();
include_once 'conexao.php';

// Verifique se o cliente está logado
if (!isset($_SESSION['codcliente'])) {
    // Se não estiver logado, redirecione para a página de login
    header("Location: login.php");
    exit();
}

// Estabeleça a conexão com o banco de dados
$pdo = conectar();

// Recupere o código do cliente a partir da sessão
$codcliente = $_SESSION['codcliente'];

$sqlc = "SELECT * FROM tb_cidades";
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
    <title>Cadastre um novo endereço</title>
</head>
<body>
    <form method="post" class="form-group" enctype="multipart/form-data">
        <label>Digite o nome da rua:</label>
        <input type="text" name="ruaend">
        <br><br>
        <label>Digite o CEP:</label>
        <input type="text" name="cepend">
        <br><br>
        <label>Digite o numero da casa:</label>
        <input type="text" name="numeroend">
        <br><br>
        <label>Digite o bairro:</label>
        <input type="text" name="bairroend">
        <br><br>
        <label>Complemento (Apartamento):</label>
        <input type="text" name="complementoend">
        <br><br>
        <label>Cidade:</label>
        <select name="fk_codcidade">
            <?php foreach ($dados as $d) {
                echo "<option value='{$d['codcidade']}'>{$d['nomecid']} ({$d['estadocid']})</option>";
            } ?>
        </select>
        <input type="submit" name="btncadastroendereco" value="Salvar endereço" class="btn btn-dark">
    </form>
</body>
</html>

<?php
// Se o botão "Cadastrar" foi pressionado
if (isset($_POST['btncadastroendereco'])) {
    // Receba os dados do formulário
    $ruaend = $_POST['ruaend'];
    $cepend = $_POST['cepend'];
    $numeroend = $_POST['numeroend'];
    $bairroend = $_POST['bairroend'];
    $complementoend = $_POST['complementoend'];
    $fk_codcidade = $_POST['fk_codcidade'];

    // Validação simples  
    if (empty($ruaend) || empty($cepend) || empty($numeroend) || empty($bairroend)) {
        echo "Preencha todos os campos obrigatórios.";
    } else {
        // Criar a consulta SQL de inserção
        $sql = "INSERT INTO tb_enderecos (ruaend, cepend, numeroend, bairroend, complementoend, fk_codcidade, fk_codcliente) VALUES (:ruaend, :cepend, :numeroend, :bairroend, :complementoend, :fk_codcidade, :fk_codcliente)";

        // Preparar a consulta SQL para execução
        $stmt = $pdo->prepare($sql);

        // Associar os valores às variáveis na consulta SQL
        $stmt->bindParam(':ruaend', $ruaend);
        $stmt->bindParam(':cepend', $cepend);
        $stmt->bindParam(':numeroend', $numeroend);
        $stmt->bindParam(':bairroend', $bairroend);
        $stmt->bindParam(':complementoend', $complementoend);
        $stmt->bindParam(':fk_codcidade', $fk_codcidade);
        $stmt->bindParam(':fk_codcliente', $codcliente);

        // Executar a consulta SQL
        try {
            if ($stmt->execute()) {
                // Mensagem de cadastro bem-sucedido
                echo "Endereço adicionado com sucesso!";
                echo "<a href='telainicial.php'>Ir para tela inicial.</a>";
            } else {
                // Mensagem de erro
                echo "Erro ao adicionar, confira os dados novamente!";
            }
        } catch (PDOException $e) {
            echo "Erro na execução da consulta: " . $e->getMessage();
        }
    }
}
?>
