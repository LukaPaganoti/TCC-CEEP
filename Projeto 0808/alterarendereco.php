<?php
include_once("conexao.php");
$pdo = conectar();

$codendereco = isset($_GET['cod']) ? $_GET['cod'] : null;

// Verifica se 'cod' está definido na URL
    // Recupera os dados do endereço
    $sql = "SELECT * FROM tb_enderecos WHERE codendereco = :cod";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":cod", $codendereco);
    $stmt->execute();

    // Verifica se a consulta retornou resultados
    $resultados = $stmt->fetch(PDO::FETCH_ASSOC);


        // Exibe o valor de fk_codcidade para fins de depuração
        // var_dump($resultados['fk_codcidade']);

        // Recupera todas as cidades do banco de dados
        $sqlc = "SELECT * FROM tb_cidades";
        $stmtc = $pdo->prepare($sqlc);
        $stmtc->execute();
        $cidades = $stmtc->fetchAll(PDO::FETCH_ASSOC);

        // Exibe as cidades para fins de depuração
        // var_dump($cidades);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Alterar Dados</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Alteração de Dados</h2>
        <form method="POST" name="enderecoform">
            <div class="form-group">
                <label>Alterar Rua:</label>
                <input type="text" name="rua_editado" value="<?= htmlspecialchars($resultados['ruaend'] ?? ''); ?>" class="form-control">
                <br>
                <label>Alterar CEP:</label>
                <input type="text" name="cep_editado" value="<?= htmlspecialchars($resultados['cepend'] ?? ''); ?>" class="form-control">
                <br>
                <label>Alterar número:</label>
                <input type="text" name="numero_editado" value="<?= htmlspecialchars($resultados['numeroend'] ?? ''); ?>" class="form-control">
                <br>
                <label>Alterar bairro:</label>
                <input type="text" name="bairro_editado" value="<?= htmlspecialchars($resultados['bairroend'] ?? ''); ?>" class="form-control">
                <br>
                <label>Alterar complemento:</label>
                <input type="text" name="complemento_editado" value="<?= htmlspecialchars($resultados['complementoend'] ?? ''); ?>" class="form-control">
                <br>
                <label>Cidade:</label>
                <select name="fk_codcidade" class="form-control">
                    <option value="">Selecione</option>
                    <?php foreach ($cidades as $c) { ?>
                        <option value="<?= $c['codcidade']; ?>" <?php echo ($c['codcidade'] == $resultados['fk_codcidade']) ? 'selected' : ''; ?>>
                            <?= $c['nomecid']; ?>
                        </option>
                    <?php } ?>
                </select>
                <br>
                <input type="submit" name="btnAlterar" value="Alterar" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST['btnAlterar'])){
    $ruaend = $_POST['rua_editado'];
    $cepend = $_POST['cep_editado'];
    $numeroend = $_POST['numero_editado'];
    $bairroend = $_POST['bairro_editado'];
    $complementoend = $_POST['complemento_editado'];
    $fk_codcidade = $_POST['fk_codcidade'];

    $sqlup = "UPDATE tb_enderecos SET ruaend = :ruaend, cepend = :cepend, numeroend = :numeroend, bairroend = :bairroend, complementoend = :complementoend, fk_codcidade = :fk_codcidade WHERE codendereco = :codendereco";
    
    $stmt = $pdo->prepare($sqlup);

    $stmt->bindParam(':ruaend', $ruaend);
    $stmt->bindParam(':cepend', $cepend);
    $stmt->bindParam(':numeroend', $numeroend);
    $stmt->bindParam(':bairroend', $bairroend);
    $stmt->bindParam(':complementoend', $complementoend);
    $stmt->bindParam(':fk_codcidade', $fk_codcidade);
    $stmt->bindParam(':codendereco', $codendereco);

    if ($stmt->execute()) {
        echo "Alteração de dados concluída com sucesso!";

        echo "<script type='text/javascript'>window.location = 'telainicial.php';</script>";
    } else {
        // Redireciona após a operação
        echo "Erro ao alterar, confira os dados novamente!";
    }
}
?>