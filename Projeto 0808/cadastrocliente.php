<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Login e Cadastro </title>
                        
    </head>
    <body>
        <section class="container forms">
            <div class="form login">
                <div class="form-content">
                    <header>Login</header>
                    <form action="#">
                        <div class="field input-field">
                            <input type="email" name="emailcli" placeholder="Digite seu email" class="input">
                        </div>

                        <div class="field input-field">
                            <input type="password" name="senhacli" placeholder="Digite sua senha" class="password">
                            <i class='bx bx-hide eye-icon'></i>
                        </div>

                        <div class="form-link">
                            <a href="#" class="forgot-pass">Esqueceu a senha?</a>
                        </div>

                        <div class="field button-field">
                            <button>Login</button>
                        </div>
                    </form>

                    <div class="form-link">
                        <span>Não tem uma conta? <a href="#" class="link signup-link">Cadastre-se</a></span>
                    </div>
                </div>

                <div class="line"></div>

                <div class="media-options">
                    <a href="#" class="field google">
                        <img src="#" alt="" class="google-img">
                        <span>Login com o Google</span>
                    </a>
                </div>

            </div>

            <!-- Signup Form -->

            <div class="form signup">
                <div class="form-content">
                    <header>Cadastre-se</header>
                    <form action="#">

                        <div class="field input-field">
                            <input type="text" name="nomecli" placeholder="Nome completo" class="input">
                        </div>

                        <div class="field input-field">
                            <input type="text" name="telefonecli" placeholder="Telefone" class="input">
                        </div>

                        <div class="field input-field">
                            <input type="text" name="cpfcli" placeholder="Digite seu CPF" class="input">
                        </div>

                        <div class="field input-field">
                            <input type="password" name="senhacli" placeholder="Crie uma senha" class="password">
                            <i class='bx bx-hide eye-icon'></i>
                        </div>

                        <div class="field input-field">
                            <input type="text" name="usuariocli" placeholder="Crie um usuario" class="input">
                        </div>

                        <div class="field input-field">
                            <input type="email" name="emailcli" placeholder="Digite seu email" class="input">
                        </div>

                        <div class="field button-field">
                            <button>Cadastre-se</button>
                        </div>
                    </form>

                    <div class="form-link">
                        <span>Já tem uma conta? <a href="#" class="link login-link">Login</a></span>
                    </div>
                </div>

                <div class="line"></div>

                <div class="media-options">
                    <a href="#" class="field google">
                        <img src="#" alt="" class="google-img">
                        <span>Login com o Google</span>
                    </a>
                </div>

            </div>
        </section>

        <link rel="stylesheet" href="css/formulario.css">
        <script src="js/formulario.js"></script>
    </body>
</html>

<?php
// Se o botão "Cadastrar" foi pressionado
if (isset($_POST[''])) {
    // Receba os dados do formulário
    $nomecli = $_POST['nomecli'];
    $telefonecli = $_POST['telefonecli'];
    $cpfcli = $_POST['cpfcli'];
    $senhacli = $_POST['senhacli'];
    $usuariocli = $_POST['usuariocli'];
    $emailcli = $_POST['emailcli'];

    // Validação simples
    if (empty($nomecli)) {
        echo "É necessário informar seu nome completo";
        exit();
    }   
    if (empty($telefonecli)) {
        echo "É necessário informar seu telefone";
        exit();
    }
    if (empty($cpfcli)) {
        echo "É necessário informar seu CPF";
        exit();
    }
    if (empty($senhacli)) {
        echo "É necessário criar uma senha";
        exit();
    }
    if (empty($usuariocli)) {
        echo "É necessário criar um usuario";
        exit();
    }
    if (empty($emailcli)) {
        echo "É necessário informar um email";
        exit();
    }

    // Criar a consulta SQL de inserção
    $sql = "INSERT INTO tb_clientes (nomecli, telefonecli, cpfcli, senhacli, usuariocli, emailcli) VALUES (:nomecli, :telefonecli, :cpfcli, :senhacli, :usuariocli, :emailcli)";

    // Preparar a consulta SQL para execução
    $stmt = $pdo->prepare($sql);

    // Associar os valores às variáveis na consulta SQL
    $stmt->bindParam(':nomecli', $nomecli);
    $stmt->bindParam(':telefonecli', $telefonecli);
    $stmt->bindParam(':cpfcli', $cpfcli);
    $stmt->bindParam(':senhacli', $senhacli);
    $stmt->bindParam(':usuariocli', $usuariocli);
    $stmt->bindParam(':emailcli', $emailcli);

    // Executar a consulta SQL
    if ($stmt->execute()) {
        // Mensagem de cadastro bem-sucedido
        echo "Cadastro concluído com sucesso!";
    } else {
        // Mensagem de erro
        echo "Erro ao cadastrar, confira seus dados novamente!";
    }
}
?>