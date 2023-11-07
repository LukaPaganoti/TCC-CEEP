<?php
//session_start();
require_once "conexao.php";

$pdo = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailcli = filter_var($_POST['emailcli'], FILTER_SANITIZE_EMAIL);
    $senhacli = md5($_POST['senhacli']); // Criptografa a senha com MD5

    $stmt = $pdo->prepare("SELECT * FROM tb_clientes WHERE emailcli = :emailcli AND senhacli = :senhacli");
    $stmt->execute([':emailcli' => $emailcli, ':senhacli' => $senhacli]);
    $usuariocli = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuariocli) {
        // Senha correta, usuário autenticado
        session_start();
        $_SESSION['codcli'] = $usuariocli['codcli'];
        $_SESSION['emailcli'] = $usuariocli['emailcli'];

        if ($usuariocli['tipocadastro'] === 'A') {
            header("Location: telainicialadm.php");
            exit();
        } else {
            header("Location: telainicial.php");
            exit();
        }
    } else {
        echo "<p>Usuário ou senha inválidos. Tente novamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ptBR">
<head>
    <!-- Seus cabeçalhos e metatags aqui -->
</head>
<body>
    <div class="container">
        <form method="POST">
            <h2>Login</h2>
            <label>Email</label>
            <input type="text" name="emailcli" placeholder="Informe o email.">
            <br>
            <label>Senha</label>
            <input type="password" id="senhacli" name="senhacli" placeholder="Informe a senha.">
            <br>
            <br>
            <input type="submit" name="btnEntrar" value="Entrar">
            <input type="hidden" name="tp" value="x">
            <p class="link">
                Não tem uma conta?
                <a href="cadastrocliente.php">Ir para cadastro</a>
            </p>
        </form>
    </div>
</body>
</html>