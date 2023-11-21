<?php
session_start();
include_once("conexao.php");

// Verifique se a sessão está definida
if (isset($_SESSION['codcliente'])) {
    // Destrua a sessão
    session_destroy();

    // Redirecione para a tela inicial após o logoff
    header("Location: telainicial.php");
    exit();
} else {
    // Se a sessão não estiver definida, redirecione para a tela inicial de qualquer maneira
    header("Location: telainicial.php");
    exit();
}
?>