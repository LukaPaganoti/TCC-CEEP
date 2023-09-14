<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

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
    <title>Cadastr um novo endereço</title>
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
        <input type="text" name="complemento">
        <br><br>
        <label>Cidade:</label>
        <select name="fk_cidade">
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
    $cepend = $_POST['cepend'];
    $numeroend = $_POST['numeroend'];
    $bairroend = $_POST['telefonecli'];
    $ruaend = $_POST['ruaend'];
    $senhacli = $_POST['senhacli'];
    $complementoend = $_POST['complementoend']
    

    // Validação simples
    if (empty($descricaocat)) {
        echo "É necessário informar uma descrição para a categoria";
        exit();
    }   

    // Criar a consulta SQL de inserção
    $sql = "INSERT INTO tb_categorias (descricaocat) VALUES (:descricaocat)";

    // Preparar a consulta SQL para execução
    $stmt = $pdo->prepare($sql);

    // Associar os valores às variáveis na consulta SQL
    $stmt->bindParam(':descricaocat', $descricaocat);

    // Executar a consulta SQL
    if ($stmt->execute()) {
        // Mensagem de cadastro bem-sucedido
        echo "Cadastro de categoria concluído com sucesso!";
    } else {
        // Mensagem de erro
        echo "Erro ao cadastrar, confira os dados novamente!";
    }
}
?>
