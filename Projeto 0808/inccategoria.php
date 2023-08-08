<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Categoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>Cadastro de Categoria</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="descricaocat" class="form-control col-6" placeholder="Digite a descrição da categoria">
        </div>
        <button type="submit" name="btnSalvar" class="btn btn-primary">Salvar</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>

<?php
//fazer o teste se foi pressionado o botão
if (isset($_POST['btnSalvar'])) {

    // receba os dados do formulário
    // faça 1 para cada input
    $descricaocat = $_POST['descricaocat'];

    //validação simplificada - se o campo tá vazio
    if (empty($descricaocat)) {
        echo "Necessário informar a descrição da categoria";
        exit();
    }

    // criar o SQL de inserção
    $sql = "INSERT INTO tb_categorias (descricaocat) VALUES (:descricaocat)"; //variavel magica

    // preparar o SQL para execução (EVITA SQL INJECTION)
    $stmt = $pdo->prepare($sql);

    // trocar pelo valor da variavel magica pelo recebido via formulário
    $stmt->bindParam(':descricaocat', $descricaocat);

    // mandar realizar o codigo 
    if ($stmt->execute()) {
        //mostra mensagem de execução com sucesso
        echo "Categoria inserida com sucesso!";
        // envio a execução para outra pagina
        // header("Location: pagina.php");
    } else {
        echo "Erro ao inserir categoria";
    }
}
?>